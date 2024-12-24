<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Models\ChatID;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function chatIndex()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        $usersAll = User::all();
        // dd($users);
        return view('pages.chat', ['users' => $users, 'usersAll' => $usersAll]);
    }
    public function message(User $user)
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();

        $chatId = ChatID::where(function ($query) use ($user) {
            $query->where('from_id', $user->id)
                ->where('to_id', auth()->user()->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('from_id', auth()->user()->id)
                ->where('to_id', $user->id);
        })->first();

        if (is_null($chatId)) {
            $chatId = ChatID::create([
                'from_id' => auth()->user()->id,
                'to_id' => $user->id,
            ]);
        }
        $models = Message::where('chat_id', $chatId->id)->orderBy('id', 'desc')->get();
        $usersAll = User::all();
        return view('pages.message', ['messages' => $models, 'users' => $users, 'chatID' => $chatId, 'usersAll' => $usersAll]);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'chat_id' => 'required',
            'text' => 'required',
        ]);
        $data['sender_id'] = auth()->user()->id;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            // dd($extension);
            if($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg'){
                $data['file_type'] = 'image';
            }elseif($extension == 'mp4')
            {
                $data['file_type'] = 'video';
            }elseif($extension == 'pdf' || $extension == 'docx' || $extension == 'xlsx'){
                $data['file_type'] = 'file';
            }else{
                $data['file_type'] = 'file';
            }
            $filename = date('Y-m-d') . '_' . time() . '.' . $extension;
            $file->move(public_path('image_upload/'), $filename);
            $data['image'] = 'image_upload/' . $filename;
        }
        // dd($data);

        $message = Message::create($data);

        broadcast(new MessageEvent($message));
        return back();
    }
}
