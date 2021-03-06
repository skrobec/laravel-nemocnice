<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height:100%;
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
                padding-bottom: 100px;
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
                height: 100%;

            }
            .side-nav {
                width: 15%;
                background-color: #F6F7F8;
                height: 100%;
                position: fixed;
                top: 0;
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
                cursor: pointer;

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
                margin-left: 15%;
            }
            .nav-item span {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;

                text-transform: uppercase;
                padding-bottom: 4px
            }
            #app {
                height: 100%;
            }
            .acc-manage {

            }
            .acc-manage  a {
                margin-right: 50px;
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                position: absolute;
                top: 10px;
                right: 15px;
            }
        </style>
    </head>
    <body>
    <div class="acc-manage">
        <a href="{{ route('logout') }}">
            Odhlásit
        </a>
    </div>
    <div class="main-container">
        <div class="side-nav">
        <div onclick="window.location='{{URL::route('patients')}}'" class="nav-item">
                <div class="ico-box"><i class="material-icons">hotel</i></div>
                <span>pacienti</span>
            </div>
            <div onclick="window.location='{{URL::route('exams')}}'" class="nav-item">
                <div class="ico-box"><i class="material-icons">accessibility</i></div>
                 <span>Vyšetření</span>
            </div>
            <div onclick="window.location='{{URL::route('sections')}}'" class="nav-item">
                <div class="ico-box"><i class="material-icons">local_hospital</i></div>
                <span>Oddělení</span>
            </div>
            <div onclick="window.location='{{URL::route('interventions')}}'" class="nav-item">
                <div class="ico-box"><i class="material-icons">work</i></div>
                <span>Zákroky</span>
            </div>
            <div onclick="window.location='{{URL::route('drugs')}}'" class="nav-item">
                <div class="ico-box"><i class="material-icons">local_pharmacy</i></div>
                <span>Léky</span>
            </div>
            <div onclick="window.location='{{URL::route('servings')}}'" class="nav-item">
                <div class="ico-box"><i class="material-icons">add_alert</i></div>
                <span>Podání</span>
            </div>
            <div onclick="window.location='{{URL::route('hospitalizations')}}'" class="nav-item">
                <div class="ico-box"><i class="material-icons">airline_seat_individual_suite</i></div>
                <span>Hospitalizace</span>
            </div>
            @if (Auth::user()->isAdmin())
                <div  onclick="window.location='{{URL::route('admin')}}'" class="nav-item">
                    <div class="ico-box"><i class="material-icons">group</i></div>
                    <span>Administrace</span>
                </div>
            @endif

        </div>
        <div class="content">
            <div id="app">
                   @yield('content')
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
