<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $email->subject }}</title>
    <style>
        img{
            width:200px;
        }
    </style>
</head>
<body>
    <div>
    <p>{!! nl2br(e($body)) !!}</p>
    <img src="{{ $message->embed(public_path().'/images/image.png')}}">
    <img src="{{ $message->embed(public_path().'/images/capture.png')}}">

    </div>

      
</body>
</html>

