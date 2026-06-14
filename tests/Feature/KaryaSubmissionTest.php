<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Modules\Karya\Models\Karya;

class KaryaSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test upload form redirects guests.
     */
    public function test_karya_upload_form_redirects_guests(): void
    {
        $response = $this->get('/unggah-karya');
        $response->assertRedirect('/login');
    }

    /**
     * Test upload form displays form for student with IPB email.
     */
    public function test_karya_upload_form_allows_student_with_ipb_email(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'email' => 'mahasiswa@apps.ipb.ac.id'
        ]);

        $response = $this->actingAs($user)->get('/unggah-karya'); 
        
        $response->assertStatus(200);
        $response->assertSee('Form Unggah Karya');
        $response->assertDontSee('Akses Terbatas');
    }

    /**
     * Test upload form restricts student with regular email.
     */
    public function test_karya_upload_form_restricts_student_with_gmail(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'email' => 'mahasiswa@gmail.com'
        ]);

        $response = $this->actingAs($user)->get('/unggah-karya'); 
        
        $response->assertStatus(200);
        $response->assertSee('Akses Terbatas');
        $response->assertDontSee('Form Unggah Karya');
    }

    /**
     * Test student with regular email cannot submit karya (returns 403 Forbidden).
     */
    public function test_student_with_gmail_cannot_submit_karya(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'email' => 'mahasiswa@gmail.com'
        ]);

        $response = $this->actingAs($user)->postJson(route('karya.store'), [
            'judul' => 'Karya Gmail',
            'kategori' => 'Web App',
            'deskripsi' => 'Deskripsi Karya Gmail',
            'tim_pembuat' => 'Tim Gmail',
            'email' => 'mahasiswa@gmail.com',
            'tahun' => 2026,
            'link' => 'https://github.com'
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test student with IPB email can submit karya successfully.
     */
    public function test_student_with_ipb_email_can_submit_karya(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'email' => 'mahasiswa@apps.ipb.ac.id'
        ]);

        // Mock upload file
        $file = \Illuminate\Http\UploadedFile::fake()->image('preview.jpg');

        $response = $this->actingAs($user)->post(route('karya.store'), [
            'judul' => 'Karya IPB',
            'kategori' => 'Web App',
            'deskripsi' => 'Deskripsi Karya IPB',
            'tim_pembuat' => 'Tim IPB',
            'email' => 'mahasiswa@apps.ipb.ac.id',
            'preview_karya' => $file,
            'tahun' => 2026,
            'link' => 'https://github.com'
        ]);

        $response->assertRedirect(route('unggah'));
        $this->assertDatabaseHas('karyas', [
            'judul' => 'Karya IPB',
            'user_id' => $user->id
        ]);
    }
}
