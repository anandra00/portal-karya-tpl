<?php

namespace Modules\Karya\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Modules\Karya\Models\Karya;

class KaryaStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $karya;

    public function __construct(Karya $karya)
    {
        $this->karya = $karya;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'karya_id' => $this->karya->id,
            'judul' => $this->karya->judul,
            'status' => $this->karya->status_validasi,
            'message' => "Karya Anda '" . $this->karya->judul . "' telah " . ($this->karya->status_validasi === 'accepted' ? 'disetujui' : 'ditolak') . " oleh Admin.",
            'link' => $this->karya->status_validasi === 'accepted' ? route('karya.public.show', $this->karya->id) : '#',
            'type' => 'karya_status',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'karya_id' => $this->karya->id,
            'judul' => $this->karya->judul,
            'status' => $this->karya->status_validasi,
            'message' => "Karya Anda '" . $this->karya->judul . "' telah " . ($this->karya->status_validasi === 'accepted' ? 'disetujui' : 'ditolak') . " oleh Admin.",
            'link' => $this->karya->status_validasi === 'accepted' ? route('karya.public.show', $this->karya->id) : '#',
            'type' => 'karya_status',
        ]);
    }
}
