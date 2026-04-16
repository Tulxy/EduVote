<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Přihlášení - Školní Tinder</title>
</head>
<body>

<h1>Přihlášení do aplikace</h1>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div>
        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Heslo:</label>
        <input type="password" name="password" required>
        @error('password')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit">Vstoupit</button>
</form>

</body>
</html>
