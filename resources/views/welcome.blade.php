<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Ciudad Digital</title>
    <style>
        :root {
            --color-principal: #9D2449;
            --color-secundario: #f1f5f9;
            --color-accion: #9D2449;
        }


        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--color-secundario);
            color: #333;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--color-secundario);
            color: #333;
        }

        header {
            background: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        header h1 {
            color: var(--color-principal);
            margin: 0;
            font-size: 1.5rem;
        }

        nav a {
            margin-left: 1rem;
            text-decoration: none;
            color: #555;
            font-size: 0.95rem;
        }

        nav a:hover {
            color: var(--color-principal);
        }

        .hero {
            background: linear-gradient(to right, #cd476f, #9D2449);
            color: white;
            text-align: center;
            padding: 4rem 2rem;
        }

        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .hero a {
            background: white;
            color: var(--color-principal);
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        .hero a:hover {
            background: #e0e7ff;
        }

        .tramites {
            max-width: 1000px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .tramites h3 {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 2rem;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-5px);
            background-color: #eecf6b7a;
        }

        .card h4 {
            margin: 0 0 0.5rem 0;
            color: var(--color-principal);
        }

        .card p {
            font-size: 0.95rem;
            color: #666;
        }

        footer {
            background: #fff;
            text-align: center;
            padding: 1rem;
            font-size: 0.85rem;
            color: #888;
            margin-top: 4rem;
            border-top: 1px solid #ddd;
        }

        /* Estilo personalizado del carrusel Splide */
            .splide {
                max-width: 100%;
                margin: 2rem auto;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            }

            .splide__slide {
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: white;
            }

            .splide__slide img {
                max-width: 100%;
                height: auto;
                object-fit: contain;
                display: block;
            }

            @media (min-width: 768px) {
                .splide {
                    max-width: 800px;
                }
            }



    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css">
</head>

    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Splide('.splide', {
            type: 'loop',
            perPage: 1,
            autoplay: true,
            pauseOnHover: false,
            interval: 5000,
        }).mount();
    });
</script>

<body>

    <header class="flex items-center justify-between px-4 py-2 border-b shadow-sm bg-white">
        <div class="bg-red-100 border border-red-400 p-2 inline-block">
            <img src="{{ asset('img/logo_xs.png') }}" alt="Logo" class="h-[10px] w-[10]">
        </div>

        <nav class="flex space-x-4 text-sm font-medium text-gray-700">
            @auth
                <a href="{{ route('dashboard') }}" class="hover:text-[#9D2449]">Panel</a>
            @else
                <a href="{{ route('login') }}" class="hover:text-[#9D2449]">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="hover:text-[#9D2449]">Registrarse</a>
            @endauth
        </nav>
    </header>


    <main>


        <section class="hero">
            <h2>Bienvenido a Mi Ciudad Digital</h2>
            <p>Realiza tus trámites gubernamentales en línea, sin filas ni esperas.</p>
            <a href="{{ route('login') }}">Empieza ahora</a>
        </section>

            <section>
                <div class="splide" aria-label="Carrusel de imágenes">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <li class="splide__slide">
                                <img src="{{ asset('img/slide1.jpeg') }}" alt="Imagen 1">
                            </li>
                            <li class="splide__slide">
                                <img src="{{ asset('img/slide2.png') }}" alt="Imagen 2">
                            </li>
                            <li class="splide__slide">
                                <img src="{{ asset('img/slide3.png') }}" alt="Imagen 3">
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

        <section class="tramites">
            <h3>Trámites disponibles</h3>
            <div class="cards">
                <div class="card">
                    <h4>Permiso de uso de suelo</h4>
                    <p>Solicítalo en línea y recibe tu respuesta sin visitar oficinas.</p>
                </div>
                <div class="card">
                    <h4>Programa de Protección Civil</h4>
                    <p>Gestiona tu plan de seguridad desde casa.</p>
                </div>
                <div class="card">
                    <h4>Licencia de funcionamiento</h4>
                    <p>Trámite rápido para nuevos negocios o renovaciones.</p>
                </div>
            </div>
        </section>

    </main>



    <footer>
        &copy; {{ now()->year }} Mi Ciudad Digital — Todos los derechos reservados.
    </footer>

</body>

</html>

