<!DOCTYPE html>
<html>
<head>
    <title>Edit Pesan</title>
</head>
<body>
    <h1>Edit Pesan</h1>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <form action="/messages/{{ $message->id }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="judul">Judul:</label>
            <input type="text" id="judul" name="judul" value="{{ $message->judul }}" required>
        </div>
        <div>
            <label for="isi">Isi:</label>
            <textarea id="isi" name="isi" required>{{ $message->isi }}</textarea>
        </div>
        <div>
            <button type="submit">Update Pesan</button>
        </div>
    </form>

    <a href="/messages">Kembali ke Daftar Pesan</a>
</body>
</html>
