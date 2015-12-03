<?php 
class forms {
	private $states;
	private $db;
	private $conString;
	private $config;
	
	function __construct($config, $showErr = FALSE){
		$this->config = $config;
		$this->conString = 'mysql:host=' . $config['dbHost'] . ';dbname=' . $config['dbName'] . ';charset=' . $config['dbCharSet'];
		$this->db = new PDO($this->conString, $config['dbUser'], $config['dbPassword']);
		if ($showErr) {
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}
	
	public function createStateOptions($country = 1) {
		$stmt = 'SELECT * FROM states WHERE state_country = ' . $country . ';';
		$results = $this->db->query($stmt);
		$rows = $results->fetchAll(PDO::FETCH_ASSOC);
		
		$br = PHP_EOL;
		$options = '';
		$optTmpl = '<option value="%s">%s</option>' . $br;
		
		foreach ($rows as $row){
			$stVal = $row['state_abbrv'] . ' - ' . $row['state_name'];
			$options .= sprintf ( $optTmpl, $row['state_id'], $stVal );
		}
		
		unset($row);
		return $options;
	}
}

/*
$forms = new forms($config, TRUE);
$states = $forms->createStateOptions();
echo '<pre>';
print_r($states);
echo '</pre>';
*/
?>