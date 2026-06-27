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

        // Logout from previous session
        // auth()->logout();

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
}
