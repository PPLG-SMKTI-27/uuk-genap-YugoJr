<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productIndex(Request $request)
    {
        $query = products::with('category');

        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->get();

        return view('admin_dashboard', compact('products'));
    }

    public function productCreate()
    {
        $categories = categories::all();

        return view('products.create', compact('categories'));
    }

    public function productStore(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'product_name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'unit' => 'required'
        ]);

        products::create($request->only([
            'category_id',
            'product_name',
            'price',
            'stock',
            'unit',
        ]));

        return redirect()->route('products.index')->with('success', 'Produk ditambahkan.');
    }

    public function productEdit(products $product)
    {
        $categories = categories::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function productUpdate(Request $request, products $product)
    {
        $request->validate([
            'category_id' => 'required',
            'product_name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'unit' => 'required'
        ]);

        $product->update($request->only([
            'category_id',
            'product_name',
            'price',
            'stock',
            'unit',
        ]));

        return redirect()->route('products.index')->with('success', 'Produk diperbarui!');
    }

    public function productDestroy(products $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk dihapus!');
    }
}
