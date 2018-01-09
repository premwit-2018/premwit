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
    $getdata = $conn->prepare("SELECT * FROM user WHERE id = ?");
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
            db.ref("map/Group " + <?php echo $name; ?>).on('value', snap => {
                var data = snap.val();
                console.log(data);
                for (j = 1; j <= 9; j++) {
                    if (data[j] != "false") {
                        $("#field" + j).css("background", "url(" + data[j] + ") center / cover");
                    } else {
                        $("#field" + j).css("background", "#f3c58a");
                    }
                }

            });
            var loc = {
            1:"ใต้หอชายฝั่ง B",
            2:"ลู่วิ่งหน้าเครื่องบริหารร่างกาย", 
            3:"ใต้หอชายฝั่ง G",
            4:"ลู่วิ่งหน้าหอชาย",
            5:"สนามบาสหน้าห้องสมุด",
            6:"สนามฟุตบอลฝั่งเปตอง",
            7:"หน้าห้องผ้า",
            8:"ใต้เรือนไทย",
            9:"สนามบาสหน้ามาร์ทมืดเก่า",
            10:"สวนอาทิตย์",
            };            

            var atk = db.ref("map/Group " + <?php echo $name; ?> + "/order").on('child_added', snap => {
                console.log("added", snap.val());
                $('#modal1').modal('open');
                $("#mcontent").text("ไปฐานที่ " + snap.val());
                $("#loc").text(loc[snap.val()]);
                $("#hhh").text("ฐานที่ " +snap.val()+" "+ loc[snap.val()]);
                $(".collection").prepend(" <li class='collection-item'>ฐานที่ " + snap.val() + "</li>");
            });
        </script>
        <style>
            .map {
                background-size: cover;
                background-position: center;
                width: 33.33%;
                padding-bottom: 25.27%;
                margin: 0;
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
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4 id="mcontent"></h4>
                <h5 id="loc"></h5>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Ok</a>
            </div>
        </div>


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
                        <li class="tab 3">
                            <a id="third" href="#map">
                                Map
                            </a>
                        </li>
                        <li class="tab">
                            <a id="first" href="#profile">
                                Profile
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
            Group:
            <?php echo $name ?>
            <br> Name:
            <?php echo $group ?>
        </div>

        <div id="map" class="col s12">
            <div class="row" style="padding-top: 70px;">
                <div class="col s12 ">
                    <div style="max-width: 640px; padding: 20px; margin:auto;">
                        <h4>ฐานที่ต้องไป</h4>
                            <h5 id="hhh">Connecting...</h5>
                    </div>
                </div>
                <div class="col s12">
                    <div style="max-width: 640px; margin:auto; padding: 20px;">
                    <h4>ชิ้นส่วนแผนที่ที่ได้รับ</h4>
                    <div id="mapcontainer" style="width: 100%;">
                        <div class="map" id="field1"></div>
                        <div class="map" id="field2"></div>
                        <div class="map" id="field3"></div>
                        <div class="map" id="field4"></div>
                        <div class="map" id="field5"></div>
                        <div class="map" id="field6"></div>
                        <div class="map" id="field7"></div>
                        <div class="map" id="field8"></div>
                        <div class="map" id="field9" style="margin-bottom: 20px;"></div>
                    </div>
                </div>
                </div>
            </div>
        </div>

        </div>

    </body>
    <script>
        $(document).ready(function () {
            $('.logout').click(function () {
                window.location.replace("logout.php");
            });
            $('.modal').modal();
            $(".button-collapse").sideNav();
        });
        $(".help").click(function () {
            $('#modal1').modal('open');
        });


    </script>

    </html>