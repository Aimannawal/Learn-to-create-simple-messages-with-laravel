<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pesan</title>
</head>
<body>
    <h1>Tambah Pesan Baru</h1>
    <form action="/messages" method="POST">
        @csrf
        <div>
            <label for="judul">Judul:</label>
            <input type="text" id="judul" name="judul" required>
        </div>
        <div>
            <label for="isi">Isi:</label>
            <textarea id="isi" name="isi" required></textarea>
        </div>
        <div>
            <button type="submit">Simpan Pesan</button>
        </div>
    </form>

    <a href="/messages">Kembali ke Daftar Pesan</a>
</body>
</html>
