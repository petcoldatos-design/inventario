<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PlastyPetco - Login</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background:  url('images/fon2.png');
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Arial', sans-serif;
        }
        .login-box {
            backdrop-filter: blur(8px);
            padding: 40px;
            width: 350px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgb(0, 0, 0);
            text-align: center;
            border: 2px solid rgb(6, 133, 3);
        }
        .logo-emoji {
            font-size: 70px;
        }
        .plastypet-title {
            margin: 10px 0 20px 0;
            font-size: 28px;
            font-weight: bold;
        }
        .plastypet-title .green { color: #3db83f; }
        .plastypet-title .blue { color: #2f92fb; }
        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            background: rgb(255, 255, 255);
        }
        .login-box button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #2f92fb;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
        }
        .login-box button:hover {
            background: #2b86e7;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }
        h1 {
            color: #ffffff;
            margin-bottom: 20px;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo-emoji"><img src="{{ asset('images/plas.jpg') }}" alt="Logo" style="height:100px;"></div>
        <h2 class="plastypet-title">
            <span class="green">Plasty</span><span class="blue">Petco</span>
        </h2>
        <h1>Iniciar Sesión</h1>

        @if($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="text" name="usuario" placeholder="Usuario" value="{{ old('usuario') }}" required autofocus>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>