<?php

use Aws\S3\S3Client;

require 'vendor/autoload.php';

$config = require('config.php');

//S3
$s3=S3Client::factory([
'credentials' => [
	'key' => $config['s3']['key'],
	'secret' => $config['s3']['secret'],],
	'version' => "latest",
	'region' => "us-east-1",

]
		
	); 