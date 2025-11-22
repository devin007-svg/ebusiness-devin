<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Include Sidebar -->
        @include('admin.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-64 transition-all duration-300">
            
            <!-- Top Header -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button id="sidebarToggle" class="text-gray-500 hover:text-gray-700 focus:outline-none lg:hidden mr-4">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                            <p class="text-sm text-gray-500">Selamat datang kembali!</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <button class="relative text-gray-600 hover:text-gray-800 transition">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">3</span>
                        </button>
                        
                        <img class="h-10 w-10 rounded-full border-2 border-purple-500" 
                             src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=667eea&color=fff" 
                             alt="Admin">
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                
                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-gray-800">Halo, {{ Auth::user()->name ?? 'Admin' }}! 👋</h2>
                    <p class="text-gray-600 mt-1">Berikut adalah ringkasan bisnis Anda hari ini</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
                    
                    <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-90 mb-1">Total Produk</p>
                                <h3 class="text-4xl font-bold">1,234</h3>
                                <p class="text-xs mt-2 opacity-80"><i class="fas fa-arrow-up mr-1"></i>12% dari bulan lalu</p>
                            </div>
                            <div class="opacity-30">
                                <i class="fas fa-box text-5xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-90 mb-1">Total Penjualan</p>
                                <h3 class="text-4xl font-bold">Rp 45M</h3>
                                <p class="text-xs mt-2 opacity-80"><i class="fas fa-arrow-up mr-1"></i>8% dari bulan lalu</p>
                            </div>
                            <div class="opacity-30">
                                <i class="fas fa-dollar-sign text-5xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-90 mb-1">Pesanan Baru</p>
                                <h3 class="text-4xl font-bold">89</h3>
                                <p class="text-xs mt-2 opacity-80"><i class="fas fa-arrow-down mr-1"></i>3% dari bulan lalu</p>
                            </div>
                            <div class="opacity-30">
                                <i class="fas fa-shopping-cart text-5xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-90 mb-1">Pelanggan</p>
                                <h3 class="text-4xl font-bold">567</h3>
                                <p class="text-xs mt-2 opacity-80"><i class="fas fa-arrow-up mr-1"></i>15% dari bulan lalu</p>
                            </div>
                            <div class="opacity-30">
                                <i class="fas fa-users text-5xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Grafik Penjualan</h3>
                                <p class="text-sm text-gray-500">Performa 6 bulan terakhir</p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-sm bg-purple-600 text-white rounded-lg">Bulan</button>
                                <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Tahun</button>
                            </div>
                        </div>
                        <div style="position: relative; height: 300px;">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-5">Pesanan Terbaru</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-shopping-bag text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">#ORD-001</p>
                                        <p class="text-xs text-gray-500">Budi Santoso</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Selesai</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-shopping-bag text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">#ORD-002</p>
                                        <p class="text-xs text-gray-500">Siti Aminah</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Proses</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-shopping-bag text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">#ORD-003</p>
                                        <p class="text-xs text-gray-500">Ahmad Yani</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">Dikirim</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-shopping-bag text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">#ORD-004</p>
                                        <p class="text-xs text-gray-500">Dewi Lestari</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Pending</span>
                            </div>
                        </div>

                        <button class="w-full mt-4 py-2 text-sm text-purple-600 font-semibold hover:bg-purple-50 rounded-lg transition">
                            Lihat Semua Pesanan →
                        </button>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        const ctx = document.getElementById('salesChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Penjualan (Juta)',
                        data: [12, 19, 15, 25, 22, 30],
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        }
    </script>
</body>
</html>
