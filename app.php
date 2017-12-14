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
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="node_modules/tether/dist/css/tether.min.css" rel="stylesheet">
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="node_modules/tether/dist/js/tether.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="node_modules/frontend/app-style.css">
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">

    <style>
        .avatar {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background-size: contain;
            margin: auto;
            margin-bottom: 24px;
        }
        .inventory{
            width: 100%;
            height: auto;
            overflow-y:auto;
        }
        .item{
            width: 100%;
            height: 100%;
            background-color: gray;
        }
        body{
            padding: 20px;
        }
    </style>
</head>

<body>

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home"
                    aria-selected="true">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile"
                    aria-selected="false">Inventory</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact"
                    aria-selected="false">Game</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent" style="">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" style="text-align:center">
                <div class="avatar" style="background-image:url(img/man.png)"></div>
                Name: <?php echo $name ?>
                <br> Group: <?php echo $group ?>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" style="max-height: 450px; overflow: auto;">
                <div class="inventory">
                    <div class="slot">
                        <div class="item"></div>
                    </div>
                    <div class="slot">
                        <div class="item"></div>
                    </div>
                    <div class="slot">
                        <div class="item"></div>
                    </div>
                    <div class="slot">
                        <div class="item"></div>
                    </div>
                    <div class="slot">
                        <div class="item"></div>
                    </div>
                    <div class="slot">
                        <div class="item"></div>
                    </div>
                    <div class="slot">
                        <div class="item"></div>
                    </div>
                    <div class="slot">
                        <div class="item"></div>
                    </div>
                    <div class="slot">
                        <div class="item"></div>
                    </div>
                </div>



            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
        </div>

</body>
<footer class="feet">
<?php echo "php is working. (c) Pre MWITS 2018 Dev Team " ?>

</footer>
</html>
