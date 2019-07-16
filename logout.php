<?php
session_start();

if (isset($_POST['logout'])) {

	//echo "hello";
	//echo "<br>";
	//echo $_SESSION['token'];
	

session_unset();

session_destroy();
header("location:popup.php");
die();
//echo $_SESSION['token'];
}


?>