<html>
<head>
  <meta charset="utf-8">
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
