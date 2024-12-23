<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('status', 1)->orderBy('id', 'desc')->get();
        return view('message', ['messages' => $messages]);
    }
    public function create()
    {
        return view('send-message');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'text' => 'required',
            'image' => 'required|file',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = date('Y-m-d') . '_' . time() . '.' . $extension;
            $file->move(public_path('image_upload'), $filename);
            $data['image'] = 'image_upload/' . $filename;
        }
        $message = Message::create($data);
        broadcast(new MessageEvent($message));
        return back();
    }

    public function read(Message $message)
    {
        $message->status = 2;
        $message->save();
        return back();
    }
}
