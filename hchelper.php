<?php
  require_once "dbhelper.php";
  session_start();
  $id = $_SESSION['id'];
  $addnum = $_POST['hcnum'];
  $conn = connect_db();
  $stmt = $conn->query("SELECT * FROM hc WHERE id = $id");
  $row = $stmt->fetch_array(MYSQLI_FETCH_ASSOC) or die('ID NOT FOUND');
  $k = $row['bihc'];
  $k = $k | (1 << $addnum);
  if($stmt->fetch_array(MYSQLI_FETCH_ASSOC)){
    die('TOO MANY IDs');
  }
  $stmt->free_result();
  $conn->query("UPDATE hc SET bihc = $k WHERE id = $id") or die('UPDATE ERROR');
  close_db($conn);
?>
