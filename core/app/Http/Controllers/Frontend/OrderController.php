<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    // Checkout Page Show
    public function checkout($product_id)
    {
        $product = Product::findOrFail($product_id);

        // Calculate price with discount
        $price = $product->discount > 0
            ? $product->price - $product->discount
            : $product->price;

        return view('frontend.pages.order.checkout', compact('product', 'price'));
    }

    // Store Order
    public function store(Request $request)
    {
        $request->validate([
            'full_name'   => 'required',
            'phone'       => 'required',
            'address'     => 'required',
            'product_id'  => 'required',
            'division_id' => 'required',
            'district_id' => 'required',
        ]);

        $product = Product::findOrFail($request->product_id);

        $price = $product->discount > 0
            ? $product->price - $product->discount
            : $product->price;

        // API Base URL from .env
        $API_BASE = env('APP_URL') . '/api';

        // Get Division Name from API
        $division = null;
        if ($request->division_id) {
            $divisionRes = Http::get("$API_BASE/divisions");
            if ($divisionRes->successful()) {
                $division = collect($divisionRes->json('data'))
                    ->firstWhere('id', $request->division_id)['name'] ?? null;
            }
        }

        // Get District Name from API
        $district = null;
        if ($request->district_id) {
            $districtRes = Http::get("$API_BASE/districts/{$request->division_id}");
            if ($districtRes->successful()) {
                $district = collect($districtRes->json('data'))
                    ->firstWhere('id', $request->district_id)['name'] ?? null;
            }
        }

        Order::create([
            'full_name'   => $request->full_name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'division'    => $division,
            'district'    => $district,
            'product_id'  => $product->id,
            'quantity'    => 1,
            'price'       => $price,
            'total'       => $price,
            'status'      => 'pending',
        ]);

        return redirect()->route('home')->with('success', '✅ Order placed successfully!');
    }
}
