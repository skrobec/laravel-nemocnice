<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 50vh;
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
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .nav-item > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;

                text-transform: uppercase;
                padding-bottom: 4px
            }

            .main-container {
                display: flex;
                justify-content: left;
                height: 100%;
            }
            .side-nav {
                width: 15%;
                background-color: #F6F7F8;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .nav-item {
                margin-top: 20px;
                padding-top: 5px;
                padding-bottom: 5px;
            }

            .nav-item:hover {
                background-color: #FFFFFF;
                border-radius: 5px;

            }
            .ico-box {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .m-b-md {
                margin-bottom: 0px;
            }
            .content {
                width: 85%;
            }
        </style>
    </head>
    <body>
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif
    <div class="main-container">
        <div class="side-nav">
            <div class="nav-item">
                <div class="ico-box"><i class="material-icons">hotel</i></div>

                <a href="{{URL::route('patients')}}">Pacienti</a>
            </div>
            <div class="nav-item">
                <div class="ico-box"><i class="material-icons">accessibility</i></div>
                 <a  href="{{URL::route('exams')}}">Vyšetření</a>
            </div>
            <div class="nav-item">
                <div class="ico-box"><i class="material-icons">local_hospital</i></div>
                <a  href="{{URL::route('sections')}}">Oddělení</a>
            </div>
            <div class="nav-item">
                <div class="ico-box"><i class="material-icons">work</i></div>
                <a  href="">Zákroky</a>
            </div>
            <div class="nav-item">
                <div class="ico-box"><i class="material-icons">local_pharmacy</i></div>
                <a  href="{{URL::route('drugs')}}">Léky</a>
            </div>

        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
