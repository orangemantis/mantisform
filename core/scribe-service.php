<?php 
	require_once '../includes/config.php';
	require_once '../includes/responder.class.php';
	require_once '../includes/entries.class.php';
	
	$data = $_POST;
	$entries = new entries($config, TRUE);
	$result = $entries->addRecord($data);
	
	if ($result) {
			
		$response = array(
				'success' => 'true',
				'message' => 'The information has been saved.',
				'data' => array(),
				'meta' => array()
		);
	}
	else {
		$response = array(
				'success' => 'false',
				'message' => 'Uh-oh something went wrong, please try again.',
				'data' => array(),
				'meta' => array()
		);
	}
	
	$resp = new responder();
	$resp->broadcast($response);
?>