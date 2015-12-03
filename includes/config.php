<?php 
date_default_timezone_set('UTC');
$config = array(
		'baseUrl' => str_replace('includes', '', dirname(__FILE__)),
		'year' => date ( 'Y' ),
		'dbUser' => 'orangemantis',
		'dbPassword' => 'mantisorange',
		'dbName' => 'mantisscribe',
		'dbHost' => 'localhost',
		'dbCharSet' => 'utf8'
	);
?>