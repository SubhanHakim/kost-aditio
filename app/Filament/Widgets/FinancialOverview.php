<?php
// app/Filament/Widgets/FinancialOverview.php

namespace App\Filament\Widgets;

use App\Models\Pembayaran;
use App\Models\Pengeluaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinancialOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Total pendapatan bulan ini
        $totalThisMonth = Pembayaran::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('jumlah');
        
        // Total pendapatan bulan lalu
        $totalLastMonth = Pembayaran::where('status', 'paid')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('jumlah');
        
        // Persentase perubahan dari bulan lalu
        $percentageChange = 0;
        if ($totalLastMonth > 0) {
            $percentageChange = (($totalThisMonth - $totalLastMonth) / $totalLastMonth) * 100;
        }
        
        // Jumlah transaksi bulan ini
        $transactionCount = Pembayaran::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        return [
            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($totalThisMonth, 0, ',', '.'))
                ->description($percentageChange >= 0 
                    ? $percentageChange . '% kenaikan' 
                    : abs($percentageChange) . '% penurunan')
                ->descriptionIcon($percentageChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($percentageChange >= 0 ? 'success' : 'danger'),
                
            Stat::make('Jumlah Transaksi', $transactionCount)
                ->description('Bulan ' . now()->format('F Y'))
                ->color('primary'),
                
            Stat::make('Pendapatan Tahun Ini', 'Rp ' . number_format(
                Pembayaran::where('status', 'paid')
                    ->whereYear('created_at', now()->year)
                    ->sum('jumlah'), 0, ',', '.'
            ))
                ->description('Sejak 1 Jan ' . now()->year)
                ->color('success'),
        ];
    }
}