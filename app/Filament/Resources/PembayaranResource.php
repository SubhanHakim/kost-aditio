<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Filament\Resources\PembayaranResource\RelationManagers;
use App\Models\Pembayaran;
use Filament\Forms;
use Filament\Forms\Form;
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
                //
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
                //
            ])
            ->actions([
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
