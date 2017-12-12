<?php
function connect_db(){
	return new mysqli("localhost","root","","userdata"); //secret stuff here
}
function close_db($conn){
	$conn->close();
}
?>