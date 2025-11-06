<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8m5-5h2m-2 0a9 9 0 01-18 0h2" />
            </svg>
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition hover:scale-[1.02] hover:shadow-xl">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Halo 👋</h3>
                        <span class="text-indigo-500 text-sm font-medium">Akun</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">
                        Selamat datang, <span class="font-bold text-indigo-600">{{ Auth::user()->name }}</span>!  
                        Kamu berhasil login ke sistem.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition hover:scale-[1.02] hover:shadow-xl">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Status</h3>
                        <span class="text-green-500 text-sm font-medium">Aktif</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">
                        Kamu saat ini sedang menggunakan akun aktif. Nikmati fitur sistem dengan aman.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition hover:scale-[1.02] hover:shadow-xl">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Tips</h3>
                        <span class="text-yellow-500 text-sm font-medium">Baru</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">
                        Coba navigasikan menu di atas untuk mulai menjelajah fitur lainnya. 🚀
                    </p>
                </div>
            </div>

            <!-- Section bawah -->
            <div class="mt-10 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 text-center">
                <h1 class="text-3xl font-bold text-indigo-600 mb-3">🎉 Selamat Datang di Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-300">
                    Ini adalah halaman utama setelah kamu login.  
                    Kamu bisa menambahkan statistik, grafik, atau menu admin di sini.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
