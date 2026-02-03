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

    <!-- Profile -->
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

      <div id="profileMenu" class="hidden mt-2 space-y-1">
        <a href="{{ route('profile.edit') }}"
           class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded transition">
          <i class="fas fa-user"></i>
          <span>Profile</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  class="w-full flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded transition">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
          </button>
        </form>
      </div>
    </div>

    <!-- Menu -->
    <nav class="flex-1 p-4 space-y-1">
      <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</p>

      <!-- Dashboard -->
      <a href="{{ route('admin.dashboard') }}"
         class="flex items-center space-x-3 px-4 py-3 rounded-lg transition
         {{ request()->routeIs('admin.dashboard') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-purple-50 hover:text-purple-600' }}">
        <i class="fas fa-home"></i>
        <span class="font-medium">Dashboard</span>
      </a>

      <!-- Produk -->
      <a href="{{ route('admin.products.index') }}"
         class="flex items-center space-x-3 px-4 py-3 rounded-lg transition
         {{ request()->routeIs('admin.products.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-purple-50 hover:text-purple-600' }}">
        <i class="fas fa-box"></i>
        <span class="font-medium">Produk</span>
      </a>

      <!-- Inventory -->
      <a href="{{ route('admin.inventory.index') }}"
         class="flex items-center space-x-3 px-4 py-3 rounded-lg transition
         {{ request()->routeIs('admin.inventory.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-purple-50 hover:text-purple-600' }}">
        <i class="fas fa-warehouse"></i>
        <span class="font-medium">Inventory</span>
      </a>
    </nav>
  </div>
</aside>

<script>
document.getElementById('profileBtn')?.addEventListener('click', () => {
  document.getElementById('profileMenu')?.classList.toggle('hidden');
  document.getElementById('profileIcon')?.classList.toggle('rotate-180');
});
</script>

<style>
.rotate-180 {
  transform: rotate(180deg);
}
</style>
