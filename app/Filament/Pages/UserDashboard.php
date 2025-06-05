<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Page;

class UserDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Dashboard User';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Filament::auth()->user();
        return $user && $user->hasRole('user');
    }

    public function mount()
    {
        $user = Filament::auth()->user();
        if (!$user || !$user->hasRole('user')) {
            abort(403);
        }
    }
}
