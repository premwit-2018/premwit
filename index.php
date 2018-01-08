<!doctype html>
<html>
<?php
    ini_set("default_charset","utf-8");
    session_start();
    if(isset($_SESSION['id'])){
        header("Location: rdr.php");
    }
    else{}
    
?>
<head>
    <meta charset="UTF-8">
    <title>Pre MWIT 2018 | Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="node_modules/materialize-css/dist/css/materialize.min.css" rel="stylesheet">
    <link href="node_modules/tether/dist/css/tether.min.css" rel="stylesheet">
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="node_modules/tether/dist/js/tether.min.js"></script>
    <script src="node_modules/materialize-css/dist/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="node_modules/frontend/style.css">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-title" content="PRE-MWITS 2018"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-touch-icon" href="/img/logo.png"/>
    <meta name="theme-color" content="#353e48"/>
    <link rel="icon" href="/img/logo.png"/>
    <link rel="icon" sizes="192x192" href="/img/logo.png"/>
    <link rel="shortcut icon" href="/img/logo.png"/>
    <script src="/js/companion.js" data-service-worker="/sw.js"></script>
    <style>

    </style>
</head>

<body>
    <main>

        <div class="box card">
            <h4 style="text-align:center">Pre MWIT 2018 Log In</h3>
            <br>
            <form action="authen.php" method="post">
            <div class="input-field">
                <input placeholder="Username" id="uname" type="text" class="validate" name="username">
                <label for="uname">Username</label>
            </div>
            <div class="input-field">
                <input placeholder="Password" id="pw" type="password" class="validate" name="password">
                <label for="pw">Password</label>
            </div>                   
                <button type="submit" class="btn waves-effect waves-light">Log In</button>
            </form>
        </div>


    </main>
</body>
</html>
