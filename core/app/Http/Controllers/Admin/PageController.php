<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
        ]);

        Page::create([
            'title'        => $request->title,
            'slug'         => Str::slug($request->title),
            'content'      => $request->content,
            'menu_visible' => $request->has('menu_visible'),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page Created Successfully!');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
        ]);

        $page->update([
            'title'        => $request->title,
            'slug'         => Str::slug($request->title),
            'content'      => $request->content,
            'menu_visible' => $request->has('menu_visible'),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page Updated Successfully!');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page Deleted Successfully!');
    }
}
