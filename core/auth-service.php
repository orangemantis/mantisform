<?php
	session_start();
	require_once '../includes/config.php';
	require_once '../includes/identity.class.php';
	require_once '../includes/responder.class.php';

	$identity = new identity();
	$responder = new responder();
	
	$_SESSION['auth'] = FALSE;
	
	$response = array(
			'message' => 'User could not be authorized, any logged in users have been logged out.',
			'success' => FALSE,
			'data' => array(),
			'meta' => ''
	);
	
	if(isset($_POST['user']) && $_POST['password']){
		$user = $_POST['user'];
		$password = $_POST['password'];
		$identity->connect($config, TRUE);
		$auth = $identity->auth($user, $password);
		if($auth){
			$_SESSION['auth'] = TRUE;
			$_SESSION['user'] = $user;
			$response = array(
				'message' => 'User authorized.',
				'success' => TRUE,
				'data' => array(),
				'meta' => ''
			);
		}
	}
	
	if(isset($_GET['logout'])){
		if($_GET['logout'] === 'true'){
			unset($_SESSION['auth']);
			unset($_SESSION['user']);
			$response = array(
				'message' => 'The user is logged out.',
				'success' => TRUE,
				'data' => array(),
				'meta' => ''
			);
		}
		else{
			$response = array(
				'message' => 'The user is not logged in.',
				'success' => TRUE,
				'data' => array(),
				'meta' => ''
			);
		}
	}
	$responder->broadcast($response);
?>