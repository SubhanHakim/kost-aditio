<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Testimonial;

class TestimonialManajemen extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Manajemen Testimonial';
    protected static ?string $navigationGroup = 'Manajemen Testimonial';
    protected static string $view = 'filament.pages.testimonial-manajemen';

    public $testimonials;

    public function mount()
    {
        $this->testimonials = Testimonial::with('user')->latest()->get();
    }

    public function updateStatus($id, $status)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->status = $status;
        $testimonial->save();
        $this->mount();
        session()->flash('success', 'Status testimonial berhasil diubah.');
    }
}