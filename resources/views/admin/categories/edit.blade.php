<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold mb-4">Edit Kategori</h2>
        <div class="bg-white p-6 shadow-sm rounded-lg">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700">Nama Kategori</label>
                    <input type="text" name="name" value="{{ $category->name }}" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Deskripsi</label>
                    <textarea name="description" class="w-full border p-2 rounded">{{ $category->description }}</textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>