
    
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
                    .center {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100%;
                    }
                    a {
                        font-size: 2em;
                        text-transform: uppercase;
                        color: 	rgb(200,200,200);
                    }
                    body {
                        height: 100%;
                    }
                    html {
                        height: 100%;
                        font-family: 'Nunito', sans-serif;
                    }
                    h1 {
                        font-size: 4em;
                        color: #636b6f;
                        font-family: 'Nunito', sans-serif;
                        text-transform: uppercase;
                    }
                    .links {
                        display: flex;
                        justify-content: space-between;
                        width: 300px;
                        margin-top: 50px;
                    }
                    .cont {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;
                    }
                </style>
            </head>
            <body>
                <div class="center">
                    <div class="cont">
                        <h1>IS Nemocnice</h1>
                        <div class="links">
                            <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}">Register</a>
                        </div>
                    </div>   
                </div>
            </body>
        </html>
        
