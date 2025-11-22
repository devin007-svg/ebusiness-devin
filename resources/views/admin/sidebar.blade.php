<aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
    <div class="flex flex-col h-full">
        
        <!-- Logo -->
        <div class="flex items-center justify-center h-20 border-b">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-store text-white text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-purple-600">AdminPanel</h1>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="p-4 border-b">
            <button id="profileBtn" class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 transition">
                <img class="h-12 w-12 rounded-full border-2 border-purple-500" 
                     src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=667eea&color=fff" 
                     alt="Profile">
                <div class="flex-1 text-left">
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Admin User' }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                </div>
                <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform" id="profileIcon"></i>
            </button>

            <!-- Profile Dropdown -->
            <div id="profileMenu" class="hidden mt-2 space-y-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded transition">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="#" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded transition">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded transition">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto p-4">
            
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition {{ request()->routeIs('admin.dashboard') ? 'bg-purple-50 text-purple-600' : '' }}">
                <i class="fas fa-home"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Produk Section (simple, no dropdown) -->
            <div class="mt-6">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Produk</p>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg 
                          hover:bg-purple-50 hover:text-purple-600 transition mt-2">
                    <i class="fas fa-box"></i>
                    <span class="font-medium">Produk</span>
                </a>
            </div>

            <!-- Pesanan Section (tetap slide / submenu) -->
            <div class="mt-6">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pesanan</p>

                <button class="menu-btn w-full flex items-center justify-between px-4 py-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition mt-2">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="font-medium">Pesanan</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform submenu-icon"></i>
                </button>

                <div class="submenu hidden ml-4 mt-1 space-y-1">
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded transition">
                        <i class="fas fa-circle text-xs"></i>
                        <span>Semua Pesanan</span>
                    </a>
                    <a href="{{ route('admin.orders.pending') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded transition">
                        <i class="fas fa-circle text-xs"></i>
                        <span>Pesanan Pending</span>
                    </a>
                </div>
            </div>

            <!-- Pelanggan Section -->
            <div class="mt-6">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pelanggan</p>
                <a href="{{ route('admin.customers.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition mt-2">
                    <i class="fas fa-users"></i>
                    <span class="font-medium">Pelanggan</span>
                </a>
            </div>

            <!-- Laporan Section -->
            <div class="mt-6">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Laporan</p>
                <a href="{{ route('admin.reports.sales') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition mt-2">
                    <i class="fas fa-chart-line"></i>
                    <span class="font-medium">Laporan Penjualan</span>
                </a>
                <a href="{{ route('admin.reports.inventory') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition">
                    <i class="fas fa-warehouse"></i>
                    <span class="font-medium">Laporan Stok</span>
                </a>
            </div>

            <!-- Sistem Section -->
            <div class="mt-6">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Sistem</p>
                <a href="{{ route('admin.settings') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition mt-2">
                    <i class="fas fa-cog"></i>
                    <span class="font-medium">Pengaturan</span>
                </a>
            </div>
        </nav>

        <!-- Footer Tips -->
        <div class="p-4 border-t">
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg p-4 text-white">
                <div class="flex items-center space-x-2 mb-2">
                    <i class="fas fa-lightbulb"></i>
                    <p class="text-sm font-semibold">Tips Hari Ini</p>
                </div>
                <p class="text-xs opacity-90">Gunakan filter untuk mencari produk lebih cepat!</p>
            </div>
        </div>
    </div>
</aside>

<script>
// Profile Dropdown Toggle
document.getElementById('profileBtn').addEventListener('click', function() {
    const menu = document.getElementById('profileMenu');
    const icon = document.getElementById('profileIcon');
    menu.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
});

// Submenu Toggle (Masih untuk Pesanan)
document.querySelectorAll('.menu-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const submenu = this.nextElementSibling;
        const icon = this.querySelector('.submenu-icon');
        
        document.querySelectorAll('.submenu').forEach(menu => {
            if (menu !== submenu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                const otherIcon = menu.previousElementSibling.querySelector('.submenu-icon');
                if (otherIcon) otherIcon.classList.remove('rotate-180');
            }
        });
        
        submenu.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    });
});

// Close sidebar on mobile when clicking outside
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (window.innerWidth < 1024 && sidebar && sidebarToggle) {
        if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
            sidebar.classList.add('-translate-x-full');
        }
    }
});
</script>

<style>
.rotate-180 {
    transform: rotate(180deg);
}

.submenu {
    transition: all 0.3s ease;
}
</style>
