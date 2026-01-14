<x-app-layout>
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-xl font-bold mb-4">Data Kategori</h1>

        <a href="{{ route('admin.categories.create') }}">
            Tambah Kategori
        </a>

        <table border="1" cellpadding="5" width="100%" style="margin-top:10px">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align:center">
                            Belum ada kategori
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>
