<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
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
}