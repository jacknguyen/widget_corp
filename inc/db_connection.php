<?php
	// set constants since values will not change
	define("DB_SERVER", "localhost");
	define("DB_USER", "widget_cms");
	define("DB_PASS", "secretpassword");
	define("DB_NAME", "widget_corp");

	// 1. Create a database connnection
	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	// Test if connection occured.
	if(mysqli_connect_errno()) {
		die("Failed to connect to MySQL: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")" );
	}
?>