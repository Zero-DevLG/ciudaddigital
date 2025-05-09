@php

    $config = app(App\Services\ConfigService::class);

    $config->clearCache();
@endphp


@vite('resources/css/configuration.css')
<div class="grid gap-4">

    <aside class="col-span-1 bg-gray-800 text-white h-screen p-4 rounded-2xl">

        <div class="content">
            <div>
                <h1>Configuracion global</h1>
                <hr>
                <p>
                    Desde esta sección puedes personalizar la apariencia de tu plataforma para que se alinee con la
                    identidad visual de tu organización.
                </p>
            </div>
            <br>
            <div>

                <form action="{{ route('configuration.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="container-form">

                        <div class="t-option">

                            <div class="logo-options instrucciones">
                                <p>
                                    En esta sección podrás cambiar el logo de la institución, el cual será visible en
                                    varias secciones de la plataforma. Asegúrate de que el logo esté en formato .png o
                                    .jpg, con un tamaño de 600x400 píxeles para garantizar su correcta visualización.
                                    Una vez que cargues el nuevo logo, <strong> recuerda guardar los cambios para que se
                                        apliquen
                                        en toda la plataforma.</strong>
                                </p>
                                <hr>
                                <p>Logo actual:</p>
                            </div>
                            <div class="logo-options">
                                <div class="logo-preview">
                                    <img src="{{ asset($config->get('logo', 'img/default.png')) }}" alt="Logo">
                                </div>
                                <hr class="border-t-2">
                                <label for="logo">Cambiar logo institucional</label>
                                <input type="file">

                            </div>


                        </div>

                        <div class="t-option">
                            <div class="logo-options instrucciones">
                                <p>
                                    En esta sección podrás personalizar los colores institucionales que se utilizarán en
                                    varias partes de la plataforma, como la barra lateral, los botones y los
                                    encabezados. Elige los colores que mejor representen la identidad visual de tu
                                    organización. <strong>Recuerda guardar los cambios una vez que hayas seleccionado
                                        los colores para que se apliquen correctamente en toda la plataforma</strong>
                                </p>
                            </div>

                            <hr class="border-t-2">

                            <div class="color-options">
                                <div class="option-c">
                                    <label for="color">Elige el color de fondo:</label>
                                    <input type="color" id="color" name="color"
                                        value="{{ $config->get('color_body', '#ffff') }}">
                                </div>

                                <div class="option-c">
                                    <label for="color">Elige el color de los menús laterales:</label>
                                    <input type="color" id="color" name="color"
                                        value="{{ $config->get('color_sidebar', '#ffff') }}">
                                </div>

                                <div class="option-c">
                                    <label for="color">Elige el color del menu superior:</label>
                                    <input type="color" id="color" name="color"
                                        value="{{ $config->get('color_navbar', '#ffff') }}">
                                </div>

                                <div class="option-c">
                                    <label for="color">Elige el color del footer:</label>
                                    <input type="color" id="color" name="color"
                                        value="{{ $config->get('color_info', '#ffff') }}">
                                </div>

                            </div>
                            <br>
                        </div>


                        <div class="t-option-n">
                            <div class="container-button">
                                <button type="submit" class="button">Guardar cambios</button>
                            </div>
                        </div>


                    </div>





                </form>

            </div>

        </div>
    </aside>




</div>
