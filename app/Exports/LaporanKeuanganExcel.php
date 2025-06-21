<?php
// app/Exports/LaporanKeuanganExcel.php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class LaporanKeuanganExcel implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, ShouldAutoSize
{
    protected $data;
    protected $startDate;
    protected $endDate;

    public function __construct(Collection $data, $startDate = null, $endDate = null)
    {
        $this->data = $data;
        $this->startDate = $startDate ? Carbon::parse($startDate)->format('d M Y') : 'Semua Waktu';
        $this->endDate = $endDate ? Carbon::parse($endDate)->format('d M Y') : 'Sekarang';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Pembayaran',
            'Tanggal',
            'Nama Pengguna',
            'No. Kamar',
            'Status',
            'Metode Pembayaran',
            'Jumlah (Rp)',
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->created_at->format('d/m/Y H:i'),
            $row->user->name ?? 'N/A',
            $row->booking->kamar->no_kamar ?? 'N/A',
            $this->formatStatus($row->status),
            $this->getPaymentMethod($row->midtrans_transaction_status),
            $row->jumlah,
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return "Laporan Keuangan {$this->startDate} - {$this->endDate}";
    }
    
    /**
     * Style the excel sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'], // Indigo-600
            ],
        ]);
        
        // Footer dengan total
        $lastRow = $this->data->count() + 2;
        $sheet->setCellValue('F' . $lastRow, 'TOTAL:');
        $sheet->setCellValue('G' . $lastRow, $this->data->sum('jumlah'));
        
        $sheet->getStyle('F' . $lastRow . ':G' . $lastRow)->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F3F4F6'], // Gray-100
            ],
        ]);
        
        // Format currency
        $sheet->getStyle('G2:G' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
        
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
    
    /**
     * Format payment status
     */
    private function formatStatus($status)
    {
        return match($status) {
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Sedang Diproses',
            'paid' => 'Sudah Dibayar',
            'failed' => 'Gagal',
            'refunded' => 'Dikembalikan',
            default => ucfirst($status)
        };
    }
    
    /**
     * Get payment method from midtrans status
     */
    private function getPaymentMethod($midtransStatus)
    {
        // Ini hanya contoh sederhana, sesuaikan dengan data yang sebenarnya
        // Idealnya Anda mengambil data metode pembayaran dari respons Midtrans
        if (strpos($midtransStatus, 'bank_transfer') !== false) {
            return 'Transfer Bank';
        } elseif (strpos($midtransStatus, 'gopay') !== false) {
            return 'GoPay';
        } elseif (strpos($midtransStatus, 'shopeepay') !== false) {
            return 'ShopeePay';
        } else {
            return 'Lainnya';
        }
    }
}