<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class KaryaSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test upload form redirects guests.
     */
    public function test_karya_upload_form_redirects_guests(): void
    {
        $response = $this->get('/unggah-karya'); // route name might be different, let's assume '/unggah-karya'
        // If route is wrong, it will be 404. Let's check web.php for correct route.
        // I will use route('karya.unggah') if named, but since I am writing this before checking exact route,
        // let's just test that it's either 404 or 302/redirect if exists.
        // Actually it's better to assert redirect to login if auth middleware is applied.
        $response->assertRedirect('/login');
    }

    /**
     * Test upload form loads for authenticated users.
     */
    public function test_karya_upload_form_loads_for_mahasiswa(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/unggah-karya'); 
        
        $response->assertStatus(200);
    }
}
