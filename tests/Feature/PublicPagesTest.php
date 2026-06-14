<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Modules\Karya\Models\Karya;
use Modules\Akademik\Models\Dosen;
use Modules\Karya\Models\Review;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test home page loads successfully.
     */
    public function test_home_page_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test tentang page loads successfully.
     */
    public function test_tentang_page_returns_successful_response(): void
    {
        $response = $this->get('/tentang');
        $response->assertStatus(200);
    }

    /**
     * Test dosen page loads successfully.
     */
    public function test_dosen_page_returns_successful_response(): void
    {
        $response = $this->get('/dosen');
        $response->assertStatus(200);
    }

    /**
     * Test matakuliah page loads successfully.
     */
    public function test_matakuliah_page_returns_successful_response(): void
    {
        $response = $this->get('/matakuliah');
        $response->assertStatus(200);
    }

    /**
     * Test faq page loads successfully.
     */
    public function test_faq_page_returns_successful_response(): void
    {
        $response = $this->get('/faq');
        $response->assertStatus(200);
    }

    /**
     * Test karya public page loads successfully.
     */
    public function test_karya_page_returns_successful_response(): void
    {
        $response = $this->get('/karya');
        $response->assertStatus(200);
    }

    /**
     * Test public API get all accepted works (Karyas).
     */
    public function test_api_can_get_accepted_karyas(): void
    {
        $user = User::factory()->create();

        // Create accepted karya
        $acceptedKarya = Karya::create([
            'user_id' => $user->id,
            'judul' => 'Karya Accepted',
            'deskripsi' => 'Deskripsi Karya Accepted',
            'kategori' => 'Web App',
            'tahun' => 2026,
            'tim_pembuat' => 'Tim A',
            'status_validasi' => 'accepted',
        ]);

        // Create pending submission karya
        $pendingKarya = Karya::create([
            'user_id' => $user->id,
            'judul' => 'Karya Submission',
            'deskripsi' => 'Deskripsi Karya Submission',
            'kategori' => 'Mobile App',
            'tahun' => 2026,
            'tim_pembuat' => 'Tim B',
            'status_validasi' => 'submission',
        ]);

        $response = $this->getJson(route('api.v1.karyas'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id', 'judul', 'deskripsi', 'kategori', 'tahun',
                        'file_karya', 'preview_karya', 'link_pengumpulan',
                        'tim_pembuat', 'tanggal_upload', 'uploader' => ['id', 'name']
                    ]
                ]
            ]);

        // Assert accepted is present and pending is absent
        $response->assertJsonFragment(['judul' => 'Karya Accepted']);
        $response->assertJsonMissing(['judul' => 'Karya Submission']);
    }

    /**
     * Test public API get specific karya detail.
     */
    public function test_api_can_get_karya_detail(): void
    {
        $user = User::factory()->create();
        
        $karya = Karya::create([
            'user_id' => $user->id,
            'judul' => 'Detail Karya',
            'deskripsi' => 'Deskripsi',
            'kategori' => 'IoT',
            'tahun' => 2026,
            'tim_pembuat' => 'Tim C',
            'status_validasi' => 'accepted',
        ]);

        // Add a review
        Review::create([
            'karya_id' => $karya->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Review Mantap'
        ]);

        // 1. Test existing accepted karya
        $response = $this->getJson(route('api.v1.karya.detail', $karya->id));
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $karya->id,
                    'judul' => 'Detail Karya',
                    'reviews' => [
                        [
                            'rating' => 5,
                            'comment' => 'Review Mantap',
                            'user' => [
                                'id' => $user->id,
                                'name' => $user->name
                            ]
                        ]
                    ]
                ]
            ]);

        // 2. Test non-accepted karya
        $pendingKarya = Karya::create([
            'user_id' => $user->id,
            'judul' => 'Karya Pending',
            'deskripsi' => 'Deskripsi',
            'kategori' => 'IoT',
            'tahun' => 2026,
            'tim_pembuat' => 'Tim D',
            'status_validasi' => 'submission',
        ]);
        $responsePending = $this->getJson(route('api.v1.karya.detail', $pendingKarya->id));
        $responsePending->assertStatus(404)
            ->assertJson(['success' => false]);

        // 3. Test non-existent karya
        $responseNonExistent = $this->getJson(route('api.v1.karya.detail', 999999));
        $responseNonExistent->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    /**
     * Test public API get all lecturers (Dosens).
     */
    public function test_api_can_get_dosens(): void
    {
        Dosen::create([
            'nama' => 'Dosen Test A',
            'research_interest' => 'AI',
            'prodi' => 'TPL',
            'foto' => 'dosen_a.jpg',
        ]);

        $response = $this->getJson(route('api.v1.dosens'));
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id', 'nama', 'research_interest', 'prodi', 'foto'
                    ]
                ]
            ])
            ->assertJsonFragment(['nama' => 'Dosen Test A']);
    }
}
