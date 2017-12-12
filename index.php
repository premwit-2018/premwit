<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pre MWIT 2018 | Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="node_modules/tether/dist/css/tether.min.css" rel="stylesheet">
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="node_modules/tether/dist/js/tether.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <link rel="stylesheet" href="node_modules/frontend/style.css">
    <style>

    </style>
</head>

<body>
    <main>

        <div class="box card">
            <h3 style="text-align:center">Pre MWIT 2018 Log In</h3>
            <br>
            <form action="authen.php" method="post">

                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Username" name="username">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                </div>

                <button type="submit" class="btn btn-primary">Log In</button>
            </form>
        </div>


    </main>

</html>