<?php
alert("Invalid Code or Email is already taken!!!");

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<p><a href="verification.php">Click here</a> to Verify again.</p>
</body>
</html>