<div class="py-[100px] bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center text-left mb-12">
            <h2 class="text-3xl font-bold uppercase text-[#263238] mb-4 md:mb-0">
                Kata penghuni Kost Aditio
            </h2>
            <p class="text-gray-600 text-[20px] leading-7 text-right">
                Dengarkan cerita penghuni Kost Aditio tentang fasilitas lengkap, lingkungan nyaman, dan kemudahan akses.
                Bukti nyata kualitas kami!
            </p>
        </div>

        @php
            $testimonials = App\Models\Testimonial::with(['user', 'user.booking.kamar.tipeKamar'])
                ->where('status', 'approved')
                ->latest()
                ->get();
        @endphp

        <div x-data="{
            testimonials: [
                @foreach ($testimonials as $testimonial)
                        {
                            text: '{{ addslashes($testimonial->pesan) }}', 
                            name: '{{ addslashes($testimonial->user->name) }}', 
                            room: '{{ optional(optional(optional(optional($testimonial->user)->booking)->kamar)->tipeKamar)->nama_tipe ?? 'Penghuni' }}', 
                            photo: '{{ $testimonial->user->profile_photo_url ?? asset('images/default-avatar.jpg') }}',
                            rating: {{ $testimonial->rating }}
                        }@if (!$loop->last),@endif @endforeach
            ],
            start: 0,
            get end() { return this.start + (window.innerWidth >= 768 ? 3 : 1); },
            next() { if (this.end < this.testimonials.length) this.start++; },
            prev() { if (this.start > 0) this.start--; },
            direction: 'right',
            get hasNext() { return this.end < this.testimonials.length; },
            get hasPrev() { return this.start > 0; }
        }" class="relative" x-init="$watch('testimonials', value => { if (value.length <= 0) testimonials = [{ text: 'Belum ada testimoni', name: '', room: '', photo: '{{ asset('images/default-avatar.jpg') }}', rating: 0 }]; })">
            <!-- Arrow Left -->
            <button @click="direction='left';prev()"
                :class="{ 'opacity-50 cursor-not-allowed': !hasPrev, 'hover:bg-[#b96a23]': hasPrev }"
                :disabled="!hasPrev"
                class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-[#DC8330] text-white rounded-full p-3 shadow-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Arrow Right -->
            <button @click="direction='right';next()"
                :class="{ 'opacity-50 cursor-not-allowed': !hasNext, 'hover:bg-[#b96a23]': hasNext }"
                :disabled="!hasNext"
                class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-[#DC8330] text-white rounded-full p-3 shadow-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div class="overflow-hidden px-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <template x-if="testimonials.length === 0">
                        <div class="md:col-span-3 py-16 text-center text-gray-500">
                            <p class="text-xl">Belum ada testimoni</p>
                        </div>
                    </template>

                    <template x-for="(item, idx) in testimonials.slice(start, end)" :key="idx">
                        <div x-transition:enter="transition transform duration-500"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition transform duration-500"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center h-full">
                            <div
                                class="w-20 h-20 rounded-full flex items-center justify-center mb-4 border-4 border-[#DC8330] bg-amber-500 text-white font-bold text-xl">
                                <span x-text="item.name.substring(0, 2).toUpperCase()"></span>
                            </div>
                            <div class="mt-auto">
                                <div class="flex items-center gap-2 mb-1 justify-center">
                                    <span class="font-semibold text-[#263238]" x-text="item.name"></span>
                                    <span class="text-xs text-gray-400" x-text="item.room"></span>
                                </div>
                                <div class="flex items-center justify-center">
                                    <template x-for="star in 5" :key="star">
                                        <svg class="w-5 h-5"
                                            :class="star <= item.rating ? 'text-yellow-400' : 'text-gray-300'"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <polygon
                                                points="9.9,1.1 12.3,6.6 18.2,7.3 13.6,11.4 14.8,17.2 9.9,14.2 5,17.2 6.2,11.4 1.6,7.3 7.5,6.6" />
                                        </svg>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Pagination Dots -->
            <div class="flex justify-center mt-8 gap-2"
                x-show="testimonials.length > (window.innerWidth >= 768 ? 3 : 1)">
                <template
                    x-for="(_, i) in Array.from({ length: Math.ceil(testimonials.length / (window.innerWidth >= 768 ? 3 : 1)) })"
                    :key="i">
                    <button @click="start = i * (window.innerWidth >= 768 ? 3 : 1)"
                        class="w-3 h-3 rounded-full transition-colors duration-200"
                        :class="i === Math.floor(start / (window.innerWidth >= 768 ? 3 : 1)) ? 'bg-[#DC8330]' : 'bg-gray-300'"></button>
                </template>
            </div>
        </div>
    </div>
</div>
