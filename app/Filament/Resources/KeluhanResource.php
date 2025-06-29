<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeluhanResource\Pages;
use App\Filament\Resources\KeluhanResource\RelationManagers;
use App\Models\Keluhan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeluhanResource extends Resource
{
    protected static ?string $model = Keluhan::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationGroup = 'Manajemen Keluhan';
    protected static ?string $navigationLabel = 'Keluhan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul_keluhan')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul Keluhan'),
                Forms\Components\Textarea::make('deskripsi_keluhan')
                    ->required()
                    ->maxLength(1000)
                    ->label('Deskripsi Keluhan'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'proses' => 'Proses',
                        'selesai' => 'Selesai',
                    ])
                    ->default('pending')
                    ->required()
                    ->label('Status Keluhan'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('Pengguna'),
                Forms\Components\Select::make('kamar_id')
                    ->relationship('kamar', 'no_kamar')
                    ->required()
                    ->label('Kamar'),
                Forms\Components\TextInput::make('created_at')
                    ->disabled()
                    ->label('Tanggal Dibuat')
                    ->default(now()->format('Y-m-d H:i:s')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Keluhan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('judul_keluhan')
                    ->label('Judul Keluhan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('deskripsi_keluhan')
                    ->label('Deskripsi Keluhan')
                    ->limit(50),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Keluhan')
                    ->sortable()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pending' => 'Pending',
                        'proses' => 'Proses',
                        'selesai' => 'Selesai',
                        default => ucfirst($state),
                    }),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna'),
                Tables\Columns\TextColumn::make('kamar.no_kamar')
                    ->label('Kamar'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('Y-m-d H:i:s'),
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
            'index' => Pages\ListKeluhans::route('/'),
            // 'create' => Pages\CreateKeluhan::route('/create'),
            'edit' => Pages\EditKeluhan::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
