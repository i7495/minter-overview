<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Minter Pool</title>
        <link rel="stylesheet" href="{{ mix('css/vendor.css') }}">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#2b2d3e">
        <meta name="msapplication-TileColor" content="#2b2d3e">
        <meta name="theme-color" content="#2b2d3e">

    </head>
    <body>

    <div id="app">
        <div class="section header">
            <div class="container header">
                <header>
                    <a href="/" class="logo"><img src="/img/logo.png" alt="Minter Logo" /> Minter Overview</a>
                    <ul class="navigation">
                        <li><a href="https://minterpool.com">MinterPool .com</a></li>
                    </ul>
                </header>
            </div>
        </div>

        <div id="delegate" class="section networkOverview">
            <div class="container networkOverview">
                <h2>Minter Network Status:</h2>
                <network-overview></network-overview>
            </div>
        </div>

        <div id="delegate" class="section candidatesOverview">
            <div class="container candidatesOverview">
                <h2>Validators/Candidates:</h2>
                <validators-overview></validators-overview>
            </div>
        </div>

        <div class="section footer">
            <div class="container">
               <p>&nbsp;</p>
            </div>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>

    </body>
</html>
