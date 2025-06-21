<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Filament\Resources\PembayaranResource\RelationManagers;
use App\Models\Pembayaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Pembayaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Informasi Pembayaran')
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->label('ID Pembayaran')
                            ->disabled(),

                        Forms\Components\TextInput::make('user.name')
                            ->label('Nama Pengguna')
                            ->disabled(),

                        Forms\Components\TextInput::make('booking.kamar.no_kamar')
                            ->label('Nomor Kamar')
                            ->disabled(),

                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah Pembayaran')
                            ->disabled()
                            ->prefix('Rp'),

                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Tanggal Pembayaran')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Status Pembayaran')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status Pembayaran')
                            ->options([
                                'pending' => 'Menunggu Pembayaran',
                                'processing' => 'Sedang Diproses',
                                'paid' => 'Sudah Dibayar',
                                'failed' => 'Gagal',
                                'refunded' => 'Dikembalikan',
                            ])
                            ->required()
                            ->helperText('Perubahan status akan mempengaruhi data tagihan pengguna')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Catatan Admin')
                            ->placeholder('Tambahkan catatan tentang perubahan status ini')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Bukti Pembayaran')
                    ->schema([
                        Forms\Components\FileUpload::make('bukti_pembayaran')
                            ->label('Bukti Pembayaran')
                            ->disabled()
                            ->image()
                            ->visible(fn($record) => $record && $record->bukti_pembayaran),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Pembayaran')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pengguna')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kamar.no_kamar')
                    ->label('Nama Kamar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah Pembayaran')
                    ->sortable()
                    ->money('idr'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pembayaran')
                    ->sortable()
                    ->dateTime('d M Y'),
                Tables\Columns\TextColumn::make('midtrans_transaction_status')
                    ->label('Status Pembayaran')
                    ->sortable()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pending' => 'Pending',
                        'settlement' => 'Lunas',
                        'deny' => 'Ditolak',
                        'expire' => 'Kadaluarsa',
                        'cancel' => 'Dibatalkan',
                        default => ucfirst($state),
                    })
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'settlement' => 'success',
                        'pending' => 'warning',
                        'deny', 'expire', 'cancel' => 'danger',
                        default => 'secondary',
                    })
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'processing' => 'Sedang Diproses',
                        'paid' => 'Sudah Dibayar',
                        'failed' => 'Gagal',
                        'refunded' => 'Dikembalikan',
                    ]),

                Tables\Filters\Filter::make('bukti_but_pending')
                    ->label('Ada Bukti Tapi Masih Pending')
                    ->query(fn(Builder $query) => $query->whereNotNull('bukti_pembayaran')->where('status', 'pending')),

                Tables\Filters\Filter::make('midtrans_mismatch')
                    ->label('Status Midtrans Tidak Sesuai')
                    ->query(fn(Builder $query) => $query->whereColumn('midtrans_transaction_status', '!=', 'status')
                        ->orWhere(function ($q) {
                            $q->where('midtrans_transaction_status', 'settlement')
                                ->where('status', '!=', 'paid');
                        })),
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                ->label('Verifikasi')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (Pembayaran $record) => $record->status !== 'paid')
                ->action(function (Pembayaran $record) {
                    $record->status = 'paid';
                    $record->midtrans_transaction_status = 'settlement';
                    $record->tanggal_verifikasi = now();
                    $record->save();
                    
                    // Update booking & kamar
                    $booking = $record->booking;
                    if ($booking) {
                        $booking->status_booking = 'confirmed';
                        $booking->save();

                        if ($booking->kamar) {
                            $booking->kamar->status = 'ditempati';
                            $booking->kamar->save();
                        }
                    }
                    
                    Notification::make()
                        ->title('Pembayaran berhasil diverifikasi')
                        ->success()
                        ->send();
                }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembayarans::route('/'),
            'create' => Pages\CreatePembayaran::route('/create'),
            'edit' => Pages\EditPembayaran::route('/{record}/edit'),
        ];
    }
}
