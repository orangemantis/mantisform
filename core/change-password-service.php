<?php 
	session_start();
	require_once '../includes/config.php';
	require_once '../includes/identity.class.php';
	require_once '../includes/responder.class.php';
	require_once '../includes/sillystring.class.php';
	
	$identity = new identity();
	$responder = new responder();
	$sstring = new SillyString();
	
	$response = array(
			'message' => 'The password could not be changed.',
			'success' => FALSE,
			'data' => array('success' =>'false'),
			'meta' => ''
	);
	
	if(isset($_POST['user']) && isset($_POST['current_password']) && isset($_POST['new_password'])){
		$user = $_POST['user'];
		$password = $_POST['current_password'];
		$newPassword = $_POST['new_password'];
		$identity->connect($config, TRUE);
		$auth = $identity->auth($user, $password);
		if($auth){
			$salt = $sstring->getRandom();
			$result = $identity->changePassword($user, $newPassword, $salt);
			if ($result){
				$response = array(
					'message' => 'The password has successfully been changed.',
					'success' => TRUE,
					'data' => array('success' =>'true'),
					'meta' => ''
				);
			}
		}
	}
	$responder->broadcast($response);
?>