<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProdi
{
    public function handle(Request $request, Closure $next)
    {
        $reg = $request->user()->registrasi;

        if (!$reg || !$reg->is_prodi_selected) {
            return redirect()->route('prodi.view')
                ->with('error', 'Silakan pilih program studi terlebih dahulu.');
        }

        return $next($request);
    }
}

class CheckBayar
{
    public function handle(Request $request, Closure $next)
    {
        $reg = $request->user()->registrasi;

        if (!$reg || !$reg->is_prodi_selected) {
            return redirect()->route('prodi.view')
                ->with('error', 'Silakan pilih program studi terlebih dahulu.');
        }

        if (!$reg->is_bayar_pendaftaran) {
            return redirect()->route('bayar.index')
                ->with('error', 'Silakan selesaikan pembayaran pendaftaran terlebih dahulu.');
        }

        return $next($request);
    }
}

class CheckLengkapi
{
    public function handle(Request $request, Closure $next)
    {
        $reg = $request->user()->registrasi;

        if (!$reg || !$reg->is_prodi_selected) {
            return redirect()->route('prodi.view')
                ->with('error', 'Silakan pilih program studi terlebih dahulu.');
        }

        if (!$reg->is_bayar_pendaftaran) {
            return redirect()->route('bayar.index')
                ->with('error', 'Silakan selesaikan pembayaran pendaftaran terlebih dahulu.');
        }

        if (!$reg->is_data_completed) {
            return redirect()->route('pendaftaran.index')
                ->with('error', 'Silakan lengkapi data diri terlebih dahulu.');
        }

        return $next($request);
    }
}

class CheckStep4
{
    public function handle(Request $request, Closure $next)
    {
        $reg = $request->user()->registrasi;

        if (
            !$reg ||
            !$reg->is_prodi_selected ||
            !$reg->is_bayar_pendaftaran ||
            !$reg->is_data_completed ||
            !$reg->is_dokumen_uploaded
        ) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan selesaikan step sebelumnya terlebih dahulu.');
        }

        return $next($request);
    }
}

class CheckStep5
{
    public function handle(Request $request, Closure $next)
    {
        $reg = $request->user()->registrasi;

        if (
            !$reg ||
            !$reg->is_prodi_selected ||
            !$reg->is_bayar_pendaftaran ||
            !$reg->is_data_completed ||
            !$reg->is_dokumen_uploaded ||
            !$reg->is_tes_selesai
        ) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan selesaikan step sebelumnya terlebih dahulu.');
        }

        return $next($request);
    }
}

class CheckStep6
{
    public function handle(Request $request, Closure $next)
    {
        $reg = $request->user()->registrasi;

        if (
            !$reg ||
            !$reg->is_prodi_selected ||
            !$reg->is_bayar_pendaftaran ||
            !$reg->is_data_completed ||
            !$reg->is_dokumen_uploaded ||
            !$reg->is_tes_selesai ||
            !$reg->is_wawancara_selesai
        ) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan selesaikan step sebelumnya terlebih dahulu.');
        }

        return $next($request);
    }
}

class CheckStep7
{
    public function handle(Request $request, Closure $next)
    {
        $reg = $request->user()->registrasi;

        if (
            !$reg ||
            !$reg->is_prodi_selected ||
            !$reg->is_bayar_pendaftaran ||
            !$reg->is_data_completed ||
            !$reg->is_dokumen_uploaded ||
            !$reg->is_tes_selesai ||
            !$reg->is_wawancara_selesai ||
            !$reg->is_daftar_ulang
        ) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan selesaikan step sebelumnya terlebih dahulu.');
        }

        return $next($request);
    }
}
