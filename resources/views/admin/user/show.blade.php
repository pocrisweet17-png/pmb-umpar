@extends('admin.layouts.app')

@section('title', 'Dokumen - ' . $user->nama_lengkap)
@section('page-title', 'Dokumen User')

@section('content')
<div class="space-y-6">
    
    <!-- Back Button -->
    <a href="{{ route('admin.user.index') }}" 
       class="inline-flex items-center text-gray-600 hover:text-gray-900 font-medium transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Daftar User
    </a>

    <!-- User Info Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-100">
        <div class="flex items-center mb-6">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl mr-4">
                {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $user->nama_lengkap }}</h2>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-4 border-t border-gray-200">
            <div>
                <p class="text-sm text-gray-600 font-medium">Username</p>
                <p class="text-base text-gray-900 mt-1">{{ $user->username }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 font-medium">NIK</p>
                <p class="text-base text-gray-900 mt-1">{{ $user->nik }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 font-medium">WhatsApp</p>
                <p class="text-base text-gray-900 mt-1">{{ $user->no_whatsapp }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 font-medium">Role</p>
                <p class="text-base text-gray-900 mt-1">
                    @if($user->role === 'admin')
                        <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-purple-800 bg-purple-100 rounded-full">
                            ADMIN
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-blue-800 bg-blue-100 rounded-full">
                            USER
                        </span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600 font-medium">Status Verifikasi</p>
                <p class="text-base text-gray-900 mt-1">
                    @if($user->is_verified)
                        <span class="inline-flex items-center text-xs font-semibold text-green-800 bg-green-100 px-3 py-1 rounded-full">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Verified
                        </span>
                    @else
                        <span class="inline-flex items-center text-xs font-semibold text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                            Unverified
                        </span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600 font-medium">Nomor Registrasi</p>
                <p class="text-base text-gray-900 mt-1">{{ $user->nomor_registrasi ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Documents Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Dokumen yang Diupload</h2>
            <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-4