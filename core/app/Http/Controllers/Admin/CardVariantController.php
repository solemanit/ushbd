<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CardVariant;
use Illuminate\Http\Request;

class CardVariantController extends Controller
{
    public function index()
    {
        $cardVariants = CardVariant::all();
        return view('admin.card-variants.index', compact('cardVariants'));
    }

    public function create()
    {
        return view('admin.card-variants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        CardVariant::create($request->all());

        return redirect()->route('admin.card-variants.index')
            ->with('success', 'Card Variant created successfully.');
    }

    public function show(CardVariant $cardVariant)
    {
        return view('admin.card-variants.show', compact('cardVariant'));
    }

    public function edit(CardVariant $cardVariant)
    {
        return view('admin.card-variants.edit', compact('cardVariant'));
    }

    public function update(Request $request, CardVariant $cardVariant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $cardVariant->update($request->all());

        return redirect()->route('admin.card-variants.index')
            ->with('success', 'Card Variant updated successfully.');
    }

    public function destroy(CardVariant $cardVariant)
    {
        $cardVariant->delete();

        return redirect()->route('admin.card-variants.index')
            ->with('success', 'Card Variant deleted successfully.');
    }
}
