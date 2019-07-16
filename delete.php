<?php
session_start();
 ?>
<?php

use Aws\S3\S3Client;  

use Aws\Exception\AwsException; 

  //echo $_SESSION['token'];

$use = $_SESSION['user'];
 $len = strlen($use);
//echo $use;
//echo $len;

if(isset($_SESSION['token'])){
require 'app/start.php';

//echo $_SESSION['token'];

$objects  = $s3->getIterator('ListObjects', [
	'Bucket' => $config['s3']['bucket'],
	'Prefix' => $use
	]);

	//var_dump($objects);

  //DOWNLOAD


if(isset($_POST['download'])){
	//echo "hello";
	//echo $_POST['id'];
	//echo $_POST["download"];

	$abc = ($_POST['id']);
	
   //var_dump($abc);

	require 'vendor/autoload.php';



$config = require 'app/config.php';

$s3Client = S3Client::factory([
    'credentials' => [
	'key' => $config['s3']['key'],
	'secret' => $config['s3']['secret'],],
    'region' => 'us-east-1',
    'version' => 'latest',
]);



	//echo $abc;
	$cmd = $s3Client->getCommand('GetObject', [
    'Bucket' => $config['s3']['bucket'],
    'Key' =>$abc
]);

$request = $s3Client->createPresignedRequest($cmd, '+200 seconds');

//var_dump($request);

$presignedUrl = (string)$request->getUri();

//echo $presignedUrl;

header("Location: $presignedUrl"); 

}

//DELETE

elseif (isset($_POST['delete'])){
	//echo "helllllo";
	//echo $_POST['id'];

	$abc = ($_POST['id']);
//echo $abc;


	require 'vendor/autoload.php';



$config = require 'app/config.php';

$s3Client = S3Client::factory([
    'credentials' => [
	'key' => $config['s3']['key'],
	'secret' => $config['s3']['secret'],],
    'region' => 'us-east-1',
    'version' => 'latest',
]);


$s3->deleteObject([
    'Bucket' => $config['s3']['bucket'],
    'Key'    => $abc
]);


//$message = $abc . "deleted successfully";
//echo "<script type='text/javascript'>alert('$message');</script>";


}


//UPLOAD

elseif (isset($_FILES['file'])) {

	$file = $_FILES['file'];
	//var_dump($file);

	// File details
	$name = $file['name'];
	//var_dump($name);
	$tmp_name = $file['tmp_name'];

	$extension = explode('.', $name);    
	//var_dump($extension); 
	$extension = strtolower(end($extension));
	//var_dump($extension); //will show extension of the file

	//temp details
	$key = md5(uniqid());
	$tmp_file_name = "{$key}.{$extension}";
	$tmp_file_path = "files/{$tmp_file_name}";

	//var_dump($tmp_file_path); shows the name of temporary file to be uploade

	//move the file
	//move_uploaded_file(filename, destination);


	move_uploaded_file($tmp_name,$tmp_file_path); //this will upload file to the directory files but we have to upload it on the s3

	try {

			$s3->putObject([
			'Bucket' => $config['s3']['bucket'], //this will access the bucket name from the config.php
			'Key' => $use."/{$name}", // this will create a uploads object under which the file will be get uploaded with its original name on S3 BUCKET
			//'Body' => fopen($tmp_file_path, 'r'), // source of the file it will open file in read mode
			'ACL' => 'public-read'  //acees control level of the users
		]);


		unlink($tmp_file_path); //removal of temporary file on the server
		
	    
	    }
	catch(S3Exception $e) {
		die("there was an error uploading that file.");
						  }



   }

}

else
{
	header('location:cogLogin.php');
	die();
}

 ?>



 <!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0;">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
	
body {font-family: Arial, Helvetica, sans-serif;}
.form_div {border: 3px solid #f1f1f1; align: center; margin: auto;}


.form_div span.FILES {
  float: left;
  padding-top: 5px;
  padding-bottom: 5px;
  padding-left: 210px;
  padding-right: 210px;
  background-color: skyblue;
}

 .btn {
  background-color: DodgerBlue;
  border: none;
  color: white;
  padding: 12px 30px;
  cursor: pointer;
  font-size: 20px;
  border-radius: 10px;
}

/* Darker background on mouse-over */
 .btn:hover {
  background-color: RoyalBlue;
}


</style>
</head>
<body>
	<form class="form_div"  style="background-color:#f1f1f1">
	<table align="center">
		
			<tr>

				<td><span class="FILES"><h3>FILES PRESENT</h3></span></td>
			</tr>
		
		</table>
		
</form>
<table align="center">
		<tbody>
			<?php foreach ($objects as $object): ?> 
			<!--<?php var_dump($object); ?>-->
			<tr>
				<!--<td>File name</td>-->
				<td ><?php $abc = $object['Key']; echo substr($abc,$len+1); ?></td>
				<!--<td>Download link</td>-->
         	<td> <form method="POST">
         		<input type="hidden" name="id" value='<?php echo $abc ?>'>
         		<!-- <input type="submit" class="btn" name="download" value="download">-->
         		<button input type="submit" name="download" class="btn"><i class="fa fa-download"></i>Download</button>

				</form></td>
				<td><form method="POST">
					<input type="hidden" name="id" value='<?php echo $abc ?>'>
					<!--<input type="submit" name="delete" value="delete">-->
					<button class="btn" input type="submit" name="delete"><i class="fa fa-trash"></i>Delete</button>
				</form></td>
      </tr>
			
		<?php endforeach; ?>
		</tbody>

	</table>

<table align="right">
		<tr>
				
			</tr>
			<tr>
				<td ><form action="logout.php" method="POST" >
					<input type="hidden" name="logout" value="logout">
					<button class="btn" input type="submit" name="logout" value="logout"><i class="fa fa-close"></i>Logout</button>
				</form></td>
			</tr>
	</table>
	
		



<table align="left">
	<tr><td><form method="post" enctype="multipart/form-data" >
		<input required class="btn" type="file" name="file" >
		<button input type="submit" value="Upload" class="btn"><i class="fa fa-folder"></i>upload</button>
	</form></td></tr>
</table>
	

</body>
</html>