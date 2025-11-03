<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BannerController extends Controller
{
    /**
     * Display a listing of banners.
     */
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created banner.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:255',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $this->uploadImage($request->file('banner'));
        }

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', compact('banner'));
    }

    /**
     * Update an existing banner.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:255',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('banner')) {
            // Delete old image if exists
            if ($banner->banner && Storage::disk('public')->exists($banner->banner)) {
                Storage::disk('public')->delete($banner->banner);
            }

            $validated['banner'] = $this->uploadImage($request->file('banner'));
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated successfully');
    }

    /**
     * Remove the specified banner.
     */
    public function destroy(Banner $banner)
    {
        if ($banner->banner && Storage::disk('public')->exists($banner->banner)) {
            Storage::disk('public')->delete($banner->banner);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully');
    }

    /**
     * Upload and optimize image.
     */
    protected function uploadImage($image)
    {
        $filename = 'banners/' . uniqid() . '.webp';

        $manager = new ImageManager(new Driver());

        $resizedImage = $manager->read($image)
            ->cover(1920, 500) // Resize to 1920x500
            ->toWebp(80); // WebP format & 80% quality

        Storage::disk('public')->put($filename, $resizedImage);

        return $filename;
    }
}
