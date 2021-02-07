<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <!-- Fonts -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/appagenda.js') }}" defer></script>
    <!-- Scripts -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/appagenda.css') }}" rel="stylesheet">
    <!-- Styles -->

    <!-- Validacao -->
    <link href="{{ asset('css/validacao.estilo.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/validacao.js') }}" defer></script>
    <!-- Validacao -->
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">App Agenda</a>
          
        </div>
    </nav>
    <br>
    <div class="container">
        <main id="principal">
            <div id="lista">
                <div class="box_repetir hidden">
                    <div class="box_contato">
                        <div class="media">
                            <div class="media-left">
                                <div class="box_contato_imagem">
                                    <img src="<?php echo URL::to('/'); ?>/php/gera_foto.php?imagem=../{imagem}&perfil=redonda" alt="">
                                </div>
                            </div>
                            <div class="media-body">
                                <button class="remove btn btn-small btn-danger"><span class="fa fa-times"></span></button>
                                <div class="box_nome">
                                    {nome}
                                </div>
                                <hr>
                                <a href="tel:{telefone}">{telefone}</a>
                                <br />
                                <a href="mail:{email}">{email}</a>
                                <br />
                                <span>{endereco}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <aside id="aside">
                <a id='back' class=""><span class="fa fa-arrow-right"></span></a>
                <form>
                    <h3>{aside_text}</h3>
                    <br>
                    <label for="imagem" class="btn btn-primary">
                        <span class="text-left">
                            Imagem
                        </span>
                        <input class="d-none" id="imagem" type="file" name="imagem" />
                    </label>
                    <br>
                    <label class="label-control">
                        <input type="text" placeholder="Nome" id="nome" name="nome" />
                    </label>
                    <br>
                    <label class="label-control">
                        <input type="text" maxlength="15" placeholder="Telefone" id="telefone" name="telefone" />
                    </label>
                    <br>
                    <label class="label-control">
                        <input type="text" placeholder="Email" id="email" name="email" />
                    </label>
                    <br>
                    <label class="label-control">
                        <input type="text" placeholder="Endereço" id="endereco" name="endereco" />
                    </label>
                    <br>
                    <button class="btn "></button>
                </form>
            </aside>
        </main>
    </div>

    <button id="new" class="btn btn-success"><span class="fa fa-plus"></span></button>
</body>
<script src="{{ mix('js/app.js') }}"></script>

</html>