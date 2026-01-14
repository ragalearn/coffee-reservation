<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\Category;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::with('category')->get();
        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.tables.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'table_number' => 'required|string|max:50',
            'capacity'     => 'required|integer|min:1',
            'status'       => 'nullable|in:available,unavailable',
        ]);

        Table::create([
            'category_id'  => $request->category_id,
            'table_number' => $request->table_number,
            'capacity'     => $request->capacity,
            'status'       => $request->status ?? 'available',
        ]);

        return redirect()
            ->route('admin.tables.index')
            ->with('success', 'Meja berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        $categories = Category::all();
        return view('admin.tables.edit', compact('table', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Table $table)
    {
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'table_number' => 'required|string|max:50',
            'capacity'     => 'required|integer|min:1',
            'status'       => 'required|in:available,unavailable',
        ]);

        $table->update([
            'category_id'  => $request->category_id,
            'table_number' => $request->table_number,
            'capacity'     => $request->capacity,
            'status'       => $request->status,
        ]);

        return redirect()
            ->route('admin.tables.index')
            ->with('success', 'Meja berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()
            ->route('admin.tables.index')
            ->with('success', 'Meja berhasil dihapus');
    }
}
