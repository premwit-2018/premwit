<?php
require_once "values.php";
function connect_db(){
	return new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB,MYSQL_PORT);
}
function close_db($conn){
	$conn->close();
}
?>