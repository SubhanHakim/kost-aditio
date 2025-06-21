<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use App\Exports\LaporanKeuanganExcel;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKeuangan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationLabel = 'Laporan Keuangan';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.laporan-keuangan';
    
    public ?array $data = [];
    
    public $start_date;
    public $end_date;
    public $status = 'all';
    
    // Fungsi mount untuk mengisi nilai awal
    public function mount(): void
    {
        $this->start_date = now()->startOfMonth()->format('Y-m-d');
        $this->end_date = now()->format('Y-m-d');
        $this->status = 'all';
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Tanggal Akhir')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('Status Pembayaran')
                            ->options([
                                'all' => 'Semua Status',
                                'paid' => 'Sudah Dibayar',
                                'pending' => 'Menunggu Pembayaran',
                                'failed' => 'Gagal',
                            ])
                            ->default('all'),
                    ])
                    ->columns(3),
            ]);
    }
    
    public function submit()
    {
        $data = $this->form->getState();
        $this->data = $data;
    }
    
    public function getFinancialData()
    {
        $data = $this->form->getState();
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $status = $data['status'];
        
        $query = Pembayaran::with(['user', 'booking.kamar'])
            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);
        
        // Filter berdasarkan status jika tidak memilih 'all'
        if ($status !== 'all') {
            $query->where('status', $status);
        }
            
        $transactions = $query->orderBy('created_at', 'desc')->get();
        $total = $transactions->sum('jumlah');
        $transactionCount = $transactions->count();
        
        return [
            'transactions' => $transactions,
            'total' => $total,
            'count' => $transactionCount,
            'start_date' => $startDate->format('d M Y'),
            'end_date' => $endDate->format('d M Y'),
        ];
    }
    
    public function downloadExcel()
    {
        $data = $this->getFinancialData()['transactions'];
        $startDate = $this->form->getState()['start_date'];
        $endDate = $this->form->getState()['end_date'];
        
        return Excel::download(
            new LaporanKeuanganExcel($data, $startDate, $endDate),
            'laporan-keuangan-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}