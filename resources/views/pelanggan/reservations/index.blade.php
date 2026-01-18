@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $category->name }}</h3>

    <p>{{ $category->description }}</p>

    <a href="{{ route('reservations.create', ['category' => $category->id]) }}"
       class="btn btn-success">
        Reserve Now
    </a>
</div>
@endsection
