<?php

function dbConnect(){
	global $connection;
	
	$host = '127.0.0.1';
	$database = 'test';
	$username = 'root';
	$password = '';

	$connection = mysql_connect($host, $username, $password) or die("<p>Could not connect: " . mysql_error());
	mysql_select_db($database);
}

?>