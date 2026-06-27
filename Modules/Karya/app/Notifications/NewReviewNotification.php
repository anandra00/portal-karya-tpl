<?php

namespace Modules\Karya\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Modules\Karya\Models\Review;

class NewReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        $karya = $this->review->karya;
        $reviewer = $this->review->user;

        return [
            'review_id' => $this->review->id,
            'karya_id' => $karya ? $karya->id : null,
            'judul' => $karya ? $karya->judul : '',
            'rating' => $this->review->rating,
            'reviewer_name' => $reviewer ? $reviewer->name : 'Seseorang',
            'message' => ($reviewer ? $reviewer->name : 'Seseorang') . " memberikan ulasan bintang " . $this->review->rating . " pada karya Anda '" . ($karya ? $karya->judul : '') . "'.",
            'link' => $karya ? route('karya.public.show', $karya->id) : '#',
            'type' => 'new_review',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $karya = $this->review->karya;
        $reviewer = $this->review->user;

        return new BroadcastMessage([
            'review_id' => $this->review->id,
            'karya_id' => $karya ? $karya->id : null,
            'judul' => $karya ? $karya->judul : '',
            'rating' => $this->review->rating,
            'reviewer_name' => $reviewer ? $reviewer->name : 'Seseorang',
            'message' => ($reviewer ? $reviewer->name : 'Seseorang') . " memberikan ulasan bintang " . $this->review->rating . " pada karya Anda '" . ($karya ? $karya->judul : '') . "'.",
            'link' => $karya ? route('karya.public.show', $karya->id) : '#',
            'type' => 'new_review',
        ]);
    }
}
