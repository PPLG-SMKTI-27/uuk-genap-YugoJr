<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Transaksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('transactions.update', $transaction) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="customer_name" class="mb-2 block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                            <input id="customer_name" type="text" name="customer_name" value="{{ old('customer_name', $transaction->customer_name) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('customer_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <p class="text-sm text-gray-600">Nomor transaksi: <span class="font-medium text-gray-900">{{ $transaction->transaction_no }}</span></p>
                            <p class="mt-2 text-sm text-gray-600">Tanggal: <span class="font-medium text-gray-900">{{ $transaction->date }}</span></p>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                                Update
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
