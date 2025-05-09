@vite(['resources/js/app.js', 'resources/js/register.js'])
<x-guest-layout>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f1f5f9;
        }

        .register-container {
            max-width: 500px;
            margin: 4rem auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .register-title {
            text-align: center;
            color: #1e3a8a;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        #btn-registrar {
            background-color: transparent;
            border: 2px solid #337ab7;
            color: #337ab7;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        #btn-registrar:hover:enabled {
            background-color: #337ab7;
            color: #fff;
        }

        #btn-registrar:disabled {
            background-color: #b0c4de;
            cursor: not-allowed;
            opacity: 0.7;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.3rem;
            color: #333;
        }

        input {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 1rem;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px #93c5fd;
        }

        .curp-field {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .curp-field input {
            flex: 1;
        }

        .btn-validate {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 0.5rem 0.8rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .btn-validate:hover {
            background-color: #1e40af;
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
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #555;
        }

        .link:hover {
            color: #1e3a8a;
        }

        .error {
            color: #dc2626;
            font-size: 0.85rem;
            margin-top: -0.8rem;
            margin-bottom: 1rem;
        }
    </style>

    <div class="register-container">

        <div id="spinner-container" class="d-none text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Validando CURP, espere hasta que se haya validado...</span>
            </div>
            <p>Validando CURP, espere hasta que se haya validado...</p>
        </div>
        <div class="register-title">Crear una cuenta</div>

        <div class="alert alert-info" role="alert">
            <strong>Importante:</strong> Solo se permite una cuenta por CURP para prevenir fraudes y proteger tu
            identidad.
            <a href="#" data-bs-toggle="modal" data-bs-target="#infoCurpModal" class="pull-right">Más
                información</a>

        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nombre -->
            <div>
                <label for="name">Nombre completo</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- CURP -->
            <div>
                <label for="curp">CURP</label>
                <div class="curp-field">
                    <input id="curp" type="text" name="curp" value="{{ old('curp') }}" required
                        maxlength="18">
                    <button type="button" class="btn-validate" id="validarCurp">Validar CURP</button>
                </div>
                @error('curp')
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

            <!-- Confirmar Password -->
            <div>
                <label for="password_confirmation">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
                @error('password_confirmation')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" id="curp-validada" value="0">

            <button class="btn btn-primary" id="btn-registrar" disabled>
                Registrarse
            </button>

            <a class="link" href="{{ route('login') }}">¿Ya tienes cuenta? Inicia sesión</a>
        </form>

        <div class="modal fade" id="infoCurpModal" tabindex="-1" aria-labelledby="infoCurpModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="infoCurpModalLabel">
                            <i class="bi bi-info-circle-fill me-2"></i> ¿Por qué solo una cuenta por CURP?
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">
                            La <strong>CURP</strong> es un identificador único nacional en México. Por motivos de
                            seguridad y para prevenir suplantaciones de identidad,
                            nuestro sistema solo permite registrar una cuenta por CURP.
                        </p>
                        <p>
                            Si ya tienes una cuenta y no puedes acceder, por favor comunícate con nuestro equipo de
                            soporte para ayudarte a recuperarla de forma segura.
                        </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <small class="text-muted">Gracias por tu comprensión y colaboración.</small>
                        <button type="button" class="btn btn-outline-primary"
                            data-bs-dismiss="modal">Entendido</button>
                    </div>
                </div>
            </div>
        </div>





    </div>



</x-guest-layout>
