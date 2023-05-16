<?php
function outputJSON($msg, $status = 'error'){
         header('Content-Type: application/json');
         die(json_encode(array(
			'data' => $msg,
			'status' => $status
		)));
	}
?>