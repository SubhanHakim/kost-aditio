<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipeKamarResource\Pages;
use App\Filament\Resources\TipeKamarResource\RelationManagers;
use App\Models\TipeKamar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TipeKamarResource extends Resource
{
    protected static ?string $model = TipeKamar::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Manajemen Kamar';
    protected static ?string $navigationLabel = 'Tipe Kamar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_tipe')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Tipe Kamar'),
                Forms\Components\Textarea::make('deskripsi')
                    ->maxLength(500)
                    ->label('Deskripsi Tipe Kamar'),
                Forms\Components\TextInput::make('harga')
                    ->required()
                    ->numeric()
                    ->label('Harga Tipe Kamar'),
                Forms\Components\TextInput::make('total_kamar')
                    ->required()
                    ->numeric()
                    ->label('Total Kamar'),
                Forms\Components\FileUpload::make('image')
                    ->label('Gambar Tipe Kamar')
                    ->image()
                    ->multiple()
                    ->required()
                    ->disk('public')
                    ->directory('tipe_kamar')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Tipe Kamar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_tipe')
                    ->label('Nama Tipe Kamar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTipeKamars::route('/'),
            'create' => Pages\CreateTipeKamar::route('/create'),
            'edit' => Pages\EditTipeKamar::route('/{record}/edit'),
        ];
    }
}
