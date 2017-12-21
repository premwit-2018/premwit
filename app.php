<?php

session_start();
if(isset($_SESSION['id'])){
    require_once "dbhelper.php";
    $conn = connect_db();
    if(!$conn){
        echo "<p> Connection Error </p>";
        close_db($conn);
        die();
    }
    $getdata = $conn->prepare("SELECT * FROM user WHERE user = ?");
    $getdata->bind_param('s',$_SESSION['id']);
    $getdata->execute();
    $userdata = $getdata->get_result();
    $row = $userdata->fetch_array(MYSQLI_ASSOC); //all data from db in array sql injection protected
    $group = $row["name"];
}
else{
    header('Location: index.php');
}
$name = $_SESSION['id'];

?>

    <!doctype html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Pre MWIT 2018</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="node_modules/materialize-css/dist/css/materialize.min.css" rel="stylesheet">
        <link href="node_modules/tether/dist/css/tether.min.css" rel="stylesheet">
        <script src="node_modules/jquery/dist/jquery.js"></script>
        <script src="node_modules/tether/dist/js/tether.min.js"></script>
        <script src="node_modules/materialize-css/dist/js/materialize.min.js"></script>
        <script src="node_modules/js-cookie/src/js.cookie.js"></script>
        <link rel="stylesheet" href="node_modules/frontend/app-style.css">
        <link rel="stylesheet" href="node_modules/animate.css/animate.min.css">
        <link href="https://fonts.googleapis.com/css?family=Kanit:300,400|Material+Icons" rel="stylesheet">

        <style>
            .tabcontent {
                padding-top: 70px;
                text-align: center;
            }

            @media(min-width: 600px) {
                .brand-logo {
                    margin-left: 20px;
                    font-size: 2em;
                    white-space: nowrap;
                }
            }

            @media(max-width: 600px) {
                .brand-logo {
                    margin-left: 0px;
                    font-size: 1.5em !important;
                    white-space: nowrap;
                }
            }

            .avatar {
                width: 200px;
                height: 200px;
                border-radius: 50%;
                background-size: contain;
                margin: auto;
                margin-bottom: 24px;
            }

            .inventory {
                width: 100%;
                height: auto;
            }

            body {}

            .item-modal {
                padding: 20px;
                position: absolute;
                width: 100vw;
                min-height: 50vh;
                bottom: 0;
                left: 0;
                display: none;
                z-index: 99;
                background: white;
            }

            .overlay {
                z-index: 98;
                position: fixed;
                width: 100vw;
                height: 100vh;
                background: black;
                opacity: 0.4;
                left: 0;
                bottom: 0;
                display: none;
            }

            .operation {
                width: 100%;
            }
        </style>
    </head>

    <body>
        <div class="overlay"></div>


        <ul class="side-nav" id="mobile-demo" style="padding-top: 24px;">
            <li class="sidebar">
                <a class="logout" href="#">Log Out</a>
            </li>
        </ul>
        <div class="navbar-fixed">
            <nav class="nav-extended blue-grey darken-4">
                <div class="nav-wrapper">
                    <a href="#" class="brand-logo">ลงทะเบียน</a>
                    <a href="#" data-activates="mobile-demo" class="button-collapse">
                        <i class="material-icons">menu</i>
                    </a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li>
                            <a class="logout" href="#">Log Out</a>
                        </li>
                    </ul>

                </div>
                <div class="nav-content blue-grey darken-3">
                    <ul class="tabs tabs-transparent tabs-fixed-width">
                        <li class="tab">
                            <a id="first" href="#profile">
                                Profile
                            </a>
                        </li>
                        <li class="tab 2">
                            <a id="second" href="#inventory">
                                Inventory
                            </a>
                        </li>
                        <li class="tab 3">
                            <a id="third" href="#map">
                                Map
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div id="modal1" class="modal bottom-sheet">
            <div class="modal-content">
                <h4>Modal Header</h4>
                <p>A bunch of text</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
            </div>
        </div>

        <div id="profile" class="tabcontent col s12">
            <div class="avatar" style="background-image:url(img/man.png)"></div>
            Name:
            <?php echo $name ?>
            <br> Group:
            <?php echo $group ?>
        </div>
        <div id="inventory" class="tabcontent col s12">
            <table class="centered highlight" style="max-width: 800px; margin:auto;">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jacob</td>
                        <td>Misc</td>
                        <td>
                            <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Use</a>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Larry</td>
                        <td>Weapon</td>
                        <td>
                                <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Use</a>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div id="map" class="tabcontent col s12">

        </div>

    </body>
    <script>
        $(document).ready(function(){
            $('.logout').click(function () {
                window.location.replace("logout.php");
            });
            $('.modal').modal();
        });
    </script>
    <footer class="feet">
        <?php echo "php is working. (c) Pre MWITS 2018 Dev Team " ?>

    </footer>

    </html>