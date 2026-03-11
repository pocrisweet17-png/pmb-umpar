<!DOCTYPE html>
<html>
<body style="font-family: Arial;">
    <h2>Halo {{ $nama }},</h2>

    <p>Terima kasih sudah melakukan pendaftaran.</p>

    <p>Nomor Registrasi Anda:</p>

    <h3 style="color:#2b6cb0; font-weight:bold;">
        {{ $nomor_registrasi }}
    </h3>

    <p>Silakan klik tombol berikut untuk melakukan verifikasi email:</p>

    <p>
        <a href="{{ $verificationUrl }}"
           style="background:#4CAF50; padding:12px 20px; color:white; text-decoration:none; border-radius:6px; font-size:16px;">
           Verifikasi Email
        </a>
    </p>

    <p>Atau buka link berikut jika tombol tidak berfungsi:</p>
    <p>{{ $verificationUrl }}</p>
</body>
</html>
