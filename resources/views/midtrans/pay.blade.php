<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Kost Aditio</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 max-w-md w-full">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-primary-600 dark:text-primary-400">Kost Aditio</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Pembayaran Sewa Kamar</p>
        </div>
        
        <!-- Payment Information -->
        <div class="border-t border-b border-gray-200 dark:border-gray-700 py-4 mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600 dark:text-gray-400">ID Transaksi:</span>
                <span class="font-medium text-gray-800 dark:text-gray-200">{{ substr($snap_token, 0, 8) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600 dark:text-gray-400">Status:</span>
                <span class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 text-xs font-medium px-2.5 py-0.5 rounded">Menunggu Pembayaran</span>
            </div>
        </div>
        
        <!-- Important Notes -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-4 mb-6">
            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Penting:</h3>
            <ul class="text-xs text-gray-600 dark:text-gray-400 list-disc list-inside space-y-1">
                <li>Pembayaran akan diproses melalui Midtrans</li>
                <li>Setelah pembayaran berhasil, Anda akan dialihkan ke halaman dashboard</li>
                <li>Jika ada masalah, silakan hubungi admin Kost Aditio</li>
            </ul>
        </div>
        
        <!-- Payment Button -->
        <button id="pay-button" class="w-full py-3 px-6 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition duration-300 flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
            Bayar Sekarang
        </button>
        
        <!-- Back Link -->
        <div class="text-center mt-4">
            <a href="/dashboard" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">Kembali ke Dashboard</a>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="mt-8 text-center text-xs text-gray-500 dark:text-gray-400">
        &copy; {{ date('Y') }} Kost Aditio. All rights reserved.
    </div>
    
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            window.snap.pay('{{ $snap_token }}', {
                onSuccess: function(result){ window.location.href = '/dashboard'; },
                onPending: function(result){ window.location.href = '/dashboard'; },
                onError: function(result){ 
                    alert('Pembayaran gagal!'); 
                    window.location.href = '/dashboard';
                }
            });
        }
    </script>
</body>
</html>