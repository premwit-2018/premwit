<html>
<body>
  <form action="hchelper.php" method="post">
    <input type="submit" value="1" name="hcnum"><br>
    <input type="submit" value="2" name="hcnum"><br>
    <input type="submit" value="3" name="hcnum"><br>
    <input type="submit" value="4" name="hcnum"><br>
    <input type="submit" value="5" name="hcnum"><br>
    <input type="submit" value="6" name="hcnum"><br>
    <input type="submit" value="7" name="hcnum"><br>
  </form>
  <p>Current Map Data:<?php
    session_start();
    require_once "dbhelper.php";
    $conn = connect_db();
    $r = $conn->query("SELECT * FROM hc")->fetch_assoc()['bihc'];
    close_db($conn);
    for($i = 0; $i < 7; $i++){
      if($r & (1 << $i)){
        echo '[1]';
      }else{
        echo '[0]';
      }
    }
  ?><p>
</body>
</html>
