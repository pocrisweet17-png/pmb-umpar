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

