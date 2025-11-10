<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->get();
        $brands = Brand::latest()->get();
        $services = Service::inRandomOrder()->get();
        $products = Product::where('status', 1)->latest()->get(); // ডিফল্ট প্রোডাক্ট

        return view('frontend.pages.home.index', compact('banners', 'brands', 'services', 'products'));
    }


    public function show($slug)
    {
        $category = Service::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.services.show', compact('service'));
    }

    // ✅ Filter Products
    public function filterCards(Request $request)
    {
        $products = Product::where('status', 1)
            ->when($request->brand_id, fn($q) => $q->where('brand_id', $request->brand_id))
            ->when($request->service_id, fn($q) => $q->where('service_id', $request->service_id))
            ->when($request->division_id, fn($q) => $q->where('division_id', $request->division_id))
            ->when($request->district_id, fn($q) => $q->where('district_id', $request->district_id))
            ->latest()
            ->get();

        return view('frontend.pages.home.sections.partials.cards_list', compact('products'))->render();
    }
}
