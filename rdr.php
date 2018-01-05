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
    $getdata = $conn->prepare("SELECT * FROM user WHERE id = ?");
    $getdata->bind_param('s',$_SESSION['id']);
    $getdata->execute();
    $userdata = $getdata->get_result();
    $row = $userdata->fetch_array(MYSQLI_ASSOC); //all data from db in array sql injection protected

    if($row['status'] == 'admin'){
        header("location: admin.php");
    }
    else if($row['status'] == 'student'){
        header("location: app.php");
    }
    else if($row['status'] == 'staff'){
        header("location: staff.php");
    }    
    else if($row['status'] == 'dev'){
        header("location: adder.php");
    }    
}   
?>