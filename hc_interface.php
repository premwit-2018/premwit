<html>
<head>
  <meta charset="utf-8">
</head>
<body>
  <h1>ทำลาย HC ที่นี่</h1>
  <form action="hchelper.php" method="post">
    <input type="submit" value="1" name="hcnum"><br>
    <input type="submit" value="2" name="hcnum"><br>
    <input type="submit" value="3" name="hcnum"><br>
    <input type="submit" value="4" name="hcnum"><br>
    <input type="submit" value="5" name="hcnum"><br>
    <input type="submit" value="6" name="hcnum"><br>
    <input type="submit" value="7" name="hcnum"><br>
  </form>
  <hr>
  <h3>Current HC Data:<?php
    session_start();
    require_once "dbhelper.php";
    $conn = connect_db();
    $r = $conn->query("SELECT * FROM hc")->fetch_assoc()['bihc'];
    close_db($conn);
    for($i = 0; $i < 7; $i++){
      if($r & (1 << $i)){
        echo '[0]';
      }else{
        echo '[1]';
      }
    }
  ?></h3>
  <h3>สัญลักษณ์</h3>
  <p>[0] หมายถึง โดนทำลายแล้ว</p>
  <p>[1] หมายถึง ยังไม่โดนทำลาย</p>
  <hr>
  <h4>กรณีกดผิด สามารถเสกกลับมาใหม่ได้ที่นี่</h4>
  <form action="hcdelhelper.php" method="post">
    <input type="submit" value="1" name="hcnum"><br>
    <input type="submit" value="2" name="hcnum"><br>
    <input type="submit" value="3" name="hcnum"><br>
    <input type="submit" value="4" name="hcnum"><br>
    <input type="submit" value="5" name="hcnum"><br>
    <input type="submit" value="6" name="hcnum"><br>
    <input type="submit" value="7" name="hcnum"><br>
  </form>
</body>
</html>
