<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Modules\Karya\Models\Karya;

class ApiSanctumTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test API write operations require Sanctum token authentication.
     */
    public function test_api_write_requires_sanctum_token(): void
    {
        // 1. Try to post karya without token
        $responseKarya = $this->postJson(route('api.v1.karyas.store'), [
            'judul' => 'Karya API Test',
            'kategori' => 'Web App',
            'deskripsi' => 'Deskripsi',
            'tim_pembuat' => 'Tim API',
            'tahun' => 2026,
        ]);
        $responseKarya->assertStatus(401);

        // 2. Try to post review without token
        $responseReview = $this->postJson(route('api.v1.reviews.store', 1), [
            'rating' => 5,
            'comment' => 'Mantap',
        ]);
        $responseReview->assertStatus(401);
    }

    /**
     * Test API login gives token, and user can submit karya & review with it.
     */
    public function test_api_login_and_write_operations(): void
    {
        // Create user
        $user = User::factory()->create([
            'email' => 'mahasiswa@apps.ipb.ac.id',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        // Login via API
        $responseLogin = $this->postJson(route('api.v1.login'), [
            'email' => 'mahasiswa@apps.ipb.ac.id',
            'password' => 'password123',
        ]);

        $responseLogin->assertStatus(200)
            ->assertJsonStructure(['success', 'token', 'user']);

        $token = $responseLogin->json('token');

        // Submit Karya using token
        $responseKarya = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('api.v1.karyas.store'), [
            'judul' => 'Proyek Mahasiswa API',
            'kategori' => 'Web Application',
            'deskripsi' => 'Deskripsi proyek mahasiswa TRPL',
            'tim_pembuat' => 'Ahmad & Budi',
            'tahun' => 2026,
            'link' => 'https://github.com/anandra00/portal-karya-tpl',
        ]);

        $responseKarya->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Karya berhasil diajukan! Menunggu validasi admin.',
            ]);

        $karyaId = $responseKarya->json('data.id');

        // Approve the karya to make it reviewable
        Karya::find($karyaId)->update(['status_validasi' => 'accepted']);

        // Create reviewer user
        $reviewer = User::factory()->create([
            'email' => 'reviewer@apps.ipb.ac.id',
            'password' => bcrypt('password123'),
        ]);
        
        $responseReviewerLogin = $this->postJson(route('api.v1.login'), [
            'email' => 'reviewer@apps.ipb.ac.id',
            'password' => 'password123',
        ]);
        $reviewerToken = $responseReviewerLogin->json('token');

        // Reset the auth manager state between requests to prevent caching issues in tests
        $this->app['auth']->forgetGuards();

        // Submit review using reviewer token
        $responseReview = $this->withHeaders([
            'Authorization' => 'Bearer ' . $reviewerToken,
        ])->postJson(route('api.v1.reviews.store', $karyaId), [
            'rating' => 5,
            'comment' => 'Sangat menginspirasi!',
        ]);

        $responseReview->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Review berhasil ditambahkan!',
            ]);

        // Verify notification is created in database for the uploader
        $this->assertEquals(1, $user->notifications()->count());
        $notification = $user->notifications()->first();
        $this->assertEquals('new_review', $notification->data['type']);
        $this->assertStringContainsString('memberikan ulasan bintang 5', $notification->data['message']);
    }

    /**
     * Test API header versioning strategy.
     */
    public function test_api_versioning_header_strategy(): void
    {
        // 1. Request with correct version header
        $response1 = $this->withHeaders([
            'X-API-Version' => '1.0',
        ])->getJson(route('api.v1.dosens'));
        $response1->assertStatus(200);

        // 2. Request with correct Accept header
        $response2 = $this->withHeaders([
            'Accept' => 'application/vnd.portaltpl.v1+json',
        ])->getJson(route('api.v1.dosens'));
        $response2->assertStatus(200);

        // 3. Request with no headers (should default to v1)
        $response3 = $this->getJson(route('api.v1.dosens'));
        $response3->assertStatus(200);

        // 4. Request with unsupported version header (should fail with 406)
        $response4 = $this->withHeaders([
            'X-API-Version' => '2.0',
        ])->getJson(route('api.v1.dosens'));
        $response4->assertStatus(406)
            ->assertJson([
                'success' => false,
                'message' => 'API version not supported. Supported versions: 1'
            ]);
    }
}
