<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Modules\Karya\Models\Karya;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Mail\KaryaStatusMail;
use Modules\Karya\Notifications\KaryaStatusNotification;
use Modules\Karya\Notifications\NewReviewNotification;

class KaryaNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test notification and mail are sent when admin approves a karya.
     */
    public function test_notifications_sent_on_approve(): void
    {
        Mail::fake();
        Notification::fake();

        $admin = User::factory()->admin()->create();
        $student = User::factory()->create([
            'role' => 'user',
            'email' => 'mahasiswa@apps.ipb.ac.id'
        ]);

        $karya = Karya::create([
            'user_id' => $student->id,
            'judul' => 'Karya Test Approve',
            'deskripsi' => 'Deskripsi',
            'kategori' => 'Web App',
            'tahun' => 2026,
            'tim_pembuat' => 'Tim Test',
            'status_validasi' => 'submission',
        ]);

        // Call the approve route
        $response = $this->actingAs($admin)->post(route('admin.karya.approve', $karya->id));

        $response->assertRedirect(route('karya.index'));

        // Check validation status updated
        $this->assertEquals('accepted', $karya->fresh()->status_validasi);

        // Assert mail was sent to the student
        Mail::assertSent(KaryaStatusMail::class, function ($mail) use ($student) {
            return $mail->hasTo($student->email);
        });

        // Assert notification was sent to the student
        Notification::assertSentTo(
            $student,
            KaryaStatusNotification::class
        );
    }

    /**
     * Test notification and mail are sent when admin rejects a karya.
     */
    public function test_notifications_sent_on_reject(): void
    {
        Mail::fake();
        Notification::fake();

        $admin = User::factory()->admin()->create();
        $student = User::factory()->create([
            'role' => 'user',
            'email' => 'mahasiswa@apps.ipb.ac.id'
        ]);

        $karya = Karya::create([
            'user_id' => $student->id,
            'judul' => 'Karya Test Reject',
            'deskripsi' => 'Deskripsi',
            'kategori' => 'Web App',
            'tahun' => 2026,
            'tim_pembuat' => 'Tim Test',
            'status_validasi' => 'submission',
        ]);

        // Call the reject route
        $response = $this->actingAs($admin)->post(route('admin.karya.reject', $karya->id));

        $response->assertRedirect(route('karya.index'));

        // Check validation status updated
        $this->assertEquals('rejected', $karya->fresh()->status_validasi);

        // Assert mail was sent to the student
        Mail::assertSent(KaryaStatusMail::class, function ($mail) use ($student) {
            return $mail->hasTo($student->email);
        });

        // Assert notification was sent to the student
        Notification::assertSentTo(
            $student,
            KaryaStatusNotification::class
        );
    }

    /**
     * Test notification is sent when a review is submitted.
     */
    public function test_notification_sent_on_review(): void
    {
        Notification::fake();

        $student = User::factory()->create([
            'role' => 'user',
            'email' => 'mahasiswa@apps.ipb.ac.id'
        ]);
        $reviewer = User::factory()->create();

        $karya = Karya::create([
            'user_id' => $student->id,
            'judul' => 'Karya Reviewed',
            'deskripsi' => 'Deskripsi',
            'kategori' => 'Web App',
            'tahun' => 2026,
            'tim_pembuat' => 'Tim Test',
            'status_validasi' => 'accepted',
        ]);

        // Submit a review via web form
        $response = $this->actingAs($reviewer)->post(route('review.store'), [
            'karya_id' => $karya->id,
            'rating' => 5,
            'comment' => 'Great work!'
        ]);

        $response->assertRedirect();

        // Assert notification was sent to the student (owner of the karya)
        Notification::assertSentTo(
            $student,
            NewReviewNotification::class
        );
    }

    /**
     * Test review cannot be submitted for a non-accepted project (Web).
     */
    public function test_cannot_review_unapproved_karya_web(): void
    {
        $student = User::factory()->create();
        $reviewer = User::factory()->create();

        $karya = Karya::create([
            'user_id' => $student->id,
            'judul' => 'Karya Pending',
            'deskripsi' => 'Deskripsi',
            'kategori' => 'Web App',
            'tahun' => 2026,
            'tim_pembuat' => 'Tim Test',
            'status_validasi' => 'submission',
        ]);

        $response = $this->actingAs($reviewer)->post(route('review.store'), [
            'karya_id' => $karya->id,
            'rating' => 5,
            'comment' => 'Should not be allowed'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Anda hanya dapat memberikan ulasan pada karya yang telah disetujui.');

        $this->assertDatabaseMissing('reviews', [
            'karya_id' => $karya->id,
            'user_id' => $reviewer->id,
        ]);
    }

    /**
     * Test review cannot be submitted for a non-accepted project (API).
     */
    public function test_cannot_review_unapproved_karya_api(): void
    {
        $student = User::factory()->create();
        $reviewer = User::factory()->create();

        $karya = Karya::create([
            'user_id' => $student->id,
            'judul' => 'Karya Pending',
            'deskripsi' => 'Deskripsi',
            'kategori' => 'Web App',
            'tahun' => 2026,
            'tim_pembuat' => 'Tim Test',
            'status_validasi' => 'submission',
        ]);

        // Mocking Sanctum authentication for the API
        $response = $this->actingAs($reviewer, 'sanctum')->postJson(route('api.v1.reviews.store', $karya->id), [
            'rating' => 5,
            'comment' => 'Should fail with 404'
        ]);

        $response->assertStatus(404);

        $this->assertDatabaseMissing('reviews', [
            'karya_id' => $karya->id,
            'user_id' => $reviewer->id,
        ]);
    }
}
