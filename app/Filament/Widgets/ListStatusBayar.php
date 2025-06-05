<?php

namespace App\Filament\Widgets;

use App\Models\Pembayaran;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;

class ListStatusBayar extends BaseWidget
{
    protected static ?string $heading = 'Status Pembayaran Penyewa';
    protected int | string | array $columnSpan = 'full';

    public function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->query(
                Pembayaran::query()->with('user')
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Nama'),
                Tables\Columns\TextColumn::make('user.email')->label('Email'),
                Tables\Columns\TextColumn::make('midtrans_transaction_status')
                    ->label('Status Bayar')
                    ->formatStateUsing(fn($state) =>
                        $state === 'settlement' ? 'Sudah Bayar' : 'Belum Bayar'
                    )
                    ->badge()
                    ->color(fn($state) =>
                        $state === 'settlement' ? 'success' : 'danger'
                    ),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Pembayaran')->dateTime('d M Y H:i'),
            ]);
    }
}