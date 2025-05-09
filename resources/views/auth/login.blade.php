<x-guest-layout>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f1f5f9;
        }

        .login-container {
            max-width: 400px;
            margin: 5rem auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            text-align: center;
            color: #1e3a8a;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.3rem;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 1rem;
            box-sizing: border-box;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px #93c5fd;
        }

        .error {
            color: #dc2626;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        .btn-submit {
            background-color: #2563eb;
            color: white;
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background-color: #1e40af;
        }

        .link {
            display: block;
            margin-top: 1rem;
            text-align: right;
            font-size: 0.9rem;
            color: #555;
        }

        .link:hover {
            color: #1e3a8a;
        }
    </style>

    <div class="login-container">
        <div class="login-title">Iniciar Sesión</div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="error">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Ingresar</button>

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <a class="link" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
        </form>
    </div>
</x-guest-layout>
