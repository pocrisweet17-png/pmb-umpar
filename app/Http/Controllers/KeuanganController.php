<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    /**
     * Apply shared filters to a query.
     */
    private function applyFilters($query, Request $request)
    {
        // Filter by tipe pembayaran
        if ($request->filled('tipe_pembayaran')) {
            $query->where('tipe_pembayaran', $request->tipe_pembayaran);
        }

        // Filter by status transaksi
        if ($request->filled('status_transaksi')) {
            $query->where('status_transaksi', $request->status_transaksi);
        }

        // Filter by metode pembayaran
        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        // Filter by jenjang (S1, S2, S3)
        if ($request->filled('jenjang')) {
            $jenjang = $request->jenjang;
            $query->whereHas('user.programStudiPilihan1', function ($q) use ($jenjang) {
                $q->where('jenjang', $jenjang);
            });
        }

        // Search by nama lengkap atau order_id
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('nama_lengkap', 'LIKE', "%{$search}%")
                                ->orWhere('username', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        return $query;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['user.programStudiPilihan1']);

        $this->applyFilters($query, $request);

        $payments = $query->orderBy('created_at', 'desc')->paginate(2)->withQueryString();

        // Statistik
        $totalPendapatan = Payment::where('status_transaksi', 'settlement')->sum('jumlah');
        $totalPendaftaran = Payment::where('status_transaksi', 'settlement')
                                   ->where('tipe_pembayaran', 'pendaftaran')
                                   ->sum('jumlah');
        $totalUkt = Payment::where('status_transaksi', 'settlement')
                           ->where('tipe_pembayaran', 'ukt')
                           ->sum('jumlah');

        return view('admin.keuangan.index', compact(
            'payments',
            'totalPendapatan',
            'totalPendaftaran',
            'totalUkt'
        ));
    }

    /**
     * Export to Excel
     */
    public function export(Request $request)
    {
        $query = Payment::with(['user.programStudiPilihan1']);

        $this->applyFilters($query, $request);

        $payments = $query->orderBy('created_at', 'desc')->get();

        // Create CSV
        $filename = 'laporan_keuangan_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($payments) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, [
                'No',
                'Tanggal',
                'Order ID',
                'Nama Lengkap',
                'Email',
                'Program Studi',
                'Jenjang',
                'Tipe Pembayaran',
                'Metode Pembayaran',
                'Status',
                'Jumlah (Rp)',
            ]);

            // Data
            $no = 1;
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $no++,
                    $payment->created_at->format('d/m/Y H:i'),
                    $payment->order_id,
                    $payment->user->nama_lengkap ?? '-',
                    $payment->user->email ?? '-',
                    $payment->user->programStudiPilihan1->namaProdi ?? '-',
                    strtoupper($payment->user->programStudiPilihan1->jenjang ?? '-'),
                    ucfirst($payment->tipe_pembayaran),
                    ucfirst($payment->metode_pembayaran ?? 'Online'),
                    ucfirst($payment->status_transaksi),
                    number_format($payment->jumlah, 0, ',', '.'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show payment detail
     */
    public function show($id)
    {
        $payment = Payment::with(['user.programStudiPilihan1'])->findOrFail($id);
        return view('admin.keuangan.show', compact('payment'));
    }
}