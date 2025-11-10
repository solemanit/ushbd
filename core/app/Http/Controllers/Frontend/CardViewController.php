<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class CardViewController extends Controller
{
    public function show($slug)
    {
        // product নিয়ে আসুন সাথে সাথে brand ও service রিলেশনগুলো eager load করে
        $product = Product::with(['brand', 'service'])->where('slug', $slug)->firstOrFail();

        return view('frontend.pages.card-view.index', compact('product'));
    }

}
