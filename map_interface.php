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
</head>
<body>
  <h1>เก็บแผนที่ได้ที่นี่</h1>
  <form action="maphelper.php" method="post">
    <input type="submit" value="1" name="mapnum"><br>
    <input type="submit" value="2" name="mapnum"><br>
    <input type="submit" value="3" name="mapnum"><br>
    <input type="submit" value="4" name="mapnum"><br>
    <input type="submit" value="5" name="mapnum"><br>
    <input type="submit" value="6" name="mapnum"><br>
    <input type="submit" value="7" name="mapnum"><br>
    <input type="submit" value="8" name="mapnum"><br>
    <input type="submit" value="9" name="mapnum"><br>
  </form>
  <hr>
  <h3>Current Map Data:<?php
    session_start();
    require_once "dbhelper.php";
    if(!isset($_SESSION['id'])){
      header("Location: index.php");
    }
    $id = $_SESSION['id'];
    $conn = connect_db();
    $r = $conn->query("SELECT * FROM maps WHERE id = $id")->fetch_assoc()['bimap'];
    close_db($conn);
    for($i = 0; $i < 9; $i++){
      if($r & (1 << $i)){
        echo '[1]';
      }else{
        echo '[0]';
      }
    }
  ?></h3>
  <h3>สัญลักษณ์</h3>
  <p>[0] หมายถึง ยังไม่ได้เก็บแผนที่</p>
  <p>[1] หมายถึง เก็บแผนที่แล้ว</p>
  <hr>
  <h4>กรณีกดผิด สามารถลบข้อมูลได้ที่นี่</h4>
  <form action="mapdelhelper.php" method="post">
    <input type="submit" value="1" name="mapnum"><br>
    <input type="submit" value="2" name="mapnum"><br>
    <input type="submit" value="3" name="mapnum"><br>
    <input type="submit" value="4" name="mapnum"><br>
    <input type="submit" value="5" name="mapnum"><br>
    <input type="submit" value="6" name="mapnum"><br>
    <input type="submit" value="7" name="mapnum"><br>
    <input type="submit" value="8" name="mapnum"><br>
    <input type="submit" value="9" name="mapnum"><br>
  </form>
</body>
</html>
