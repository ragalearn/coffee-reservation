<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar seating area (Indoor, Outdoor, Semi-Outdoor)
     * Akses: Pelanggan (READ ONLY)
     */
    public function index()
    {
        $categories = Category::all();

        return view('pelanggan.categories.index', compact('categories'));
    }

    /**
     * Menampilkan detail seating area
     */
    public function show(Category $category)
    {
        return view('pelanggan.categories.show', compact('category'));
    }
}
