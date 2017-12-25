<?php
session_start();
if(isset($_SESSION['id'])){
    if($_SESSION['id'] != 0){
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
                <div class="input-field col s12">
                    <select>
                        <option value="1">Group 1</option>
                        <option value="2">Group 2</option>
                        <option value="3">Group 3</option>
                        <option value="4">Group 4</option>
                        <option value="5">Group 5</option>
                        <option value="6">Group 6</option>
                        <option value="7">Group 7</option>
                        <option value="8">Group 8</option>
                        <option value="9">Group 9</option>
                    </select>
                    <label>เลือกกลุ่ม</label>
                </div>
                <div class="controller" style="height: 300px; overflow: auto;">
                    <div class="switch">
                        <label>
                            Segment 1
                            <input type="checkbox" id="seg1" value="1">
                            <span class="lever"></span>
                        </label>
                    </div>
                    <div class="switch">
                        <label>
                            Segment 2
                            <input type="checkbox" id="seg2" value="2">
                            <span class="lever"></span>
                        </label>
                    </div>
                    <div class="switch">
                        <label>
                            Segment 3
                            <input type="checkbox" id="seg3" value="3">
                            <span class="lever"></span>
                        </label>
                    </div>
                    <div class="switch">
                        <label>
                            Segment 4
                            <input type="checkbox" id="seg4" value="4">
                            <span class="lever"></span>
                        </label>
                    </div>
                    <div class="switch">
                        <label>
                            Segment 5
                            <input type="checkbox" id="seg5" value="5">
                            <span class="lever"></span>
                        </label>
                    </div>
                    <div class="switch">
                        <label>
                            Segment 6
                            <input type="checkbox" id="seg6" value="6">
                            <span class="lever"></span>
                        </label>
                    </div>
                    <div class="switch">
                        <label>
                            Segment 7
                            <input type="checkbox" id="seg7" value="7">
                            <span class="lever"></span>
                        </label>
                    </div>
                    <div class="switch">
                        <label>
                            Segment 8
                            <input type="checkbox" id="seg8" value="8">
                            <span class="lever"></span>
                        </label>
                    </div>
                    <div class="switch">
                        <label>
                            Segment 1
                            <input type="checkbox" id="seg9" value="9">
                            <span class="lever"></span>
                        </label>
                    </div>
                </div>
                <br>
                <button id="save" class="btn waves-effect waves-light" type="submit" name="action">Submit</button>
            </div>
    </body>
    <script>
        $(document).ready(function () {
            $('.logout').click(function () {
                window.location.replace("logout.php");
            });
            $('.modal').modal();
            $(".button-collapse").sideNav();
            $('select').material_select();
        });
        $("select").on('change', function () {
            db.ref("map/Group " + $("select").val()).on('value', snap => {
                var data = snap.val();

                var i;
                for (i = 1; i <= 9; i++) {
                    if (data[i] != "false") {
                        $("#seg" + i).prop('checked', true);
                    } else {
                        $("#seg" + i).prop('checked', false);
                    }
                }
            });
        });

        var dataset;
        db.ref("map/Group 0").on('value', snap => {
            dataset = snap.val();
        });

        $("#save").click(function () {

            var json = [];
            var i;
            for (i = 1; i <= 9; i++) {

                if ($("#seg" + i).prop('checked')) {
                    json.push(dataset[i]);
                } else {
                    json.push("false");
                }
            }
            db.ref('map/Group ' + $("select").val()).set({
                1: json[0],
                2: json[1],
                3: json[2],
                4: json[3],
                5: json[4],
                6: json[5],
                7: json[6],
                8: json[7],
                9: json[8],
            });
            Materialize.toast('บันทึกแล้ว', 1000)
        });
    </script>

    </html>