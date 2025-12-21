<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MahasiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $status;

    public function __construct($status = null)
    {
        $this->status = $status;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Mahasiswa::with(['user', 'programStudi', 'registrasi'])
            ->where('is_daftar_ulang', true);

        // Filter berdasarkan status jika ada
        if ($this->status && $this->status !== 'all') {
            $query->where('status_daftar_ulang', $this->status);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'NIM',
            'Nama Lengkap',
            'Email',
            'Program Studi',
            'Angkatan',
            'Jenis Kelamin',
            'Agama',
            'Asal Sekolah',
            'Alamat',
            'Status Daftar Ulang',
            'Status Mahasiswa',
        ];
    }

    /**
     * @param mixed $mahasiswa
     * @return array
     */
    public function map($mahasiswa): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $mahasiswa->nim ?? '-',
            $mahasiswa->namaLengkap ?? '-',
            $mahasiswa->user->email ?? '-',
            $mahasiswa->programStudi->namaProdi ?? $mahasiswa->kodeProdi ?? '-',
            $mahasiswa->angkatan ?? '-',
            $mahasiswa->registrasi->jenisKelamin ?? '-',
            $mahasiswa->registrasi->agama ?? '-',
            $mahasiswa->registrasi->asalSekolah ?? '-',
            $mahasiswa->registrasi->alamat ?? '-',
            $this->formatStatus($mahasiswa->status_daftar_ulang),
            $mahasiswa->statusMahasiswa ?? '-',
        ];
    }

    /**
     * Format status untuk tampilan yang lebih baik
     */
    private function formatStatus($status)
    {
        $statusMap = [
            'verified' => 'Terverifikasi',
            'pending' => 'Menunggu',
            'rejected' => 'Ditolak',
        ];

        return $statusMap[$status] ?? 'Belum';
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'], // Blue-600
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Style untuk semua data
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A2:L' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Set tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 15,  // NIM
            'C' => 25,  // Nama Lengkap
            'D' => 30,  // Email
            'E' => 30,  // Program Studi
            'F' => 10,  // Angkatan
            'G' => 15,  // Jenis Kelamin
            'H' => 15,  // Agama
            'I' => 30,  // Asal Sekolah
            'J' => 40,  // Alamat
            'K' => 18,  // Status Daftar Ulang
            'L' => 15,  // Status Mahasiswa
        ];
    }
}