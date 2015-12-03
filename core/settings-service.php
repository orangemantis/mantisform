<?php
	session_start();
	$sessID = session_id();
	
	require_once '../includes/config.php';
	require_once '../includes/settings.class.php';
	require_once '../includes/responder.class.php';
	require_once '../includes/identity.class.php';
	
	$settings = new settings($config, TRUE);
	$responder = new responder();
	
	if(isset($_POST['operation']) && identity::checkAuth()){
		if($_POST['operation'] === 'update'){
			$saved = $settings->setSettings($_POST);
			$message = $saved ? 'Settings saved.' : 'Uh-oh something went wrong, please try again.';
			$success = $saved ? 'true' : 'false';
			$response = array(
					'message' => $message,
					'success' => $success,
					'data' => array(),
					'meta' => ''
			);
			
		}
		elseif(identity::checkAuth()){
			$data = $settings->getSettings();
			$message = $data ? 'Success, settings retreived.' : 'Uh-oh something went wrong, please try again.';
			$success = $data ? 'true' : 'false';
			$response = array(
					'message' => $message,
					'success' => $success,
					'data' => $data,
					'meta' => ''
			);
		}
		$responder->broadcast($response);
	}
?>