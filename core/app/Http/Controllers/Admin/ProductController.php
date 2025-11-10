<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $brands     = Brand::all();
        $services   = Service::all();

        return view('admin.product.create', compact('brands', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id'     => 'nullable|exists:brands,id',
            'service_id'   => 'nullable|exists:services,id',
            'division_id'  => 'nullable|integer',
            'district_id'  => 'nullable|integer',
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'       => 'required|in:0,1',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        // Generate unique slug
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        $validated['slug'] = $slug;

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $brands     = Brand::all();
        $services   = Service::all();
        return view('admin.product.edit', compact('product', 'brands', 'services'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'brand_id'     => 'nullable|exists:brands,id',
            'service_id'   => 'nullable|exists:services,id',
            'division_id'  => 'required|integer',
            'district_id'  => 'required|integer',
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'       => 'required|in:0,1',
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        // Generate unique slug on update
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        $validated['slug'] = $slug;

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }

    protected function uploadImage($image)
    {
        $filename = 'products/' . uniqid() . '.webp';

        $manager = new ImageManager(new Driver());

        $resizedImage = $manager->read($image)
            ->cover(500, 500)
            ->toWebp(80);

        Storage::disk('public')->put($filename, $resizedImage);

        return $filename;
    }
}
