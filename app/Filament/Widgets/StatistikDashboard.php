<?php

namespace App\Filament\Widgets;

use App\Models\Kamar;
use App\Models\Pembayaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatistikDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Kamar', Kamar::count()),
            Stat::make('Jumlah Pendapatan', 'Rp ' . number_format(Pembayaran::where('midtrans_transaction_status', 'settlement')->sum('jumlah'), 0, ',', '.')),
            Stat::make('Penyewa Sudah Bayar', Pembayaran::where('midtrans_transaction_status', 'settlement')->distinct('user_id')->count('user_id')),
        ];
    }

    public static function canView(): bool
    {
        return true;
    }
}