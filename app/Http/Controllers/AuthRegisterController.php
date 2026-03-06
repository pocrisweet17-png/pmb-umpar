<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use App\Mail\VerifyRegistrationMail;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AuthRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.login', ['openRegister' => true]);
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'username'      => 'required|unique:users,username',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'nama_lengkap'  => 'required',
            'nik'           => 'required|unique:users,nik',
            'no_whatsapp'   => 'required',
            'akun_fb'       => 'nullable|unique:users,akun_fb',
            'akun_instagram' => 'nullable|unique:users,akun_instagram',
            'akun_tiktok'   => 'nullable|unique:users,akun_tiktok',
            'akun_twitter'  => 'nullable|unique:users,akun_twitter',
        ]);

        // 1. Create user
        $user = User::create([
            'username'      => $request->username,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'nama_lengkap'  => $request->nama_lengkap,
            'nik'           => $request->nik,
            'no_whatsapp'   => $request->no_whatsapp,
            'akun_fb'       => $request->akun_fb,
            'akun_instagram' => $request->akun_instagram,
            'akun_tiktok'   => $request->akun_tiktok,
            'akun_twitter'  => $request->akun_twitter,
            'role'          => 'user',
        ]);

        // 2. Generate nomor registrasi
        $regNo = 'UMPAR-' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
        $user->nomor_registrasi = $regNo;
        $user->save();

        // 3. Create registrasi steps row
        Registrasi::updateOrCreate([
            'user_id' => $user->id,
        ], [
            'nomorPendaftaran'      => $regNo,
            'namaLengkap'           => $user->nama_lengkap,
            'tanggalDaftar'         => now(),
            'statusRegistrasi'      => 'pending',
            
            'tempatLahir'           => '-',  
            'tanggalLahir'          => now(),
            'agama'                 => '-',
            'alamat'                => '-',
            'asalSekolah'           => '-',
            'jurusan'               => '-',
            'tahunLulus'            => 0,
        
            'is_prodi_selected'     => 0,
            'is_bayar_pendaftaran'  => 0,
            'is_data_completed'     => 0,
            'is_dokumen_uploaded'   => 0,   
            'is_tes_selesai'        => 0,
            'is_wawancara_selesai'  => 0,
            'is_daftar_ulang'       => 0,
            'is_ukt_paid'           => 0,
        ]);

        // 4. Create signed URL (SAMA untuk email dan WhatsApp)
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addHours(24),
            [
                'id'   => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        // 5. Send email
        try {
            Mail::to($user->email)->send(
                new VerifyRegistrationMail(
                    $user->nama_lengkap,
                    $user->nomor_registrasi,
                    $verificationUrl
                )
            );
            Log::info('Email verifikasi berhasil dikirim ke: ' . $user->email);
        } catch (\Exception $e) {
            Log::error('Email gagal dikirim: ' . $e->getMessage());
        }

        // 6. Send WhatsApp (LINK YANG SAMA!)
        $this->sendWhatsAppVerification($user, $verificationUrl);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat! Cek Email dan WhatsApp untuk verifikasi.');
    }

    /**
     * Send WhatsApp verification via Fonnte
     * 
     * @param User $user
     * @param string $verificationUrl
     * @return void
     */
    private function sendWhatsAppVerification($user, $verificationUrl)
    {
        try {
            // Format nomor WhatsApp
            // Jika nomor mulai dengan 0, ganti dengan 62
            // Contoh: 081234567890 -> 6281234567890
            $phone = $user->no_whatsapp;
            
            if (substr($phone, 0, 1) === '0') {
                $phone = '62' . substr($phone, 1);
            } elseif (substr($phone, 0, 1) === '+') {
                $phone = substr($phone, 1);
            } elseif (substr($phone, 0, 2) !== '62') {
                $phone = '62' . $phone;
            }

            // Compose WhatsApp message
            $message = "*UMPAR - Verifikasi Pendaftaran*\n\n";
            $message .= "Halo *{$user->nama_lengkap}*,\n\n";
            $message .= "Terima kasih telah mendaftar di UMPAR!\n\n";
            $message .= "*Nomor Registrasi:* {$user->nomor_registrasi}\n";
            $message .= "*Email:* {$user->email}\n\n";
            $message .= "Silakan klik link berikut untuk *verifikasi akun* Anda:\n\n";
            $message .= "{$verificationUrl}\n\n";
            $message .= "*Link berlaku selama 24 jam*\n\n";
            $message .= "Anda juga bisa klik link yang dikirim ke email.\n\n";
            $message .= "---\n";
            $message .= "_Jika Anda tidak merasa mendaftar, abaikan pesan ini._";

            // Send via Fonnte API
            $client = new Client();
            $response = $client->post('https://api.fonnte.com/send', [
                'headers' => [
                    'Authorization' => env('FONNTE_TOKEN'),
                ],
                'form_params' => [
                    'target'  => $phone,
                    'message' => $message,
                    'countryCode' => '62', // Indonesia
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['status']) && $result['status'] == true) {
                Log::info('WhatsApp verifikasi berhasil dikirim ke: ' . $phone);
            } else {
                Log::warning('WhatsApp response: ' . json_encode($result));
            }
            
        } catch (\Exception $e) {
            // Jangan stop proses registrasi jika WhatsApp gagal
            Log::error('WhatsApp gagal dikirim: ' . $e->getMessage());
        }
    }
}