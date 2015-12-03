<?php
require_once '../includes/config.php';
require_once '../includes/responder.class.php';
require_once '../includes/entries.class.php';

$start = $_POST['start'];
$limit = $_POST['limit'];

$entries = new entries($config, true);
$records = $entries->getRecords($start, $limit);
$payload = $response = array(
				'success' => 'true',
				'message' => '',
				'data' => $records['records'],
				'meta' => $records['totalRows']
		);

$responder = new responder();
$responder->setMessage('The entries have been returned successfully.');
$responder->broadcast($payload);
?>