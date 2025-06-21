<div class="py-[100px]">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center text-left mb-8">
        <h2 class="text-3xl font-bold uppercase text-[#263238] mb-4 md:mb-0">
            Pertanyaan Umum
        </h2>
        <p class="text-gray-600 text-[20px] leading-7 text-right">
            pertanyaan yang sering ditanyakan
        </p>
    </div>

    <div class="max-w-2xl mx-auto space-y-4">
        <div x-data="{ open: false }" class="border rounded-lg bg-white shadow">
            <button @click="open = !open"
                class="w-full flex justify-between items-center px-6 py-4 text-left font-medium text-[#263238] focus:outline-none">
                <span>Apa itu Kost Aditio?</span>
                <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-700" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-transition.opacity.duration.700ms class="px-6 pb-4 text-gray-600">
                Kost Aditio adalah platform pencarian dan pemesanan kost secara online yang mudah dan terpercaya.
            </div>
        </div>
        <div x-data="{ open: false }" class="border rounded-lg bg-white shadow">
            <button @click="open = !open"
                class="w-full flex justify-between items-center px-6 py-4 text-left font-medium text-[#263238] focus:outline-none">
                <span>Bagaimana prosedur pemesanan kamar kos secara online?</span>
                <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-700" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-transition.opacity.duration.700ms class="px-6 pb-4 text-gray-600">
                Pilih kamar yang diinginkan, login atau daftar, isi data pemesanan, lakukan pembayaran, dan tunggu
                konfirmasi. Kamar siap dihuni sesuai jadwal!
            </div>
        </div>
        <div x-data="{ open: false }" class="border rounded-lg bg-white shadow">
            <button @click="open = !open"
                class="w-full flex justify-between items-center px-6 py-4 text-left font-medium text-[#263238] focus:outline-none">
                <span>Apakah tersedia kamar dengan kamar mandi dalam?</span>
                <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-700" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-transition.opacity.duration.700ms class="px-6 pb-4 text-gray-600">
                Ya, tersedia kamar dengan kamar mandi dalam. Kamu bisa memilihnya saat melihat detail tipe kamar di platform kami. 
            </div>
        </div>
        <div x-data="{ open: false }" class="border rounded-lg bg-white shadow">
            <button @click="open = !open"
                class="w-full flex justify-between items-center px-6 py-4 text-left font-medium text-[#263238] focus:outline-none">
                <span>Kos khusus pria/wanita atau campuran?</span>
                <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-700" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-transition.opacity.duration.700ms class="px-6 pb-4 text-gray-600">
                Kami menyediakan kos khusus pria, khusus wanita, dan campuran. Pilih sesuai kebutuhanmu saat memesan. 
            </div>
        </div>
        <div x-data="{ open: false }" class="border rounded-lg bg-white shadow">
            <button @click="open = !open"
                class="w-full flex justify-between items-center px-6 py-4 text-left font-medium text-[#263238] focus:outline-none">
                <span>Untuk pembayaran Bagaimana?</span>
                <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-700" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-transition.opacity.duration.700ms class="px-6 pb-4 text-gray-600">
                Proses pembayaran sewa dilakukan secara online melalui platform kami. Pilih metode pembayaran yang tersedia, seperti transfer bank, e-wallet, atau metode lainnya, lalu ikuti langkah-langkah hingga selesai. Setelah pembayaran berhasil, kamu akan menerima konfirmasi secara otomatis. 
            </div>
        </div>
    </div>
</div>
