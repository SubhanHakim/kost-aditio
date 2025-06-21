<?php
// app/Notifications/LaporanKeuanganReady.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LaporanKeuanganReady extends Notification
{
    use Queueable;
    
    protected $period;
    protected $total;
    
    public function __construct($period, $total)
    {
        $this->period = $period;
        $this->total = $total;
    }
    
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Laporan Keuangan ' . $this->period . ' Telah Siap')
                    ->greeting('Halo ' . $notifiable->name)
                    ->line('Laporan keuangan untuk periode ' . $this->period . ' telah siap.')
                    ->line('Total pendapatan: Rp ' . number_format($this->total, 0, ',', '.'))
                    ->action('Lihat Laporan', url('/admin/laporan-keuangan'))
                    ->line('Terima kasih telah menggunakan aplikasi kami!');
    }
    
    public function toArray($notifiable)
    {
        return [
            'message' => 'Laporan keuangan untuk ' . $this->period . ' telah siap',
            'period' => $this->period,
            'total' => $this->total,
            'url' => '/admin/laporan-keuangan',
        ];
    }
}