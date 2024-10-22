<!DOCTYPE html>
<html>
<head>
    <title>Laravel Pesan CRUD</title>
</head>
<body>
    <div class="container">
<h1>Daftar Pesan</h1>

<a href="/messages/create">Tambah Pesan Baru</a>

@if (session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif

<ul>
    @foreach ($messages as $message)
        <li>
            <a href="/messages/{{ $message->id }}">{{ $message->judul }}</a>
            <a href="/messages/{{ $message->id }}/edit">Edit</a>
            <form action="/messages/{{ $message->id }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </li>
    @endforeach
</ul>
</div>
</body>
</html>
