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

    /**
     * Test admin can restore a soft-deleted karya.
     */
    public function test_admin_can_restore_karya(): void
    {
        $admin = User::factory()->admin()->create();
        $karya = Karya::create([
            'user_id' => $admin->id,
            'judul' => 'Karya Soft Deleted',
            'deskripsi' => 'Deskripsi',
            'kategori' => 'IoT',
            'tahun' => 2026,
            'tim_pembuat' => 'Tim Test',
            'status_validasi' => 'accepted'
        ]);
        $karya->delete(); // Soft delete it

        $this->assertEquals(0, Karya::count()); // Active count is 0
        $this->assertEquals(1, Karya::withTrashed()->count());

        $response = $this->actingAs($admin)->post(route('admin.karya.restore', $karya->id));

        $response->assertRedirect(route('karya.index'));
        $this->assertEquals(1, Karya::count()); // Active count is 1
    }

    /**
     * Test admin can force delete a soft-deleted karya.
     */
    public function test_admin_can_force_delete_karya(): void
    {
        $admin = User::factory()->admin()->create();
        $karya = Karya::create([
            'user_id' => $admin->id,
            'judul' => 'Karya For Force Delete',
            'deskripsi' => 'Deskripsi',
            'kategori' => 'IoT',
            'tahun' => 2026,
            'tim_pembuat' => 'Tim Test',
            'status_validasi' => 'accepted'
        ]);
        $karya->delete(); // Soft delete it

        $this->assertEquals(1, Karya::withTrashed()->count());

        $response = $this->actingAs($admin)->delete(route('admin.karya.force-delete', $karya->id));

        $response->assertRedirect(route('karya.index'));
        $this->assertEquals(0, Karya::withTrashed()->count()); // Fully deleted
    }
}
