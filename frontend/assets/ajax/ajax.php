<?php
	/**============================
	* Simple AJAX Script to fetch
	* CSV Data and encode as JSON
	* @author Paul Loh
	* @author Jordan Hatcher
	============================**/
	$php_array = array_map('str_getcsv', file('../../filename.txt'));
	echo json_encode($php_array);
?>