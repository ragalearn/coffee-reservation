@extends('layouts.app')

@section('content')
<div class="admin-dashboard">
    @include('admin.partials.sidebar')

    <main class="main">

        <div class="header">
            <h1>Edit Seating Area</h1>
        </div>

        <div class="card form-card">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $category->name }}" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description">{{ $category->description }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Min Capacity</label>
                        <input type="number" name="min_capacity" value="{{ $category->min_capacity }}" required>
                    </div>

                    <div class="form-group">
                        <label>Max Capacity</label>
                        <input type="number" name="max_capacity" value="{{ $category->max_capacity }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Current Image</label>
                    @if($category->image)
                        <img src="{{ asset('storage/'.$category->image) }}" class="preview">
                    @else
                        <p style="font-size:13px;color:#777">No image uploaded</p>
                    @endif
                </div>

                <div class="form-group">
                    <label>Change Image</label>
                    <input type="file" name="image" accept="image/*">
                </div>

                <button class="btn-confirm">Update Seating Area</button>
            </form>
        </div>

    </main>
</div>

<style>
.form-card {
    max-width: 640px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

input, textarea {
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ddd;
    font-size: 14px;
}

textarea {
    resize: vertical;
    min-height: 80px;
}

.preview {
    width: 220px;
    height: 130px;
    object-fit: cover;
    border-radius: 12px;
    margin-top: 8px;
}

.btn-confirm {
    margin-top: 18px;
    background: #8b9b4a;
    color: #fff;
    border: none;
    padding: 14px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
}
</style>
@endsection
