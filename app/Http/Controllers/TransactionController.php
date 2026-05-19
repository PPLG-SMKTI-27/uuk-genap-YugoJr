<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\transaction as Transaction;
use App\Models\transactiondetail as TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function transactionIndex()
    {
        $transactions = Transaction::with('details.product')->latest()->get();

        return view('transactions.index', compact('transactions'));
    }

    public function transactionCreate()
    {
        $products = products::where('stock', '>', 0)->orderBy('product_name')->get();

        return view('transactions.create', compact('products'));
    }

    public function transactionStore(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_id' => 'required|array',
            'quantity' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'transaction_no' => 'TRX-' . time(),
                'date' => now()->toDateString(),
                'customer_name' => $request->customer_name,
                'status' => 'success',
                'total_price' => 0,
            ]);

            $total_price = 0;

            foreach ($request->product_id as $key => $prod_id) {
                $product = products::findOrFail($prod_id);
                $qty = (int) ($request->quantity[$key] ?? 0);

                if ($qty < 1) {
                    throw new \Exception("Jumlah untuk {$product->product_name} harus lebih dari 0.");
                }

                if ($product->stock < $qty) {
                    throw new \Exception("Stok {$product->product_name} tidak mencukupi!");
                }

                $subtotal = $product->price * $qty;
                $total_price += $subtotal;

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $qty);
            }

            $transaction->update(['total_price' => $total_price]);
            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function transactionEdit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }

    public function transactionUpdate(Request $request, Transaction $transaction)
    {
        $request->validate(['customer_name' => 'required|string|max:255']);
        $transaction->update(['customer_name' => $request->customer_name]);

        return redirect()->route('transactions.index')->with('success', 'Data transaksi diperbarui!');
    }

    public function transactionDestroy(Transaction $transaction)
    {
        try {
            DB::beginTransaction();

            foreach ($transaction->details as $detail) {
                $detail->product?->increment('stock', $detail->quantity);
            }

            $transaction->delete();
            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaksi dibatalkan, stok dikembalikan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
