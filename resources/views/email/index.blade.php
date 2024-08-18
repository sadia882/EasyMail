<!-- resources/views/email/index.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Emails</title>
</head>
<body>

                    <p>{{ $email->id }}</p>
                    <p>{{ $email->to }}</p>
                    <p>{{ $email->subject }}</p>
                    <p>{{ $email->message }}</p>
</body>
</html>
