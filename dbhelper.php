<?php
function connect_db(){
	return new mysqli("localhost","root","","login"); //secret stuff here
}
function close_db($conn){
	$conn->close();
}
?>
