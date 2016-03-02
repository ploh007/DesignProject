<?php
	$myfile = fopen("filename.txt", "r") or die("Unable to open file!");
	echo fread($myfile,filesize("filename.txt"));

	// $php_array = array_map('str_getcsv', file('filename.txt'));
	// echo json_encode($php_array);

	fclose($myfile);
?>