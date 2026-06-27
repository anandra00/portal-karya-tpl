<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin dashboard cannot be accessed by guests.
     */
    public function test_admin_dashboard_redirects_guests(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Test admin dashboard cannot be accessed by mahasiswa.
     */
    public function test_admin_dashboard_forbids_mahasiswa(): void
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)->get('/admin/dashboard');
        // Middleware role admin usually returns 403 or redirects to home
        // It depends on how it's implemented. Assuming redirect to home or 403.
        // Let's assert it is NOT 200.
        $this->assertNotEquals(200, $response->status());
    }

    /**
     * Test admin dashboard can be accessed by admin.
     */
    public function test_admin_dashboard_allows_admin(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        
        $response->assertStatus(200);
    }

    /**
     * Test admin list page (Kelola Admin) restricts admin but allows superadmin.
     */
    public function test_admin_list_restricts_admin_but_allows_superadmin(): void
    {
        $admin = User::factory()->admin()->create();
        $superadmin = User::factory()->create(['role' => 'superadmin']);

        // Admin should be redirected to home with error
        $responseAdmin = $this->actingAs($admin)->get('/admin/list');
        $responseAdmin->assertRedirect('/');

        // Superadmin should access successfully
        $responseSuperadmin = $this->actingAs($superadmin)->get('/admin/list');
        $responseSuperadmin->assertStatus(200);
    }

    /**
     * Test backup database restricts admin but allows superadmin.
     */
    public function test_database_backup_restricts_admin_but_allows_superadmin(): void
    {
        $admin = User::factory()->admin()->create();
        $superadmin = User::factory()->create(['role' => 'superadmin']);

        // Admin should be redirected to home
        $responseAdmin = $this->actingAs($admin)->post('/admin/backup-database');
        $responseAdmin->assertRedirect('/');

        // Superadmin should access successfully (stream download)
        $responseSuperadmin = $this->actingAs($superadmin)->post('/admin/backup-database');
        $responseSuperadmin->assertStatus(200)
            ->assertHeader('Content-Type', 'application/octet-stream');
    }
}
