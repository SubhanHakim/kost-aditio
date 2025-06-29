<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Keluhan;

class KeluhanManajemen extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'Manajemen Keluhan';
    protected static ?string $navigationGroup = 'Manajemen Keluhan';
    protected static string $view = 'filament.pages.keluhan-manajemen';

    public $keluhans;

    public function mount()
    {
        $this->keluhans = Keluhan::with(['user', 'kamar'])->latest()->get();
    }

    public function updateStatus($id, $status)
    {
        $keluhan = Keluhan::findOrFail($id);
        $keluhan->status = $status;
        $keluhan->save();
        $this->mount(); // refresh data
        session()->flash('success', 'Status keluhan berhasil diubah.');
    }
}