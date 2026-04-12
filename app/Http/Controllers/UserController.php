<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        
            // Filter by verifikasi status atau progress step
            if ($request->filled('verified')) {
                $stepOrder = [
                    'step_prodi'        => 'is_prodi_selected',
                    'step_bayar'        => 'is_bayar_pendaftaran',
                    'step_data'         => 'is_data_completed',
                    'step_dokumen'      => 'is_dokumen_uploaded',
                    'step_tes'          => 'is_tes_selesai',
                    'step_wawancara'    => 'is_wawancara_selesai',
                    'step_ukt'          => 'is_ukt_paid',
                    'step_daftar_ulang' => 'is_daftar_ulang',
                ];

                $verifiedVal = $request->verified;

                if (array_key_exists($verifiedVal, $stepOrder)) {
                    $stepKeys = array_keys($stepOrder);
                    $currentIndex = array_search($verifiedVal, $stepKeys);
                    $currentField = $stepOrder[$verifiedVal];

                    $query->where($currentField, true);

                    if ($currentIndex < count($stepKeys) - 1) {
                        $nextStepKey = $stepKeys[$currentIndex + 1];
                        $nextField = $stepOrder[$nextStepKey];
                        $query->where($nextField, false);
                    }
                } else {
                    $query->where('is_verified', (int)$verifiedVal);
                }
            }

            if ($request->filled('fakultas')) {
                $kodeProdiList = \App\Models\ProgramStudy::where('fakultas_id', $request->fakultas)
                    ->pluck('kodeProdi')
                    ->toArray();

                $query->where(function($q) use ($kodeProdiList) {
                    $q->whereIn('pilihan_1', $kodeProdiList)
                    ->orWhereIn('pilihan_2', $kodeProdiList);
                });
            }

            if ($request->filled('prodi')) {
                $query->where(function($q) use ($request) {
                    $q->where('pilihan_1', $request->prodi)
                    ->orWhere('pilihan_2', $request->prodi);
                });
            }
        
            $totalVerified = User::where('is_verified', true)->count();
            $totalAdmin = User::where('role', 'admin')->count();
            
            $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

            return view('admin.user.index', compact('users', 'totalVerified', 'totalAdmin'));
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
            'role' => 'required|in:admin,user,keuangan,wr-3,admisi,dekan,pimpinan',
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
                'role' => 'required|in:admin,user,keuangan,wr-3,admisi,dekan,pimpinan',
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
        
            // Cek role user yang sedang login
            $currentUserRole = auth()->user()->role;
            $isAdmin = $currentUserRole === 'admin';
            $isKeuangan = $currentUserRole === 'keuangan';
            $isWakilRektor = $currentUserRole === 'wr-3';
            $isAdmisi = $currentUserRole === 'admisi';
            $isDekan = $currentUserRole == 'dekan';
            $isPimpinan = $currentUserRole == 'pimpinan';

            // Admin bisa update semua
            if($isAdmisi){
                return redirect()->route('admin.user.index')
                ->with('error', 'Role Admisi hanya memiliki akses view, tidak dapat melakukan perubahan data');
            }
            if ($isAdmin) {
                $validated['is_verified'] = $request->has('is_verified');
                $validated['is_prodi_selected'] = $request->has('is_prodi_selected');
                $validated['is_bayar_pendaftaran'] = $request->has('is_bayar_pendaftaran');
                $validated['is_data_completed'] = $request->has('is_data_completed');
                $validated['is_dokumen_uploaded'] = $request->has('is_dokumen_uploaded');
                $validated['is_tes_selesai'] = $request->has('is_tes_selesai');
                $validated['is_wawancara_selesai'] = $request->has('is_wawancara_selesai');
                $validated['is_daftar_ulang'] = $request->has('is_daftar_ulang');
                $validated['is_ukt_paid'] = $request->has('is_ukt_paid');
            }
            // Keuangan hanya bisa update step 2 (bayar pendaftaran) dan step 8 (bayar UKT)
            elseif ($isKeuangan) {
                $validated['is_bayar_pendaftaran'] = $request->has('is_bayar_pendaftaran');
                $validated['is_ukt_paid'] = $request->has('is_ukt_paid');
                // Pertahankan nilai lama untuk field lainnya
                unset($validated['is_verified']);
                unset($validated['is_prodi_selected']);
                unset($validated['is_data_completed']);
                unset($validated['is_dokumen_uploaded']);
                unset($validated['is_tes_selesai']);
                unset($validated['is_wawancara_selesai']);
                unset($validated['is_daftar_ulang']);
            }
            // WR-3 hanya bisa update step 6 (wawancara)
            elseif ($isWakilRektor) {
                $validated['is_wawancara_selesai'] = $request->has('is_wawancara_selesai');
                // Pertahankan nilai lama untuk field lainnya
                unset($validated['is_verified']);
                unset($validated['is_prodi_selected']);
                unset($validated['is_bayar_pendaftaran']);
                unset($validated['is_data_completed']);
                unset($validated['is_dokumen_uploaded']);
                unset($validated['is_tes_selesai']);
                unset($validated['is_daftar_ulang']);
                unset($validated['is_ukt_paid']);
            }
            elseif($isDekan){
                $validated['is_wawancara_selesai'] = $request->has('is_wawancara_selesai');
                // Pertahankan nilai lama untuk field lainnya
                unset($validated['is_verified']);
                unset($validated['is_prodi_selected']);
                unset($validated['is_bayar_pendaftaran']);
                unset($validated['is_data_completed']);
                unset($validated['is_dokumen_uploaded']);
                unset($validated['is_tes_selesai']);
                unset($validated['is_daftar_ulang']);
                unset($validated['is_ukt_paid']);
            }
            elseif($isPimpinan){
                $validated['is_wawancara_selesai'] = $request->has('is_wawancara_selesai');
                // Pertahankan nilai lama untuk field lainnya
                unset($validated['is_verified']);
                unset($validated['is_prodi_selected']);
                unset($validated['is_bayar_pendaftaran']);
                unset($validated['is_data_completed']);
                unset($validated['is_dokumen_uploaded']);
                unset($validated['is_tes_selesai']);
                unset($validated['is_daftar_ulang']);
                unset($validated['is_ukt_paid']);
            }
        
            // Only update password if provided
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }
        
            // intinya ini logic untuk ceklis dan unceklis Bayar daftar ulang
            $wasUktPaid = $user->is_ukt_paid; 
            $nowUktPaid = $validated['is_ukt_paid'] ?? $user->is_ukt_paid;
        
            // ========== CASE 1: UKT DI-UNCHECK (dari TRUE ke FALSE) ==========
            if ($wasUktPaid && !$nowUktPaid) {
                // Hapus NIM karena pembayaran dibatalkan
                $oldNim = $user->nim;
                $validated['nim'] = null;

                Log::warning('⚠️ Admin uncheck UKT paid - NIM deleted', [
                    'user_id' => $user->id,
                    'old_nim' => $oldNim,
                    'admin_id' => auth()->id()
                ]);

                $user->update($validated);
                //payment UKT jadi pending-offline di status_transaksi jika di uncheck di admin panel
                try {
                    $paymentUkt = \App\Models\Payment::where('user_id', $user->id)
                        ->where('tipe_pembayaran', 'ukt')
                        ->first();

                    if ($paymentUkt) {
                        $paymentUkt->update(['status_transaksi' => 'pending-offline']);
                        Log::info('✅ Updated UKT payment to pending-offline', [
                            'payment_id' => $paymentUkt->id
                        ]);
                    } else {
                        // Jika belum ada payment, buat dengan status pending-offline
                        $biaya = \App\Models\BiayaPmb::where('tahun', date('Y'))
                            ->where('kodeProdi', $user->pilihan_1)
                            ->first();

                        $jumlahUkt = $biaya ? $biaya->biaya_ukt : 0;

                        \App\Models\Payment::create([
                            'user_id' => $user->id,
                            'order_id' => 'ADMIN-UKT-UNCHECK-' . $user->id . '-' . time(),
                            'jumlah' => $jumlahUkt,
                            'tipe_pembayaran' => 'ukt',
                            'status_transaksi' => 'pending-offline',
                            'metode_pembayaran' => 'offline',
                        ]);

                        Log::info('✅ Created pending-offline UKT payment', [
                            'user_id' => $user->id
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('❌ Failed to update UKT payment status', [
                        'error' => $e->getMessage()
                    ]);
                }
                // ⭐ AKHIR TAMBAHAN

                return redirect()->route('admin.user.index')
                    ->with('warning', "User berhasil diupdate. NIM ($oldNim) telah dihapus karena status UKT dibatalkan.");
            }
        
            // ========== CASE 2: UKT DI-CHECK (dari FALSE ke TRUE) ==========
            if (!$wasUktPaid && $nowUktPaid && empty($user->nim)) {
                Log::info('🎯 Admin checklist UKT paid, generating NIM', [
                    'user_id' => $user->id,
                    'admin_id' => auth()->id()
                ]);
            
                // Update status dulu
                $user->update($validated);
            
               //Generate NIM menggunakan fungsi yg mu sudah di buat di BayarUktController
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
                        try {
                            $biaya = \App\Models\BiayaPmb::where('tahun', date('Y'))
                                ->where('kodeProdi', $user->pilihan_1)
                                ->first();

                            $jumlahUkt = $biaya ? $biaya->biaya_ukt : 0;

                            // Cek apakah sudah ada payment UKT
                            $existingPayment = \App\Models\Payment::where('user_id', $user->id)
                                ->where('tipe_pembayaran', 'ukt')
                                ->first();

                            if ($existingPayment) {
                                // Update existing payment jadi settlement
                                $existingPayment->update(['status_transaksi' => 'settlement']);
                                Log::info('✅ Updated existing UKT payment to settlement', [
                                    'payment_id' => $existingPayment->id
                                ]);
                            } else {
                                // Buat payment baru
                                \App\Models\Payment::create([
                                    'user_id' => $user->id,
                                    'order_id' => 'ADMIN-UKT-' . $user->id . '-' . time(),
                                    'jumlah' => $jumlahUkt,
                                    'tipe_pembayaran' => 'ukt',
                                    'status_transaksi' => 'settlement',
                                    'metode_pembayaran' => 'offline',
                                ]);
                                Log::info('✅ Created new UKT payment record', [
                                    'user_id' => $user->id
                                ]);
                            }
                        } catch (\Exception $e) {
                            Log::error('❌ Failed to create UKT payment record', [
                                'error' => $e->getMessage()
                            ]);
                        }
                
                    return redirect()->route('admin.user.index')
                        ->with('success', 'User berhasil diupdate! NIM: ' . $nim);
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
    public function toggleVerify(string $id)
    {
        $user = User::findOrFail($id);
        $user->is_verified = !$user->is_verified;
        $user->save();

        $status = $user->is_verified ? 'diverifikasi' : 'batal diverifikasi';
        return back()->with('success', "User {$user->nama_lengkap} berhasil {$status}.");
    }
}