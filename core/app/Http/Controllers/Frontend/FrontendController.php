<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->get();
        $categories = Category::inRandomOrder()->get();
        $products = Product::where('status', 1)->latest()->get(); // ডিফল্ট প্রোডাক্ট

        return view('frontend.pages.home.index', compact('banners', 'categories', 'products'));
    }


    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.categories.show', compact('category'));
    }

    // ✅ Filter Products
    public function filterCards(Request $request)
    {
        $products = Product::where('status', 1)
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->division_id, fn($q) => $q->where('division_id', $request->division_id))
            ->when($request->district_id, fn($q) => $q->where('district_id', $request->district_id))
            ->latest()
            ->get();

        return view('frontend.pages.home.sections.partials.cards_list', compact('products'))->render();
    }
}
