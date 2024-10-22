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

    public function show($id)
    {
        //
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
