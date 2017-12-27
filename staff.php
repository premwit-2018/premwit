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


    $getschedule = $conn->prepare("SELECT * FROM `order` WHERE g = ?");
    $getschedule->bind_param('s',$row['staff']);
    $getschedule->execute();
    $schedule = $getschedule->get_result();
    $schedule = $schedule->fetch_array(MYSQLI_ASSOC);

    if($row['status'] != 'staff'){
        header("location: index.php");
    }
}   
else{
    header("location: index.php");
}

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Pre MWIT 2018 | Staff</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/node_modules/materialize-css/dist/css/materialize.min.css" rel="stylesheet">
        <link href="/node_modules/tether/dist/css/tether.min.css" rel="stylesheet">
        <script src="/node_modules/jquery/dist/jquery.js"></script>
        <script src="/node_modules/tether/dist/js/tether.min.js"></script>
        <script src="/node_modules/materialize-css/dist/js/materialize.min.js"></script>
        <script src="node_modules/js-cookie/src/js.cookie.js"></script>
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
            db = firebase.database();

            function todb(group, value) {
                var newPostKey = firebase.database().ref('map/Group ' + group + '/order/').push().key;
                var updates = {};
                updates['/map/Group ' + group + '/order/' + newPostKey] = value;
                return firebase.database().ref().update(updates);
            }

            function clr() {
                for (i = 1; i <= 20; i++) {
                    db.ref('map/Group ' + i + '/order/').remove();
                    for (j = 1; j <= 10; j++) {
                        db.ref('map/Group ' + i + '/' + j).set("false");
                    }
                }
            }
        </script>

        <style>
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

            body {
                font-family: 'Kanit', sans-serif;
            }

            .switch {
                margin: 20px;
            }

            .square {
                width: 100px;
                height: 100px;
                vertical-align: center;
                text-align: center;
                background: #fafafa;
            }
        </style>
    </head>

    <body>
        <ul class="side-nav" id="mobile-demo" style="padding-top: 24px;">
            <li class="sidebar">
                <a class="logout" href="#">Log Out</a>
            </li>
        </ul>
        <div class="navbar-fixed">
            <nav class="nav-extended blue-grey darken-4">
                <div class="nav-wrapper">
                    <a href="#" class="brand-logo">Pre-MWITS Staff</a>
                    <a href="#" data-activates="mobile-demo" class="button-collapse">
                        <i class="material-icons">menu</i>
                    </a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li>
                            <a class="logout" href="#">Log Out</a>
                        </li>
                    </ul>

                </div>
            </nav>
        </div>
        <div>
            <div style="max-width: 500px; margin: auto; padding: 20px;">
                Staff ประจำฐานที่
                <?php echo $row['staff'] ?>
                <br>
                <ul class="collection">
                    <li class="collection-item" id="period"></li>
                    <li class="collection-item" id="now"></li>
                    <li class="collection-item" id="next"></li>
                </ul>
                <button class="btn waves-effect waves-light red prev" name="action">
                    ย้อนกลับ (กดผิด)
                </button>
                <button class="btn waves-effect waves-light next" style="float: right;" name="action">
                    รับกลุ่มต่อไป
                </button>

    </body>
    <script>
        $(document).ready(function () {
            $('.logout').click(function () {
                window.location.replace("logout.php");
            });
            $('.modal').modal();
            $(".button-collapse").sideNav();
            var dataset;
            db.ref("map/Group 0").on('value', snap => {
                dataset = snap.val();
                console.log(dataset);
            });



            var period = 1;
            console.log(period);
            var sch = "<?php echo $schedule['staff'] ?>";
            var schedule = sch.split(",");
            $("#period").text("คาบที่ : " + period);
            var key = period - 1;
            $("#now").text("กลุ่มปัจจุบัน : " + schedule[key] + " , " + (parseInt(schedule[key])+10));
            $("#next").text("กลุ่มต่อไป : " + schedule[key + 1] + " , " + (parseInt(schedule[key + 1])+10));

            db.ref("map/Group " + schedule[key] + "/sch").on('value', snap => {
                var stdnow = snap.val();
                console.log(stdnow);
                todb(schedule[key], stdnow.split(",")[key]);
                todb(parseInt(schedule[key])+10, stdnow.split(",")[key]);
                console.log(schedule[key], stdnow.split(",")[key])
                db.ref('map/Group ' + schedule[key - 1] + '/' + stdnow.split(",")[key]).set(dataset[stdnow.split(",")[key]]); //to firebase
                db.ref('map/Group ' + (parseInt(schedule[key - 1])+10) + '/' + stdnow.split(",")[key]).set(dataset[stdnow.split(",")[key]]); //to firebase
            });

            $(".next").click(function () {
                period = period + 1;
                key = key + 1;
                if (key >= 0 && key < 10) {
                    $("#now").text("กลุ่มปัจจุบัน : " + schedule[key] + " , " + (parseInt(schedule[key])+10));
                    $("#next").text("กลุ่มต่อไป : " + schedule[key + 1] + " , " + (parseInt(schedule[key + 1])+10));
                    $("#period").text("คาบที่ : " + period);
                    console.log("period", period);
                    console.log("key", key)
                    db.ref("map/Group " + schedule[key - 1] + "/sch").on('value', snap => {
                        stdnow = snap.val();
                        console.log(stdnow.split(","));
                        console.log(schedule[key - 1], " go to ", stdnow.split(",")[key]);
                        todb(schedule[key - 1], stdnow.split(",")[key]);
                        todb(parseInt(schedule[key - 1])+10, stdnow.split(",")[key]);
                        db.ref('map/Group ' + schedule[key - 1] + '/' + stdnow.split(",")[key]).set(dataset[stdnow.split(",")[key]]); //to firebase
                        db.ref('map/Group ' + (parseInt(schedule[key - 1]) + 10) + '/' + stdnow.split(",")[key]).set(dataset[stdnow.split(",")[key]]); //to firebase
                    });

                    //db.ref('map/Group ' + schedule[key] + '/' + schedule[key + 1]).set(dataset[schedule[key + 1]]); //to firebase               
                } else if (key < 0) {
                    key = 0;
                    period = 1;
                    console.log("key", key);
                } else if (key >= 10) {
                    key = 9;
                    period = 10;
                    console.log("key", key);
                }
            });
            $(".prev").click(function () {
                period = period - 1;
                key = key - 1;
                if (key >= 0 && key < 9) {

                    console.log("key", key)
                    $("#now").text("กลุ่มปัจจุบัน : " + schedule[key] + " , " + (parseInt(schedule[key])+10));
                    $("#next").text("กลุ่มต่อไป : " + schedule[key + 1] + " , " + (parseInt(schedule[key + 1])+10));
                    $("#period").text("คาบที่ : " + period);
                    db.ref("map/Group " + schedule[key] + "/sch").on('value', snap => {
                        stdnow = snap.val();
                        console.log(stdnow.split(","));
                        console.log(schedule[key], " go to ", stdnow.split(",")[key + 1]);
                        //todb(schedule[key],stdnow.split(",")[key+1]);
                        db.ref('map/Group ' + schedule[key] + '/' + stdnow.split(",")[key + 1]).set("false"); //to firebase
                        db.ref('map/Group ' + (parseInt(schedule[key]) + 10) + '/' + stdnow.split(",")[key + 1]).set("false"); //to firebase
                    });

                } else if (key < 0) {
                    key = 0;
                    period = 1;
                    console.log("key", key);
                } else if (key >= 10) {
                    key = 9;
                    period = 10;
                    console.log("key", key);
                }
            });
        });
    </script>

    </html>