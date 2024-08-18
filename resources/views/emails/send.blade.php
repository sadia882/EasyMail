<!-- resources/views/emails/send.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $details['subject'] }}</title>
</head>
<body>
    <p>{{ $details['message'] }}</p>
</body>
</html>
