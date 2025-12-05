@component('mail::message')
# Halo {{ $user->nama_lengkap }}

Terima kasih telah mendaftar di Portal PMB UMPAR.

**Nomor Registrasi Anda:**  
**{{ $user->nomor_registrasi }}**

Klik tombol di bawah ini untuk memverifikasi email Anda. Setelah verifikasi, Anda bisa melakukan login.

@component('mail::button', ['url' => $verificationUrl])
Verifikasi Email & Aktifkan Akun
@endcomponent

Jika tombol tidak bekerja, salin dan tempel link berikut di browser:  
{{ $verificationUrl }}

Terima kasih,<br>
Tim PMB UMPAR
@endcomponent
