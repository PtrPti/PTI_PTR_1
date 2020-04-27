<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>WeGroup</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            html, body {
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            body {
                background-image: url('/images/arrows.png');
                background-size:70%;
                background-repeat:no-repeat;
                background-position-y:bottom;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            h3{
                margin-top: -37px
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                @if(Auth::user() != null)
                    @if (Auth::user()->isAluno())
                        <a href="{{ route('homeAluno') }}">Home</a>
                    @elseif (Auth::user()->isProfessor())
                        <a href="{{ route('homeDocente') }}">Home</a>
                    @endif                    
                @else
                    <a href="{{ url('/login') }}">Iniciar Sessão</a>
                    <a href="{{ url('/registar') }}">Registo</a>
                @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <img src="{{ asset('images/big_logo.png') }}" width=25% class="image_logo">
                </div>

                <div class="links">
                     <p>We Group, We grow</p> 
                </div>
            </div>
        </div>
    </body>
</html>
