<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use App\Models\Pembayaran;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class EditPembayaran extends EditRecord
{
    protected static string $resource = PembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('verifyPayment')
                ->label('Verifikasi Pembayaran')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(function () {
                    if (!Schema::hasColumn('pembayarans', 'status')) {
                        return false;
                    }
                    return $this->record->status !== 'paid';
                })
                ->action(function () {
                    $pembayaran = $this->record;
                    
                    // Periksa kolom apa saja yang tersedia
                    if (Schema::hasColumn('pembayarans', 'status')) {
                        $pembayaran->status = 'paid';
                    }
                    
                    $pembayaran->midtrans_transaction_status = 'settlement';
                    
                    if (Schema::hasColumn('pembayarans', 'tanggal_verifikasi')) {
                        $pembayaran->tanggal_verifikasi = now();
                    }
                    
                    if (Schema::hasColumn('pembayarans', 'catatan_admin')) {
                        $pembayaran->catatan_admin = 'Pembayaran diverifikasi manual oleh admin pada ' . now()->format('d M Y H:i');
                    }
                    
                    $pembayaran->save();
                    
                    // Update booking & kamar
                    $this->updateBookingAndRoom($pembayaran);
                    
                    Notification::make()
                        ->title('Pembayaran berhasil diverifikasi')
                        ->success()
                        ->send();
                        
                    $this->redirect(PembayaranResource::getUrl('edit', ['record' => $pembayaran->id]));
                }),
                
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function afterSave(): void
    {
        // Jika status berubah menjadi 'paid', update booking & kamar
        if (Schema::hasColumn('pembayarans', 'status') && 
            $this->record->wasChanged('status') && 
            $this->record->status === 'paid') {
            
            $this->updateBookingAndRoom($this->record);
            
            // Log aktivitas
            Log::info('Pembayaran diubah ke status PAID oleh admin', [
                'pembayaran_id' => $this->record->id,
                'user_id' => $this->record->user_id,
                'admin_id' => Auth::id(),
            ]);
            
            Notification::make()
                ->title('Status pembayaran berhasil diubah ke PAID')
                ->body('Kamar dan booking status juga telah diperbarui')
                ->success()
                ->send();
        }
    }
    
    private function updateBookingAndRoom(Pembayaran $pembayaran): void
    {
        $booking = $pembayaran->booking;
        if ($booking) {
            $booking->status_booking = 'confirmed';
            $booking->save();

            if ($booking->kamar) {
                $booking->kamar->status = 'ditempati';
                $booking->kamar->save();
            }
        }
    }
}