<?php
  require_once "dbhelper.php";
  session_start();
  if(!isset($_SESSION['id'])){
    header("Location: index.php");
  }
  $id = $_SESSION['id'];
  $addnum = $_POST['mapnum']-1;
  $conn = connect_db();
  $stmt = $conn->query("SELECT * FROM maps WHERE id = $id");
  $row = $stmt->fetch_assoc() or die('ID NOT FOUND');
  $k = $row['bimap'];
  $k = $k | (1 << $addnum);
  if($stmt->fetch_assoc()){
    die('TOO MANY IDs');
  }
  $stmt->free_result();
  $conn->query("UPDATE maps SET bimap = $k WHERE id = $id") or die('UPDATE ERROR');
  close_db($conn);
  header("Location: map_interface.php");
?>
