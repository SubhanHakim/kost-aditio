{{-- filepath: resources/views/dashboard/testimoni.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between py-2" aria-label="Global">
            <div class="flex items-center gap-4">
                <div class="relative xl:hidden">
                    <a class="text-xl icon-hover cursor-pointer text-heading p-2 rounded-md hover:bg-gray-100"
                        id="headerCollapse" data-hs-overlay="#application-sidebar-brand"
                        aria-controls="application-sidebar-brand" aria-label="Toggle navigation"
                        href="javascript:void(0)">
                        <i class="ti ti-menu-2 relative z-1"></i>
                    </a>
                </div>

                <div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $title ?? 'Testimoni' }}</h1>
                    <div class="text-sm text-gray-500 flex items-center">
                        <a href="/dashboard" class="hover:text-amber-600">Home</a>
                        <span class="mx-2">/</span>
                        <a href="/dashboard/testimoni" class="hover:text-amber-600">Testimoni</a>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>

    <div class="flex flex-col gap-6">
        <!-- Form Testimoni -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="bg-amber-600 px-6 py-4">
                <h4 class="text-white text-lg font-bold">Berikan Testimoni</h4>
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="mb-6 p-3 bg-green-100 text-green-800 font-medium rounded-lg border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('dashboard.testimoni.store') }}" class="space-y-5 max-w-xl">
                    @csrf
                    <div>
                        <label class="block text-base font-medium text-black mb-2">Rating</label>
                        <div class="flex items-center gap-2 star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer star-label" data-rating="{{ $i }}">
                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden"
                                        {{ $userTestimonial && $userTestimonial->rating == $i ? 'checked' : '' }}
                                        {{ !$userTestimonial && $i == 5 ? 'checked' : '' }}>
                                    <span class="text-3xl text-gray-300 star-icon">★</span>
                                </label>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-base font-medium text-black dark:text-white mb-2">Pesan
                            Testimoni</label>
                        <textarea name="pesan" rows="4"
                            class="w-full p-3 rounded-md border border-gray-300 dark:border-gray-600 text-base"
                            placeholder="Bagikan pengalaman Anda tinggal di Kost Aditio..." required>{{ $userTestimonial ? $userTestimonial->pesan : '' }}</textarea>
                        @error('pesan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="px-6 py-3 bg-amber-600 text-white font-bold rounded-md hover:bg-amber-700">
                        {{ $userTestimonial ? 'Perbarui Testimoni' : 'Kirim Testimoni' }}
                    </button>
                </form>

                @if ($userTestimonial)
                    <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        @if ($userTestimonial->status == 'pending')
                            <div class="p-2 bg-yellow-50 text-yellow-800 border border-yellow-200 rounded-md">
                                Testimoni Anda sedang menunggu persetujuan admin.
                            </div>
                        @elseif ($userTestimonial->status == 'rejected')
                            <div class="p-2 bg-red-50 text-red-800 border border-red-200 rounded-md">
                                Testimoni Anda ditolak. Silakan perbarui dengan konten yang sesuai.
                            </div>
                        @elseif ($userTestimonial->status == 'approved')
                            <div class="p-2 bg-green-50 text-green-800 border border-green-200 rounded-md">
                                Testimoni Anda telah disetujui dan ditampilkan.
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Daftar Testimoni -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="bg-amber-600 px-6 py-4">
                <h4 class="text-white text-lg font-bold">Testimoni Penghuni Kost</h4>
            </div>

            <div class="p-6">
                @if ($testimonials->isEmpty())
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <p class="text-lg">Belum ada testimoni yang ditampilkan.</p>
                        <p class="mt-2">Jadilah yang pertama memberikan testimoni!</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($testimonials as $testimoni)
                            <div
                                class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="bg-amber-500 w-10 h-10 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($testimoni->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-black dark:text-white">
                                                {{ $testimoni->user->name }}</h5>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $testimoni->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-amber-500 text-lg">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span>{{ $i <= $testimoni->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300">{{ $testimoni->pesan }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const starContainer = document.querySelector('.star-rating');
            const stars = document.querySelectorAll('.star-label');
            const starIcons = document.querySelectorAll('.star-icon');


            function updateStars(rating) {
                starIcons.forEach((star, index) => {

                    if (index + 1 <= rating) {
                        star.classList.add('text-amber-500');
                        star.classList.remove('text-gray-300');
                    } else {
                        star.classList.remove('text-amber-500');
                        star.classList.add('text-gray-300');
                    }
                });
            }
            const checkedInput = document.querySelector('.star-rating input:checked');
            if (checkedInput) {
                updateStars(checkedInput.value);
            } else if (!{{ isset($userTestimonial) ? 'true' : 'false' }}) {
                updateStars(5);
            }
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    updateStars(rating);
                });
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    updateStars(rating);
                });
            });

            starContainer.addEventListener('mouseleave', function() {
                const checkedInput = document.querySelector('.star-rating input:checked');
                if (checkedInput) {
                    updateStars(checkedInput.value);
                } else {
                    updateStars(0);
                }
            });
        });
    </script>
</x-app-layout>
