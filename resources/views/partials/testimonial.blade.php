<div class="py-[100px]">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center text-left mb-12">
            <h2 class="text-3xl font-bold uppercase text-[#263238] mb-4 md:mb-0">
                Kata penghuni Kost Aditio
            </h2>
            <p class="text-gray-600 text-[20px] leading-7 text-right">
                Dengarkan cerita penghuni Kost Aditio tentang fasilitas lengkap, lingkungan nyaman, dan kemudahan akses. Bukti nyata kualitas kami!
            </p>
        </div>
        <div 
            x-data="{
                testimonials: [
                    { text: 'Kostnya nyaman, fasilitas lengkap, dan ibu kos sangat ramah!', name: 'Rina', room: 'Kamar Deluxe', photo: '{{ asset('images/testi1.jpg') }}', rating: 5 },
                    { text: 'Lingkungan bersih dan akses ke kampus sangat mudah.', name: 'Budi', room: 'Kamar Standar', photo: '{{ asset('images/testi2.jpg') }}', rating: 4 },
                    { text: 'Harga terjangkau, kamar selalu bersih, recommended!', name: 'Siti', room: 'Kamar Premium', photo: '{{ asset('images/testi3.jpg') }}', rating: 5 },
                    { text: 'Wifi kencang, cocok untuk mahasiswa yang sering online.', name: 'Andi', room: 'Kamar Standar', photo: '{{ asset('images/testi4.jpg') }}', rating: 4 },
                    { text: 'Fasilitas dapur sangat membantu, serasa di rumah sendiri.', name: 'Dewi', room: 'Kamar Premium', photo: '{{ asset('images/testi5.jpg') }}', rating: 5 }
                ],
                start: 0,
                get end() { return this.start + 3; },
                next() { if(this.end < this.testimonials.length) this.start++; },
                prev() { if(this.start > 0) this.start--; },
                direction: 'right'
            }" class="relative">
            <!-- Arrow Left -->
            <button @click="direction='left';prev()" 
                :disabled="start === 0"
                class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-[#DC8330] text-white rounded-full p-3 shadow-lg hover:bg-[#b96a23] transition disabled:opacity-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <!-- Arrow Right -->
            <button @click="direction='right';next()" 
                :disabled="end >= testimonials.length"
                class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-[#DC8330] text-white rounded-full p-3 shadow-lg hover:bg-[#b96a23] transition disabled:opacity-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <div class="overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <template x-for="(item, idx) in testimonials.slice(start, end)" :key="idx">
                        <div 
                            x-transition:enter="transition transform duration-500"
                            x-transition:enter-start="opacity-0 scale-90 translate-x-16"
                            x-transition:enter-end="opacity-100 scale-100 translate-x-0"
                            x-transition:leave="transition transform duration-500"
                            x-transition:leave-start="opacity-100 scale-100 translate-x-0"
                            x-transition:leave-end="opacity-0 scale-90 -translate-x-16"
                            class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center"
                        >
                            <img :src="item.photo" alt="" class="w-20 h-20 rounded-full object-cover mb-4 border-4 border-[#DC8330]">
                            <div class="mb-3 text-gray-700 italic" x-text="item.text"></div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-[#263238]" x-text="item.name"></span>
                                <span class="text-xs text-gray-400" x-text="item.room"></span>
                            </div>
                            <div class="flex items-center justify-center">
                                <template x-for="star in 5" :key="star">
                                    <svg class="w-5 h-5" :class="star <= item.rating ? 'text-yellow-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                        <polygon points="9.9,1.1 12.3,6.6 18.2,7.3 13.6,11.4 14.8,17.2 9.9,14.2 5,17.2 6.2,11.4 1.6,7.3 7.5,6.6"/>
                                    </svg>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>