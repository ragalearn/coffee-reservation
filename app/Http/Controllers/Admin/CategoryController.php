<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'min_capacity' => 'required|integer|min:1',
            'max_capacity' => 'required|integer|gte:min_capacity',
        ]);

        // UPLOAD IMAGE (JIKA ADA)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
        } else {
            $path = null;
        }

        Category::create([
            'name'         => $request->name,
            'description'  => $request->description,
            'image'        => $path,
            'min_capacity' => $request->min_capacity,
            'max_capacity' => $request->max_capacity,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'min_capacity' => 'required|integer|min:1',
            'max_capacity' => 'required|integer|gte:min_capacity',
        ]);

        $data = $request->only([
            'name',
            'description',
            'min_capacity',
            'max_capacity',
        ]);

        // UPDATE IMAGE (JIKA ADA)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
