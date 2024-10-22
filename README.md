---

# Laravel CRUD Setup

This guide will help you install Laravel, set up a database, and create a basic CRUD (Create, Read, Update, Delete) functionality using Laravel.

## Prerequisites

- PHP >= 8.0
- Composer (PHP dependency manager)
- MySQL (or other supported database)

## Step 1: Install Laravel

First, you need to install Laravel in the current directory:

```bash
composer create-project --prefer-dist laravel/laravel your_project_name
```

Move into the project directory:

```bash
cd your_project_name
```

## Step 2: Set Up the `.env` File

1. Open the `.env` file in your project directory.
2. Update the database configuration to match your MySQL credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

3. Create a new MySQL database with the same name as defined in the `.env` file.

## Step 3: Generate Application Key

Run this command to generate the Laravel application key:

```bash
php artisan key:generate
```

## Step 4: Create the Migration

To create a migration for the `messages` table, run the following command:

```bash
php artisan make:migration create_messages_table
```

This will create a new migration file in the `database/migrations` folder. Open the migration file and modify it as follows:

```php
public function up()
{
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->text('isi');
        $table->timestamps();
    });
}
```

Run the migration to create the table in the database:

```bash
php artisan migrate
```

## Step 5: Create the Model

To create a model for the `messages` table, run the following command:

```bash
php artisan make:model MessageModel
```

This will create a new model in the `app/Models` directory. Open the `MessageModel.php` file and modify it as follows:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageModel extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $fillable = [
        'judul',
        'isi'
    ];
}
```

## Step 6: Create the Controller

To create a controller for managing messages, run the following command:

```bash
php artisan make:controller MessageController
```

Open the `MessageController.php` file located in the `app/Http/Controllers` directory and add the following code:

```php
<?php

namespace App\Http\Controllers;

use App\Models\MessageModel;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = MessageModel::all();
        return view('index', ['messages' => $messages]);
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
        ]);

        MessageModel::create($request->only(['judul', 'isi']));

        return redirect('/messages');
    }

    public function edit($id)
    {
        $message = MessageModel::findOrFail($id);
        return view('edit', ['message' => $message]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
        ]);

        $message = MessageModel::findOrFail($id);
        $message->update($request->only(['judul', 'isi']));

        return redirect('/messages');
    }

    public function destroy($id)
    {
        $message = MessageModel::findOrFail($id);
        $message->delete();

        return redirect('/messages');
    }
}
```

## Step 7: Set Up Routes

Open the `routes/web.php` file and add the following routes:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/messages', [MessageController::class, 'index']);
Route::get('/messages/create', [MessageController::class, 'create']);
Route::post('/messages', [MessageController::class, 'store']);
Route::get('/messages/{id}/edit', [MessageController::class, 'edit']);
Route::put('/messages/{id}', [MessageController::class, 'update']);
Route::delete('/messages/{id}', [MessageController::class, 'destroy']);
```

## Step 8: Create Views

### 1. `index.blade.php`

Create a new file named `index.blade.php` in the `resources/views` directory:

```html
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
```

### 2. `create.blade.php`

Create a new file named `create.blade.php`:

```html
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
```

### 3. `edit.blade.php`

Create a new file named `edit.blade.php`:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Edit Pesan</title>
</head>
<body>
    <h1>Edit Pesan</h1>

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
```

## Step 9: Run the Laravel Development Server

To run the project, use the following command:

```bash
php artisan serve
```

Visit `http://localhost:8000/messages` in your browser to start using the CRUD application.

---
