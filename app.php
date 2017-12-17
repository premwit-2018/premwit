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
    <script src="node_modules/js-cookie/src/js.cookie.js"></script>
    <link rel="stylesheet" href="node_modules/frontend/app-style.css">
    <link rel="stylesheet" href="node_modules/animate.css/animate.min.css">
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
        }

        body{
            padding: 20px;
        }
        .item-modal{
            padding: 20px;
            position: absolute;
            width: 100vw;
            min-height: 50vh;
            bottom: 0;
            left: 0;
            display:none;
            z-index: 99;
            background: white;
        }
        .overlay{
            z-index: 98;
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: black;
            opacity: 0.4;
            left:0;
            bottom:0;
            display: none;
        }
        .operation{
            width: 100%;
        }
    </style>
</head>

<body>
<div class="overlay"></div>
<div class="item-modal">
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-4">
            <img src="/img/test.jpg" width="100px" alt="">
        </div>
        <div class="col-8" style="margin: auto;">
            Name: Something <br>
            Attack: 200
        </div>
    </div>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. At labore, maxime accusamus sed velit voluptatum. Tenetur fuga maxime recusandae error quisquam velit distinctio dolorem eius nesciunt eaque, sint. At, vitae.
    <br>
    <div class="row" style="margin-top: 20px;">
        <div class="col-6" >
            <button type="button" class="operation btn btn-outline-success">Use</button>
        </div>
        <div class="col-6">
            <button id="close" type="button" class="operation btn btn-outline-danger">Close</button>
        </div>
    </div>    
    
</div>
    
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
                <br> Group: <?php echo $group ?><br>
                <button type="button" class="logout btn btn-outline-primary" style="margin-top:20px;">Log Out</button>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" >
<table class="table table-striped">
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
      <td><button id="1" class="item btn btn-success" type="submit">Use</button></td>
    </tr>
    <tr>
      <td>Larry</td>
      <td>Weapon</td>
      <td><button id="2" class="item btn btn-success" type="submit">Use</button></td>
    </tr>
  </tbody>
</table>

            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>

        </div>

</body>
<script>
$('.item').click(function() {
    $(this).attr('id');
    console.log("fuck")
    $('.item-modal').fadeIn(200);
    $('.overlay').fadeIn(200);
});
$('.overlay').click(function(){
    $('.item-modal').fadeOut(200);
    $('.overlay').fadeOut(200);
});
$('#close').click(function(){
    $('.item-modal').fadeOut(200);
    $('.overlay').fadeOut(200);
});
</script>
<footer class="feet">
<?php echo "php is working. (c) Pre MWITS 2018 Dev Team " ?>

</footer>
</html>
