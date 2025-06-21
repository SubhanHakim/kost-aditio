<?php

namespace App\Filament\Widgets;

use App\Models\Pembayaran;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class PendapatanChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Tren Pendapatan 6 Bulan Terakhir';
    
    protected int | string | array $columnSpan = 'full';
    
    protected function getData(): array
    {
        $data = [];
        $labels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M Y');
            
            $amount = Pembayaran::where('status', 'paid')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('jumlah');
                
            $data[] = $amount;
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan Bulanan',
                    'data' => $data,
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'borderColor' => 'rgb(245, 158, 11)',
                    'borderWidth' => 2,
                    'tension' => 0.3,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }
    
    protected function getType(): string
    {
        return 'line';
    }
}