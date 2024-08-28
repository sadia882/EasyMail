<!DOCTYPE html>
<html>
<head>
    <title>Contacts</title>
</head>
<body>
    <h1>Contacts</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="{{ route('contacts.sendEmail') }}" method="POST">
        @csrf
        <label for="contact_id">Select Contact:</label>
        <select name="contact_id" id="contact_id" required>
            @foreach($contacts as $contact)
                <option value="{{ $contact->id }}">{{ $contact->nom }} {{ $contact->prenom }}</option>
            @endforeach
        </select>

        <label for="message">Message:</label>
        <textarea name="message" id="message" required></textarea>

        <button type="submit">Send Email</button>
    </form>
</body>
</html>
