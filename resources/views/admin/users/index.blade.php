@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <h1 class="text-xl font-bold mb-4">Daftar Pengguna</h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Bergabung</th>
        </tr>

        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
