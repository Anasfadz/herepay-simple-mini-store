<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $data = $request->all();

        foreach($data['items'] as $index => $item)
        {
            $product = Product::find($item);

            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found'
                ], 404);
            }
    
            if ($product->quantity <= 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product out of stock'
                ], 400);
            }

            $product->quantity -= $data['quantities'][$index];
            $product->save();

        }

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
}
