<!-- resources/views/email/create.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoyer un Email</title>
</head>
<body>
    <h1>Rédiger un Email</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/email" method="POST">
        @csrf
        <div>
            <label for="to">À :</label>
            <input type="email" name="to" id="to" required>
        </div>
        <div>
            <label for="subject">Sujet :</label>
            <input type="text" name="subject" id="subject" required>
        </div>
        <div>
            <label for="message">Message :</label>
            <textarea name="message" id="message" rows="10" required></textarea>
        </div>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
