<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\BiayaPmb;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query();
    
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', '%' . $search . '%')
                  ->orWhere('username', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%')
                  ->orWhere('nik', 'LIKE', '%' . $search . '%')
                  ->orWhere('no_whatsapp', 'LIKE', '%' . $search . '%')
                  ->orWhere('nomor_registrasi', 'LIKE', '%' . $search . '%');
            });
        }
    
        // Filter by role 
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
    
        // Filter by verifikasi status
        if ($request->filled('verified')) {
            $query->where('is_verified', (int)$request->verified);
        }
    
        $users = $query->orderBy('created_at', 'desc')->get();
    
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:users',
            'no_whatsapp' => 'required|string|max:15',
            'role' => 'required|in:admin,user',
            'is_wawancara_selesai' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_wawancara_selesai'] = $request->has('is_wawancara_selesai');

        User::create($validated);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('dokumens')->findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
    
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nama_lengkap' => 'required|string|max:255',
            'nik' => ['required', 'string', 'max:16', Rule::unique('users')->ignore($user->id)],
            'no_whatsapp' => 'required|string|max:15',
            'role' => 'required|in:admin,user',
            'password' => 'nullable|string|min:8|confirmed',
            'is_verified' => 'boolean',
            'is_prodi_selected' => 'boolean',
            'is_bayar_pendaftaran' => 'boolean',
            'is_data_completed' => 'boolean',
            'is_dokumen_uploaded' => 'boolean',
            'is_tes_selesai' => 'boolean',
            'is_wawancara_selesai' => 'boolean',
            'is_daftar_ulang' => 'boolean',
            'is_ukt_paid' => 'boolean',
        ]);
    
        $validated['is_verified'] = $request->has('is_verified');
        $validated['is_prodi_selected'] = $request->has('is_prodi_selected');
        $validated['is_bayar_pendaftaran'] = $request->has('is_bayar_pendaftaran');
        $validated['is_data_completed'] = $request->has('is_data_completed');
        $validated['is_dokumen_uploaded'] = $request->has('is_dokumen_uploaded');
        $validated['is_tes_selesai'] = $request->has('is_tes_selesai');
        $validated['is_wawancara_selesai'] = $request->has('is_wawancara_selesai');
        $validated['is_daftar_ulang'] = $request->has('is_daftar_ulang');
        $validated['is_ukt_paid'] = $request->has('is_ukt_paid');
    
        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
    
        // ========== DETEKSI PERUBAHAN STATUS PEMBAYARAN ==========
        $wasPendaftaranPaid = $user->is_bayar_pendaftaran;
        $nowPendaftaranPaid = $validated['is_bayar_pendaftaran'];
        $wasUktPaid = $user->is_ukt_paid; 
        $nowUktPaid = $validated['is_ukt_paid'];
    
        // ========== HANDLE PEMBAYARAN PENDAFTARAN ==========
        // CASE A: Pendaftaran DI-UNCHECK (dari TRUE ke FALSE)
        if ($wasPendaftaranPaid && !$nowPendaftaranPaid) {
            Log::warning('⚠️ Admin uncheck Bayar Pendaftaran', [
                'user_id' => $user->id,
                'admin_id' => auth()->id()
            ]);

            $user->update($validated);

            // Update payment menjadi pending-offline
            $paymentPendaftaran = Payment::where('user_id', $user->id)
                ->where('tipe_pembayaran', 'pendaftaran')
                ->first();

            if ($paymentPendaftaran) {
                $paymentPendaftaran->update(['status_transaksi' => 'pending-offline']);
                Log::info('✅ Updated Pendaftaran payment to pending-offline', [
                    'payment_id' => $paymentPendaftaran->id
                ]);
            }

            return redirect()->route('admin.user.index')
                ->with('warning', 'User berhasil diupdate. Status pembayaran pendaftaran dibatalkan.');
        }

        // CASE B: Pendaftaran DI-CHECK (dari FALSE ke TRUE) - BUAT/UPDATE PAYMENT
        if (!$wasPendaftaranPaid && $nowPendaftaranPaid) {
            Log::info('💰 Admin checklist Bayar Pendaftaran', [
                'user_id' => $user->id,
                'admin_id' => auth()->id()
            ]);

            $user->update($validated);

            // Buat atau update payment record
            $this->createOrUpdateOfflinePayment($user, 'pendaftaran');

            return redirect()->route('admin.user.index')
                ->with('success', 'User berhasil diupdate! Pembayaran pendaftaran tercatat.');
        }

        // ========== HANDLE PEMBAYARAN UKT ==========
        // CASE 1: UKT DI-UNCHECK (dari TRUE ke FALSE)
        if ($wasUktPaid && !$nowUktPaid) {
            $oldNim = $user->nim;
            $validated['nim'] = null;

            Log::warning('⚠️ Admin uncheck UKT paid - NIM deleted', [
                'user_id' => $user->id,
                'old_nim' => $oldNim,
                'admin_id' => auth()->id()
            ]);

            $user->update($validated);

            // Update payment UKT menjadi pending-offline
            $paymentUkt = Payment::where('user_id', $user->id)
                ->where('tipe_pembayaran', 'ukt')
                ->first();

            if ($paymentUkt) {
                $paymentUkt->update(['status_transaksi' => 'pending-offline']);
                Log::info('✅ Updated UKT payment to pending-offline', [
                    'payment_id' => $paymentUkt->id
                ]);
            }

            return redirect()->route('admin.user.index')
                ->with('warning', "User berhasil diupdate. NIM ($oldNim) telah dihapus karena status UKT dibatalkan.");
        }
    
        // CASE 2: UKT DI-CHECK (dari FALSE ke TRUE) - GENERATE NIM & BUAT/UPDATE PAYMENT
        if (!$wasUktPaid && $nowUktPaid && empty($user->nim)) {
            Log::info('🎯 Admin checklist UKT paid, generating NIM', [
                'user_id' => $user->id,
                'admin_id' => auth()->id()
            ]);
        
            $user->update($validated);
        
            // Generate NIM menggunakan fungsi di BayarUktController
            $bayarUktController = app(\App\Http\Controllers\BayarUktController::class);
            $nim = $bayarUktController->generateNIM($user);
        
            if ($nim) {
                $user->nim = $nim;
                $user->save();
            
                Log::info('✅ NIM generated successfully by admin', [
                    'user_id' => $user->id,
                    'nim' => $nim,
                    'admin_id' => auth()->id()
                ]);

                // Buat atau update payment record
                $this->createOrUpdateOfflinePayment($user, 'ukt');
            
                return redirect()->route('admin.user.index')
                    ->with('success', 'User berhasil diupdate! NIM: ' . $nim . ' - Pembayaran UKT tercatat.');
            } else {
                Log::error('❌ Failed to generate NIM', [
                    'user_id' => $user->id,
                    'admin_id' => auth()->id()
                ]);
            
                return redirect()->route('admin.user.index')
                    ->with('warning', 'User berhasil diupdate, tapi gagal generate NIM. Silakan coba lagi.');
            }
        }
    
        // ========== CASE 3: NO CHANGE atau UPDATE BIASA ==========
        $user->update($validated);
    
        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil diupdate!');
    }

    /**
     * Helper: Buat atau update payment record untuk pembayaran offline
     * 
     * @param User $user
     * @param string $tipePembayaran ('pendaftaran' atau 'ukt')
     * @return void
     */
    private function createOrUpdateOfflinePayment(User $user, string $tipePembayaran)
    {
        try {
            // Ambil biaya dari database
            $biaya = BiayaPmb::where('tahun', date('Y'))
                ->where('kodeProdi', $user->pilihan_1)
                ->first();

            if (!$biaya) {
                Log::error('❌ Biaya tidak ditemukan', [
                    'user_id' => $user->id,
                    'kodeProdi' => $user->pilihan_1,
                    'tipe_pembayaran' => $tipePembayaran
                ]);
                return;
            }

            // Tentukan jumlah berdasarkan tipe pembayaran
            $jumlah = $tipePembayaran === 'pendaftaran' 
                ? $biaya->biaya_pendaftaran 
                : $biaya->biaya_ukt;

            // Cek apakah sudah ada payment
            $existingPayment = Payment::where('user_id', $user->id)
                ->where('tipe_pembayaran', $tipePembayaran)
                ->first();

            if ($existingPayment) {
                // Update existing payment jadi settlement dan update jumlah
                $existingPayment->update([
                    'status_transaksi' => 'settlement',
                    'jumlah' => $jumlah,
                    'metode_pembayaran' => 'offline',
                ]);

                Log::info('✅ Updated existing payment to settlement', [
                    'payment_id' => $existingPayment->id,
                    'tipe_pembayaran' => $tipePembayaran,
                    'jumlah' => $jumlah
                ]);
            } else {
                // Buat payment baru
                Payment::create([
                    'user_id' => $user->id,
                    'order_id' => 'ADMIN-OFFLINE-' . strtoupper($tipePembayaran) . '-' . $user->id . '-' . time(),
                    'jumlah' => $jumlah,
                    'tipe_pembayaran' => $tipePembayaran,
                    'status_transaksi' => 'settlement',
                    'metode_pembayaran' => 'offline',
                ]);

                Log::info('✅ Created new offline payment record', [
                    'user_id' => $user->id,
                    'tipe_pembayaran' => $tipePembayaran,
                    'jumlah' => $jumlah
                ]);
            }
        } catch (\Exception $e) {
            Log::error('❌ Failed to create/update payment record', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
                'tipe_pembayaran' => $tipePembayaran
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil dihapus!');
    }
}