<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Client\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function checkout(Request $request)
    {
        // Validasi data
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0'
        ]);

        foreach ($request->items as $item) {
            $product = Product::find($item['id']);

            if ($product->quantity < $item['qty']) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Not enough stock for {$product->name}"
                ], 400);
            }

            $product->quantity -= $item['qty'];
            $product->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Payment successful and stock deducted'
        ]);
    }
}

