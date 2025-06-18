<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Menampilkan halaman testimoni
     */
    public function index()
    {
        $testimonials = Testimonial::with('user')
            ->where('status', 'approved')
            ->latest()
            ->get();
            
        $userTestimonial = Testimonial::where('user_id', Auth::id())->first();
        
        return view('dashboard.testimoni', compact('testimonials', 'userTestimonial'));
    }

    /**
     * Menampilkan halaman admin untuk mengelola testimoni
     */
    public function adminIndex()
    {
        $this->authorize('admin');
        
        $testimonials = Testimonial::with('user')
            ->latest()
            ->get();
            
        return view('admin.testimoni', compact('testimonials'));
    }

    /**
     * Menyimpan testimoni baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'pesan' => 'required|string|min:10|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Cek apakah user sudah pernah memberi testimoni
        $existingTestimonial = Testimonial::where('user_id', Auth::id())->first();
        
        if ($existingTestimonial) {
            // Update testimoni yang sudah ada
            $existingTestimonial->update([
                'pesan' => $request->pesan,
                'rating' => $request->rating,
                'status' => 'pending' // Set ke pending lagi untuk direview
            ]);
            
            return redirect()->route('dashboard.testimoni')->with('success', 'Testimoni berhasil diperbarui dan menunggu persetujuan admin.');
        }
        
        // Buat testimoni baru
        Testimonial::create([
            'user_id' => Auth::id(),
            'pesan' => $request->pesan,
            'rating' => $request->rating,
            'status' => 'pending'
        ]);
        
        return redirect()->route('dashboard.testimoni')->with('success', 'Testimoni berhasil dikirim dan menunggu persetujuan admin.');
    }

    /**
     * Mengubah status testimoni (untuk admin)
     */
    public function updateStatus(Request $request, Testimonial $testimonial)
    {
        $this->authorize('admin');
        
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);
        
        $testimonial->update([
            'status' => $request->status
        ]);
        
        return redirect()->route('admin.testimoni')->with('success', 'Status testimoni berhasil diperbarui.');
    }

    /**
     * Menghapus testimoni
     */
    public function destroy(Testimonial $testimonial)
    {
        if (Auth::id() !== $testimonial->user_id && !Auth::user()->hasRole('admin')) {
            abort(403);
        }
        
        $testimonial->delete();
        
        return back()->with('success', 'Testimoni berhasil dihapus.');
    }
}