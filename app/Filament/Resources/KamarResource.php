<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KamarResource\Pages;
use App\Filament\Resources\KamarResource\RelationManagers;
use App\Models\Kamar;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KamarResource extends Resource
{
    protected static ?string $model = Kamar::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationGroup = 'Manajemen Kamar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tipe_kamar_id')
                    ->relationship('tipeKamar', 'nama_tipe')
                    ->required()
                    ->label('Tipe Kamar')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Reset no_kamar jika tipe kamar berubah
                        $set('no_kamar', null);
                    }),
                Forms\Components\TextInput::make('no_kamar')
                    ->required()
                    ->maxLength(50)
                    ->label('Nomor Kamar')
                    ->unique(ignoreRecord: true)
                    ->rule(function (callable $get) {
                        return function ($attribute, $value, $fail) use ($get) {
                            $tipeKamarId = $get('tipe_kamar_id');
                            if (!$tipeKamarId) return;

                            // Hitung jumlah kamar yang sudah ada untuk tipe ini
                            $jumlahKamarTipeIni = Kamar::where('tipe_kamar_id', $tipeKamarId)->count();

                            // Ambil jumlah maksimal dari tabel tipe_kamars
                            $maxKamar = \App\Models\TipeKamar::find($tipeKamarId)?->total_kamar ?? null;

                            if ($maxKamar !== null && $jumlahKamarTipeIni >= $maxKamar) {
                                $fail('Jumlah kamar untuk tipe ini sudah mencapai batas maksimal (' . $maxKamar . ').');
                            }
                        };
                    }),
                Forms\Components\Select::make('status')
                    ->options([
                        'tersedia' => 'Tersedia',
                        'tidak_tersedia' => 'Tidak Tersedia',
                    ])
                    ->default('tersedia')
                    ->required()
                    ->label('Status Kamar'),
                Forms\Components\CheckboxList::make('fasilitas')
                    ->relationship('fasilitas', 'nama_fasilitas')
                    ->label('Fasilitas Kamar')
                    ->columns(2)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Kamar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipeKamar.nama_tipe')
                    ->label('Tipe Kamar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_kamar')
                    ->label('Nomor Kamar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Kamar')
                    ->sortable()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'tersedia' => 'Tersedia',
                        'tidak_tersedia' => 'Tidak Tersedia',
                        default => ucfirst($state),
                    }),


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
            'index' => Pages\ListKamars::route('/'),
            'create' => Pages\CreateKamar::route('/create'),
            'edit' => Pages\EditKamar::route('/{record}/edit'),
        ];
    }
}
