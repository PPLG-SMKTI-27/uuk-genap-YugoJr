<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Transaksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('transactions.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="customer_name" class="mb-2 block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                            <input id="customer_name" type="text" name="customer_name" value="{{ old('customer_name') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('customer_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <div class="rounded-lg border border-gray-200 p-4">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="product_id_0" class="mb-2 block text-sm font-medium text-gray-700">Produk</label>
                                        <select id="product_id_0" name="product_id[]" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="">Pilih produk</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" @selected(old('product_id.0') == $product->id)>
                                                    {{ $product->product_name }} (stok: {{ $product->stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="quantity_0" class="mb-2 block text-sm font-medium text-gray-700">Jumlah</label>
                                        <input id="quantity_0" type="number" min="1" name="quantity[]" value="{{ old('quantity.0', 1) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                                Simpan Transaksi
                            </button>
                            <a href="{{ route('transactions.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
