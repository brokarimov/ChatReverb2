<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite('resources/js/app.js')
    
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <h1><a href="/chat">{{auth()->user()->name}}</a></h1>
                <div class="row mt-3">
                    <div class="col-4">
                        <div id="userList">
                            @foreach ($users as $user)
                            <li><a href="/message/{{$user->id}}">{{$user->name}}</a></li>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-7">
                        @yield('content')
                    </div>
                    <div class="col-1">
                        <a href="/logout">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@if (isset($chatID))
<script>
    const chatID = @json($chatID->id);
    const userID = @json(auth()->user()->id);

</script>
@if (isset($usersAll))
<script>
    const usersAll = @json($usersAll);
</script>
@endif
@endif


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</html>