<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Inventory</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <style>
        .modal { display:none; }
        .modal.show { display:flex; }
    </style>
</head>

<body class="bg-gray-50">
<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    @include('admin.sidebar')

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col overflow-hidden lg:ml-64 transition-all duration-300">

        {{-- HEADER --}}
        <header class="bg-white shadow-sm z-10">
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Manajemen Inventory</h1>
                    <p class="text-sm text-gray-500">Tambah / kurangi stok produk</p>
                </div>

                <div class="flex items-center gap-4">
                    <button class="relative text-gray-600 hover:text-gray-800">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                    </button>

                    <img class="h-10 w-10 rounded-full border-2 border-purple-500"
                         src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=667eea&color=fff"
                         alt="Avatar">
                </div>
            </div>
        </header>

        {{-- MAIN --}}
        <main class="flex-1 overflow-y-auto p-6">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-300 flex items-center">
                    <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                    <span class="text-green-900 font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- ERROR MESSAGE --}}
            @if(session('error'))
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-300 flex items-center">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl mr-3"></i>
                    <span class="text-red-900 font-medium">{{ session('error') }}</span>
                </div>
            @endif

            {{-- FILTER --}}
            <div class="bg-white p-6 rounded-xl shadow mb-6">
                <div class="flex flex-wrap gap-4 justify-between">

                    <form method="GET" action="{{ route('admin.inventory.index') }}"
                          class="flex flex-col md:flex-row gap-3 flex-1">

                        <div class="relative flex-1">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Cari produk atau SKU..."
                                   class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <button type="submit"
                                class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                    </form>

                    <div class="text-sm text-gray-500 flex items-center">
                        <i class="fas fa-boxes-stacked mr-2"></i>
                        Total: <span class="ml-1 font-semibold text-gray-800">{{ $products->total() }}</span> Produk
                    </div>
                </div>
            </div>

            {{-- TABLE LIST INVENTORY --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase">Gambar</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase">SKU</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase">Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase">Stok</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase">Atur Stok</th>
                        </tr>
                        </thead>

                        <tbody class="divide-y">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if(!empty($product->image))
                                        <img src="{{ asset('storage/'.$product->image) }}"
                                             class="h-12 w-12 rounded object-cover" alt="{{ $product->name }}">
                                    @else
                                        <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-box text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                    {{ $product->sku ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $product->category ?? '' }}
                                    </p>
                                </td>

                                <td class="px-6 py-4">
                                    @php $stock = (int) ($product->stock ?? 0); @endphp
                                    <span class="text-sm font-semibold {{ $stock < 10 ? 'text-red-600' : 'text-gray-800' }}">
                                        {{ $stock }} {{ $product->unit ?? '' }}
                                    </span>
                                    @if($stock < 10)
                                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                            Stok Menipis
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center gap-3">

                                        {{-- Form Tambah --}}
                                        <form method="POST" action="{{ route('admin.inventory.adjust', $product) }}"
                                              class="flex items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="action" value="increase">

                                            <input type="number" name="qty" min="1" value="1"
                                                   class="w-20 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">

                                            <button type="submit"
                                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow">
                                                <i class="fas fa-plus mr-1"></i>Tambah
                                            </button>
                                        </form>

                                        {{-- Form Kurangi --}}
                                        <form method="POST" action="{{ route('admin.inventory.adjust', $product) }}"
                                              class="flex items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="action" value="decrease">

                                            <input type="number" name="qty" min="1" value="1"
                                                   class="w-20 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">

                                            <button type="submit"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 shadow">
                                                <i class="fas fa-minus mr-1"></i>Kurangi
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-box-open text-4xl mb-3"></i>
                                    <p class="text-lg font-medium">Belum ada produk</p>
                                    <p class="text-sm">Tambahkan produk dulu di menu Produk.</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if($products->hasPages())
                    <div class="p-4 border-t">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>
</div>

</body>
</html>
