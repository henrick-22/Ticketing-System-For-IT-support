<?php
/*database credentials*/
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tickets');

/* attemp to connect to MYSQL database*/
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

/*check if succesful to MYSQL database*/
if($link === false){
	die("ERROR: could not connect" . mysqli_connect_error());
}

//time zone
date_default_timezone_set('Asia/Manila');
?>