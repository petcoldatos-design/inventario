<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login PlastyPetco</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background:  url("{{ asset('images/fondo.jpg') }}") no-repeat center center fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Arial', sans-serif;
        }
        .login-box {
            background: rgba(255, 255, 255, 0.66);
            padding: 40px;
            width: 350px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.25);
            text-align: center;
        }
        .logo-emoji {
            font-size: 70px;
        }
        .plastypet-title {
            margin: 10px 0 20px 0;
            font-size: 28px;
            font-weight: bold;
        }
        .plastypet-title .green { color: #0db10d; }
        .plastypet-title .blue { color: #007bff; }
        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }
        .login-box button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #007bff;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
        }
        .login-box button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo-emoji">♻️</div>
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