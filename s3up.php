<?php
	require 's3.php';
	S3::setAuth($key, $secret);
//	S3::listBuckets();
	S3::listBuckets();
//	S3::putObject("hello world", 'musicrecur/',  'hello.txt', S3::ACL_PUBLIC_READ);
	echo "done";
?>