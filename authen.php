<?php
require_once "dbhelper.php";
$user = $_POST['username'];
$password = $_POST['password'];
$conn = connect_db();
if(!$conn){
	echo "<p> Connection Error </p>";
	close_db($conn);
	die();
}
$getuser = $conn->prepare("SELECT * FROM users WHERE username = ?");
$getuser->bind_param('s',$user);
$getuser->execute();
$userdata = $getuser->get_result();
$row = $userdata->fetch_array(MYSQLI_ASSOC); //all data from db in array sql injection protected

if (password_verify($password, $row['password'])) {
	setcookie("id",$row['username'],time()+10800);
    echo 'Success redirecting ...';
    header('Location: app.php');
    exit();
}
else{
    echo "wronggg";
    header('Location: index.php');
}

?>
<html>
<h1>What are you doing here dude</h1>

</html>
