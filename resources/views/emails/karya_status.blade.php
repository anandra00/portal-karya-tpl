<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Status Validasi Karya</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <div style="background-color: #4F46E5; color: white; padding: 20px; text-align: center;">
            <h2 style="margin: 0;">Portal TRPL SV IPB</h2>
        </div>
        
        <div style="padding: 30px; color: #374151; line-height: 1.6;">
            <p>Halo, <strong>{{ $karya->tim_pembuat }}</strong>!</p>
            
            <p>Kami ingin menginformasikan bahwa status validasi untuk karya Anda yang berjudul: <br>
            <strong>"{{ $karya->judul }}"</strong></p>
            
            @if($karya->status_validasi == 'accepted')
                <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #10b981;">
                    <strong>SELAMAT! Karya Anda telah disetujui (ACCEPTED)</strong> dan sekarang terpublikasi di Portal TRPL IPB.
                </div>
                <p>Terima kasih telah berkontribusi memberikan karya terbaik Anda!</p>
                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ route('karyadetail', $karya->id) }}" style="background-color: #4F46E5; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold;">Lihat Karya Saya</a>
                </div>
            @else
                <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #ef4444;">
                    <strong>Mohon Maaf, Karya Anda ditolak (REJECTED)</strong> oleh tim validator.
                </div>
                <p>Silakan tinjau kembali karya Anda dan unggah ulang dengan perbaikan yang sesuai dengan standar kami.</p>
            @endif

            <br>
            <p style="margin-bottom: 0;">Salam hangat,</p>
            <p style="margin-top: 5px; font-weight: bold;">Tim Validator TRPL SV IPB</p>
        </div>
    </div>
</body>
</html>
