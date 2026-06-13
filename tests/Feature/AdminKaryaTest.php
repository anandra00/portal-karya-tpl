<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Modules\Karya\Models\Karya;

class AdminKaryaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can approve a student project submission.
     */
    public function test_admin_can_approve_karya(): void
    {
        $admin = User::factory()->admin()->create();
        $karya = Karya::create([
            'user_id' => $admin->id,
            'judul' => 'Karya Test 1',
            'deskripsi' => 'Deskripsi Karya Test',
            'kategori' => 'Web App',
            'tahun' => 2026,
            'tim_pembuat' => 'Tim Test',
            'status_validasi' => 'submission',
        ]);

        $response = $this->actingAs($admin)->put(route('karya.update', $karya->id), [
            'judul' => 'Karya Test 1 Updated',
            'kategori' => 'Mobile App',
            'deskripsi' => 'Deskripsi Karya Test Updated',
            'tim_pembuat' => 'Tim Test Updated',
            'tahun' => 2026,
            'status_validasi' => 'accepted'
        ]);

        $response->assertRedirect(route('karya.index'));
        $this->assertDatabaseHas('karyas', [
            'id' => $karya->id,
            'status_validasi' => 'accepted',
            'judul' => 'Karya Test 1 Updated'
        ]);
    }

    /**
     * Test admin can export projects to high-quality Excel spreadsheet.
     */
    public function test_admin_can_export_karyas(): void
    {
        $admin = User::factory()->admin()->create();
        
        $response = $this->actingAs($admin)->get(route('karya.export'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}
