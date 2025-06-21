<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Pembayaran;
use App\Notifications\LaporanKeuanganReady;
use Carbon\Carbon;

class GenerateMonthlyFinancialReport extends Command
{
    protected $signature = 'report:financial:monthly';
    protected $description = 'Generate monthly financial report';

    public function handle()
    {
        // Set periode (bulan lalu)
        $lastMonth = Carbon::now()->subMonth();
        $period = $lastMonth->format('F Y');
        
        // Ambil data
        $total = Pembayaran::where('status', 'paid')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('jumlah');
        
        // Notifikasi admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new LaporanKeuanganReady($period, $total));
        }
        
        $this->info("Laporan keuangan untuk $period berhasil digenerate.");
        
        return Command::SUCCESS;
    }
}