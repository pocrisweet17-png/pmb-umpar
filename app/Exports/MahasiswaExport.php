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
    protected $filters;

    /**
     * Constructor untuk menerima filter
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Mahasiswa::with(['user', 'programStudi', 'registrasi'])
            ->where('is_daftar_ulang', true);

        // Filter by fakultas (untuk dekan)
        if (!empty($this->filters['fakultas_id'])) {
            $kodeProdiDiFakultas = \App\Models\ProgramStudy::where('fakultas_id', $this->filters['fakultas_id'])
                ->pluck('kodeProdi')
                ->toArray();
            
            if (!empty($kodeProdiDiFakultas)) {
                $query->whereIn('kodeProdi', $kodeProdiDiFakultas);
            }
        }

        // Filter by prodi
        if (!empty($this->filters['prodi'])) {
            $query->where('kodeProdi', $this->filters['prodi']);
        }

        // Filter by status
        if (!empty($this->filters['status'])) {
            $query->where('status_daftar_ulang', $this->filters['status']);
        }

        // Filter by angkatan
        if (!empty($this->filters['angkatan'])) {
            $query->where('angkatan', $this->filters['angkatan']);
        }

        // Search by name or NIM
        if (!empty($this->filters['q'])) {
            $search = $this->filters['q'];
            $query->where(function($q) use ($search) {
                $q->where('namaLengkap', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('kodeProdi')->orderBy('namaLengkap')->get();
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
            'No. WhatsApp',
            'Program Studi',
            'Angkatan',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
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

        $registrasi = $mahasiswa->registrasi;
        
        // Format tanggal lahir
        $tanggalLahir = '';
        if ($registrasi && $registrasi->tanggalLahir) {
            $tanggalLahir = date('d-m-Y', strtotime($registrasi->tanggalLahir));
        }

        return [
            $no,
            $mahasiswa->nim ?? '-',
            $mahasiswa->namaLengkap ?? '-',
            $mahasiswa->user->email ?? '-',
            $mahasiswa->user->no_whatsapp ?? '-', // Ambil dari users table
            $mahasiswa->programStudi->namaProdi ?? $mahasiswa->kodeProdi ?? '-',
            $mahasiswa->angkatan ?? '-',
            $registrasi->jenisKelamin ?? '-',
            $registrasi->tempatLahir ?? '-',
            $tanggalLahir,
            $registrasi->agama ?? '-',
            $registrasi->asalSekolah ?? '-',
            $registrasi->alamat ?? '-',
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
            'pending' => 'Menunggu Verifikasi',
            'rejected' => 'Ditolak',
        ];

        return $statusMap[$status] ?? 'Belum Daftar Ulang';
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:O1')->applyFromArray([
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
        $sheet->getStyle('A2:O' . $highestRow)->applyFromArray([
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

        // Set warna untuk status
        for ($row = 2; $row <= $highestRow; $row++) {
            $statusCell = 'N' . $row;
            $statusValue = $sheet->getCell($statusCell)->getValue();
            
            if ($statusValue == 'Terverifikasi') {
                $sheet->getStyle($statusCell)->getFont()->getColor()->setRGB('10B981');
                $sheet->getStyle($statusCell)->getFont()->setBold(true);
            } elseif ($statusValue == 'Menunggu Verifikasi') {
                $sheet->getStyle($statusCell)->getFont()->getColor()->setRGB('F59E0B');
                $sheet->getStyle($statusCell)->getFont()->setBold(true);
            } elseif ($statusValue == 'Ditolak') {
                $sheet->getStyle($statusCell)->getFont()->getColor()->setRGB('EF4444');
                $sheet->getStyle($statusCell)->getFont()->setBold(true);
            }
        }

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
            'A' => 6,   // No
            'B' => 15,  // NIM
            'C' => 28,  // Nama Lengkap
            'D' => 30,  // Email
            'E' => 18,  // No. WhatsApp
            'F' => 30,  // Program Studi
            'G' => 10,  // Angkatan
            'H' => 15,  // Jenis Kelamin
            'I' => 18,  // Tempat Lahir
            'J' => 15,  // Tanggal Lahir
            'K' => 15,  // Agama
            'L' => 30,  // Asal Sekolah
            'M' => 40,  // Alamat
            'N' => 20,  // Status Daftar Ulang
            'O' => 18,  // Status Mahasiswa
        ];
    }
}