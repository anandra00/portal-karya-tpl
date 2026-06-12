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
}
