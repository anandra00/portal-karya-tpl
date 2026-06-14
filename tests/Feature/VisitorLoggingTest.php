<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Core\Models\Visitor;

class VisitorLoggingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a public page visit is logged to the visitors table.
     */
    public function test_public_page_visit_is_logged(): void
    {
        $this->assertEquals(0, Visitor::count());

        $response = $this->get('/');

        $response->assertStatus(200);
        $this->assertEquals(1, Visitor::count());

        $visitor = Visitor::first();
        $this->assertEquals('Tamu', $visitor->nama);
        $this->assertEquals('guest@tpl.svipb.ac.id', $visitor->email);
        $this->assertStringContainsString('Symfony', $visitor->user_agent);
    }

    /**
     * Test that admin pages are not logged as visitor logs.
     */
    public function test_admin_pages_are_not_logged_as_visitor(): void
    {
        $this->assertEquals(0, Visitor::count());

        $response = $this->get('/admin/dashboard');
        
        $response->assertStatus(302);
        $this->assertEquals(0, Visitor::count());
    }

    /**
     * Test that AJAX requests are not logged.
     */
    public function test_ajax_requests_are_not_logged(): void
    {
        $this->assertEquals(0, Visitor::count());

        $response = $this->get('/', [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(200);
        $this->assertEquals(0, Visitor::count());
    }

    /**
     * Test that admin can clear visitor logs.
     */
    public function test_admin_can_clear_visitor_logs(): void
    {
        // Create an admin user
        $admin = \App\Models\User::create([
            'name' => 'Admin Test',
            'email' => 'admin_test@tpl.svipb.ac.id',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        // Seed a visitor log
        Visitor::create([
            'nama' => 'Tamu',
            'email' => 'guest@tpl.svipb.ac.id',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 Chrome/120.0.0.0',
            'page_visited' => 'http://127.0.0.1:8000/',
            'visited_at' => now(),
        ]);

        $this->assertEquals(1, Visitor::count());

        // Perform clear request logged in as admin
        $response = $this->actingAs($admin)
                         ->post('/admin/lihat-pengunjung/clear');

        $response->assertRedirect(route('lihatpengunjung'));
        $response->assertSessionHas('success', 'Semua log kunjungan berhasil dihapus!');
        
        $this->assertEquals(0, Visitor::count());
    }
}
