<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class CardViewController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // API Base URL
        $API_BASE = env('APP_URL') . '/api';

        // Get Division Name
        $division = null;
        if ($product->division_id) {
            $divisionResponse = Http::get("$API_BASE/divisions");
            if ($divisionResponse->successful()) {
                $division = collect($divisionResponse->json('data'))
                    ->firstWhere('id', $product->division_id)['name'] ?? null;
            }
        }

        // Get District Name
        $district = null;
        if ($product->district_id) {
            $districtResponse = Http::get("$API_BASE/districts/{$product->division_id}");
            if ($districtResponse->successful()) {
                $district = collect($districtResponse->json('data'))
                    ->firstWhere('id', $product->district_id)['name'] ?? null;
            }
        }

        return view('frontend.pages.card-view.index', compact('product', 'division', 'district'));
    }
}
