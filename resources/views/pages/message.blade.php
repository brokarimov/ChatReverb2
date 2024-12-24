@extends('pages.chat')

@section('content')

<form action="/store" method="POST" enctype="multipart/form-data">
    <div class="d-flex">
        @csrf
        <input type="text" name="text" class="form-control" placeholder="Write a message...">
        <input type="file" name="image" id="fileInput" style="display: none;">


        <label for="fileInput" class="btn btn-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
            </svg>
        </label>
        <input type="hidden" name="chat_id" value="{{$chatID->id}}">
        <input type="submit" class="btn btn-primary">
    </div>
</form>


<div id="messageList">
    @foreach ($messages as $message)
    <li>
        <span class="text-danger">{{$message->sender->name}}</span>: {{$message->text}}<br>
        @if ($message->image)
        @if ($message->file_type == 'image')
        <img src="{{asset($message->image)}}" width="100px">
        @elseif($message->file_type == 'video')
        <video src="{{ asset($message->image) }}" width="100" controls>
            Your browser does not support the video tag.
        </video>

        @elseif($message->file_type == 'file')
        <a href="{{ asset($message->image) }}" target="_blank">View file</a>

        @endif
        @endif

    </li>
    @endforeach
</div>



@endsection