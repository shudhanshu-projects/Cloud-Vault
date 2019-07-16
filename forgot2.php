
<?php  
include "vendor/autoload.php";
use Aws\CognitoIdentity\CognitoIdentityClient;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\Sts\StsClient;



$config = require('app/config.php');


$s3=CognitoIdentityProviderClient::factory([
	'credentials' => [
	'key' => $config['s3']['key'],
	'secret' => $config['s3']['secret'],],
	'version' => "latest",
	'region' => "us-east-1",

]
		
	); 

if(isset($_POST['action']))
{

if(!empty($_POST['username']) && !empty($_POST['code']) && !empty($_POST['password']))
{

try{
  $s3->confirmForgotPassword([
  'ClientId' => '2e3tr0g2j0ovenabs3j2cr5q2k',
  'Username' => $_POST['username'],
  'ConfirmationCode' => $_POST['code'],
  'Password' => $_POST['password'], 
]);
}

catch(Exception $e)

{
  header("Location:forgot2pop.php");
  die();
}



    header("Location:forgot2pop2.php");
    die();

}




}


?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
.form_div {border: 3px solid #f1f1f1; align: center; margin: 25px 700px 800px 700px;}

.form_div input[type=text],.form_div input[type=PASSWORD] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

 .form_div input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

.form_div input[type=submit]:hover {
  opacity: 0.8;
}


.form_div .container {
  padding: 16px;
}

.form_div .imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

.form_div img.avatar {
  width: 30%;
  border-radius: 50%;
}

.form_div span.already {
  align-content: center;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */

@media only screen and (min-width:700px) and (max-width:995px)
{


  .form_div {border: 3px solid #f1f1f1; align: center; margin: auto;}

.form_div input[type=text],.form_div input[type=PASSWORD] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

 .form_div input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

.form_div input[type=submit]:hover {
  opacity: 0.8;
}


.form_div .container {
  padding: 16px;
}

.form_div .imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

.form_div img.avatar {
  width: 30%;
  border-radius: 50%;
}

.form_div span.already {
  align-content: center;
  padding-top: 16px;
}
}

@media only screen and (min-width:400px) and (max-width:699px)
{


  .form_div {border: 3px solid #f1f1f1; align: center; margin: auto;}

.form_div input[type=text],.form_div input[type=PASSWORD] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

 .form_div input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

.form_div input[type=submit]:hover {
  opacity: 0.8;
}


.form_div .container {
  padding: 16px;
}

.form_div .imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

.form_div img.avatar {
  width: 30%;
  border-radius: 50%;
}

.form_div span.already {
  align-content: center;
  padding-top: 16px;
}
}

@media only screen and (min-width:100px) and (max-width:399px)
{


  .form_div {border: 3px solid #f1f1f1; align: center; margin: auto;}

.form_div input[type=text],.form_div input[type=PASSWORD] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

 .form_div input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

.form_div input[type=submit]:hover {
  opacity: 0.8;
}


.form_div .container {
  padding: 16px;
}

.form_div .imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

.form_div img.avatar {
  width: 30%;
  border-radius: 50%;
}

.form_div span.already {
  align-content: center;
  padding-top: 16px;
}
}


}}
</style>
</head>
<body>


	<h2 align="center">Forgot Password</h2>
  <div class="form_div">
	<form method="POST">

		<div class="imgcontainer">
    <img src="forgot2.png" alt="Avatar" class="avatar">
  </div>
		<div class="container">
     
		<label for="username"><b>Username</b></label>	
		<input type="text" placeholder="enter username" name="username" required>

		<label for="code"><b>Code</b></label>
		<input type="text" placeholder="enter the code" name="code" required>
    <label for="password"><b>New Password</b></label>
    <input type="PASSWORD" placeholder="enter new password" name="password" required pattern="^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" title="Minimum of 8 characters. Should have at least one special character and one number and one LowerCase Letter and one UpperCase Letter.">
		<input type="hidden" name="action" value="Verify"><br>
		<input type="submit" value="Verify">
	</div>

  <div class="container" style="background-color:#f1f1f1 ">
    <span class="already">Refer your mail inbox for the verfication code.</span>
  </div>
	</form>
</div>

</body>
</html>





