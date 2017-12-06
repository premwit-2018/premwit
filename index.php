<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="node_modules/tether/dist/css/tether.min.css" rel="stylesheet">
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="node_modules/tether/dist/js/tether.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <style>
        body,
        input,
        button {
            font-family: 'Kanit', sans-serif;
        }

        .box {
            height: auto;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            padding: 20px;
            border-radius: 5px;
            position: absolute;
            border: none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }


        @media(min-width: 720px) {
            .box {
                width: 400px;
            }
        }

        @media(max-width: 720px) {
            .box {
                width: 90vw;
            }
        }

        body {
            background-color: #0d47a1;
        }
    </style>
</head>

<body>
    <main>

        <div class="box card">
            <h3 style="text-align:center">Pre MWIT 2018 Log In</h3>
            <br>
            <form>

                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-primary">Log In</button>
            </form>
        </div>


    </main>

</html>