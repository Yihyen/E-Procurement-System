<?php

$host = "localhost";
$uname = "root";
$pass = "";
$db_name = "procurementsystem";
$con = mysqli_connect($host, $uname, $pass, $db_name);

$result = mysqli_connect($host, $uname, $pass) or die("Could not connect to database." . mysqli_error());
mysqli_select_db($result, $db_name) or die("Could not select the databse." . mysqli_error());
?>
