<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Registrace - Školní Tinder</title>
</head>
<body>

<h1>Registrace do aplikace</h1>

<form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
        <label>Name:</label>
        <input type="text" name="name" value="{{ old('name') }}" required autofocus>
        @error('name')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

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

    <div>
        <label>Potvrzení hesla:</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <button type="submit">Zaregistrovat se</button>
</form>

</body>
</html>
