<?php
require_once '../includes/config.php';
require_once '../includes/entries.class.php';

if (isset($_GET['format'])){
	$format = $_GET['format'];
}

$entries = new entries($config, true);


if(isset($format)){
	$data = $entries->download($format);
	if ($format === 'json') {
		require_once '../includes/responder.class.php';
		
		$payload = $response = array(
				'success' => 'true',
				'message' => '',
				'data' => $data,
				'meta' => array()
		);
		
		$responder = new responder();
		$responder->setMessage('The entries have been returned successfully.');
		$responder->broadcast($payload);
	}
}
else{
	$data = $entries->download('');
	$fileName = 'entries' . '-' . date('YmdHis');
	$outPutHeader = 'Content-Disposition: attachment; filename="' . $fileName . '.csv"';
	header('Content-type: application/csv');
	header($outPutHeader);
	echo $data;
}

?>