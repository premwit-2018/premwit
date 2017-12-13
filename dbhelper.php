<?php
function connect_db(){
	return new mysqli("localhost","root","","premwit"); //secret stuff here
}
function close_db($conn){
	$conn->close();
}
?>
