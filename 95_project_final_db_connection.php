<?php
$host = "127.0.0.1";
$username    = "root";
$password    = "zjysql";
$db_name = "testdb1";

//create connection
$connection = mysqli_connect($host, $username, $password, $db_name);

//Check if connection Failed
if (mysqli_connect_errno()) {
  die("connection failed: "
      . mysqli_connect_error()
      . " (" . mysqli_connect_errno()
      . ")");
}
?>
