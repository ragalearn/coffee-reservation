<x-app-layout>
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-xl font-bold mb-4">Data Meja</h1>

        <a href="{{ route('admin.tables.create') }}">
            + Tambah Meja
        </a>

        <table border="1" cellpadding="5">
            <tr>
                <th>No</th>
                <th>Meja</th>
                <th>Kategori</th>
                <th>Kapasitas</th>
                <th>Status</th>
            </tr>

            @foreach ($tables as $table)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $table->table_number }}</td>
                    <td>{{ $table->category->name }}</td>
                    <td>{{ $table->capacity }}</td>
                    <td>{{ $table->status }}</td>
                </tr>
            @endforeach

        </table>

    </div>
</x-app-layout>
