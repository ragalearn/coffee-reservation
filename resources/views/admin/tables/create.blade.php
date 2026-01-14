<x-app-layout>
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-xl font-bold mb-4">Tambah Meja</h1>

        <form method="POST" action="{{ route('admin.tables.store') }}">
            @csrf

            <div>
                <label>Nomor Meja</label>
                <input type="text" name="table_number" required>
            </div>

            <div>
                <label>Kategori Meja</label>
                <select name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Kapasitas</label>
                <input type="number" name="capacity" min="1" required>
            </div>

            <button type="submit">Simpan</button>
        </form>

    </div>
</x-app-layout>
