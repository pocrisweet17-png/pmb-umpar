<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
<<<<<<< HEAD
        $middleware->alias([
        'step.prodi'     => \App\Http\Middleware\StepPilihProdi::class,
        'step.bayar'     => \App\Http\Middleware\StepBayarPendaftaran::class,
        'step.data'      => \App\Http\Middleware\StepLengkapiData::class,
        'step.dokumen'   => \App\Http\Middleware\StepUploadDokumen::class,
        'step.tes'       => \App\Http\Middleware\StepTes::class,
        'step.wawancara' => \App\Http\Middleware\StepWawancara::class,
        'step.daftarulang'=> \App\Http\Middleware\StepDaftarUlang::class,
        'step.ukt'       => \App\Http\Middleware\StepBayarUkt::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

=======
        // Exclude CSRF untuk webhook Midtrans
        $middleware->validateCsrfTokens(except: [
            '/midtrans/webhook',
        ]);
    // ---
        $middleware->alias([
            'step.prodi'        => \App\Http\Middleware\StepPilihProdi::class,
            'check.bayar'       => \App\Http\Middleware\StepBayarPendaftaran::class,
            'check.lengkapi'    => \App\Http\Middleware\StepLengkapiData::class,
            'check.dokumen'     => \App\Http\Middleware\StepUploadDokumen::class,
            'check.tes'         => \App\Http\Middleware\StepTes::class,
            'check.wawancara'   => \App\Http\Middleware\StepWawancara::class,
            'check.ukt'         => \App\Http\Middleware\StepBayarUkt::class,
            'check.daftarulang' => \App\Http\Middleware\StepDaftarUlang::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
>>>>>>> bismillah-jadi
