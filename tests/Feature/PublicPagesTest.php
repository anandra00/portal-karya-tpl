<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}
