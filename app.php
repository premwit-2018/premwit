<?php
/*
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
*/
?>

    <!DOCTYPE html>
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
        <script src="https://www.gstatic.com/firebasejs/4.8.1/firebase.js"></script>
	<script>
	  // Initialize Firebase
	  var config = {
		apiKey: "AIzaSyAEX9X8bnUyVoI2OKMhJqy3dJmEErzRRXc",
		authDomain: "pre-mwits-2018-cdn.firebaseapp.com",
		databaseURL: "https://pre-mwits-2018-cdn.firebaseio.com",
		projectId: "pre-mwits-2018-cdn",
		storageBucket: "pre-mwits-2018-cdn.appspot.com",
		messagingSenderId: "655785045663"
	  };
	  
    firebase.initializeApp(config);
    var db = firebase.database();
    var i=1;
    var j;
    db.ref("map/Group "+i).on('value',snap => {
        var data = snap.val();
        console.log(data);
        for(j = 1; j<=9; j++){
            if(data[j]!=false){
                $("#field"+j).css("background-image","url("+ data[j] +")");
            }
            else{
                $("#field"+j).css("background","#f3c58a");
            }
        }
        
    });      
    
  </script>
        <style>
            .map{
                background-size: cover;
                background-position: center;
                width: 33vw;
                margin: 0;
                height: 33vw;
                background-color: gray;
                float: left;
            }
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
                    <a href="#" class="brand-logo">Pre-MWITS 2k18</a>
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
        <div id="map" class="tabcontent col s12">
            <div style="width: 100vw; height: 33vw;">
                <div class="map" id="field1"></div>
                <div class="map" id="field2"></div>
                <div class="map" id="field3"></div>
            </div>
            <div style="width: 100vw; height: 33vw;">
                <div class="map" id="field4"></div>
                <div class="map" id="field5"></div>
                <div class="map" id="field6"></div>
            </div>
            <div style="width: 100vw; height: 33vw;">
                <div class="map" id="field7"></div>
                <div class="map" id="field8"></div>
                <div class="map" id="field9"></div>
            </div>                        
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