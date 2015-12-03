<?php
class entries{
	private $items;
	private $message;
	private $db;
	private $conString;
	private $config;
	
	function __construct($config, $showErr = FALSE){
		$this->items = array();
		$this->message = '';
		$this->config = $config;
		$this->conString = 'mysql:host=' . $config['dbHost'] . ';dbname=' . $config['dbName'] . ';charset=' . $config['dbCharSet'];
		$this->db = new PDO($this->conString, $config['dbUser'], $config['dbPassword']);
		if ($showErr) {
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}

	public function addRecord($data){
		$stmt = 'INSERT INTO subscribers (
				first_name, 
				middle_initial,
				last_name, 
				email,
				mobile_phone,
				home_phone,
				address1, 
				address2, 
				city, 
				state, 
				zip_pc, 
				country, 
				notes, 
				subscribed
			)
			VALUES (
				:firstName,
				:middleInitial,
				:lastName,
				:email,
				:mobilePhone,
				:homePhone,
				:address1,
				:address2,
				:city,
				:state,
				:zipPc,
				:country,
				:notes,
				:subscribed
			);';
		
		$firstName = isset($data['first_name']) ? $data['first_name'] : "";
		$middleInitial = isset($data['middle_initial']) ? $data['middle_initial'] : "";
		$lastName = isset($data['last_name']) ? $data['last_name'] : "";
		$email = isset($data['email']) ? $data['email'] : "";
		$mobilePhone = isset($data['mobile_phone']) ? $data['mobile_phone'] : "";
		$homePhone = isset($data['home_phone']) ? $data['home_phone'] : "";
		$address1 = isset($data['address1']) ? $data['address1'] : "";
		$address2 = isset($data['address2']) ? $data['address2'] : "";
		$city = isset($data['city']) ? $data['city'] : "";
		$state = isset($data['state']) ? $data['state'] : "0";
		$zip = isset($data['zip_pc']) ? $data['zip_pc'] : "";
		$country = isset($data['country']) ? $data['country'] : "0";
		$notes = isset($data['notes']) ? $data['notes'] : "";
		$subscribed = isset($data['subscribed']) ? $data['subscribed'] : "0";
		
		$prep = $this->db->prepare($stmt);
		$prep->bindValue(':firstName', $firstName, PDO::PARAM_STR);
		$prep->bindValue(':middleInitial', $middleInitial, PDO::PARAM_STR);
		$prep->bindValue(':lastName', $lastName, PDO::PARAM_STR);
		$prep->bindValue(':email', $email, PDO::PARAM_STR);
		$prep->bindValue(':mobilePhone', $mobilePhone, PDO::PARAM_STR);
		$prep->bindValue(':homePhone', $homePhone, PDO::PARAM_STR);
		$prep->bindValue(':address1', $address1, PDO::PARAM_STR);
		$prep->bindValue(':address2', $address2, PDO::PARAM_STR);
		$prep->bindValue(':city', $city, PDO::PARAM_STR);
		$prep->bindValue(':state', (int)$state, PDO::PARAM_INT);
		$prep->bindValue(':zipPc', $zip, PDO::PARAM_STR);
		$prep->bindValue(':country', (int)$country, PDO::PARAM_STR);
		$prep->bindValue(':notes', $notes, PDO::PARAM_STR);
		$prep->bindValue(':subscribed', (int)$subscribed, PDO::PARAM_STR);
		
		$result = $prep->execute();
		if ($result) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	public function getRecords($start = 0, $limit = 25){
		$totalStmt = $this->db->query('SELECT COUNT(subscriber_id) as total_rows FROM subscribers;');
		$totalRows = $totalStmt->fetchAll(PDO::FETCH_ASSOC);
		$totalRows = $totalRows[0];
		$limit = (int)$limit;
		if ($limit === 0) {
			$limit = 25;
		}
		$start = (int)$start;
		$stmt = 'SELECT subscriber_id, first_name, last_name, email, mobile_phone FROM subscribers  ORDER BY subscriber_id LIMIT :limit OFFSET :offset;';
		$prep = $this->db->prepare($stmt);
		$prep->bindValue('limit', $limit, PDO::PARAM_INT);
		$prep->bindValue('offset', $start, PDO::PARAM_INT);
		
		$result = $prep->execute();
		$rows = $prep->fetchAll(PDO::FETCH_ASSOC);
		
		if($result){
			return array(
					'totalRows' => $totalRows, 
					'records' => $rows
					);
		}
		else {
			return array(
					'totalRows'=>0,
					'records' =>array()
					);
		}
		
	}
	private function csvify($data, $delim){
		$csv = '';
		$header = '';
		$columns = 0;
		$counter = 0;
		$headerDone = FALSE;
		
		foreach($data as $d){
			if (!$columns) {
				$columns = count($d);
			}
			if ($counter) {
				$counterOn = FALSE;
			}
			foreach($d as $field => $val){
		
				if (!$headerDone) {
					if ($counter < $columns) {
						$header .= $field;
					}
					if ($counter < ($columns - 1)) {
						$header .= $delim;
					}
					if ($counter === ($columns - 1)) {
						$header .= PHP_EOL;
						$headerDone = TRUE;
					}
				}
				
				//remove delimiter from db text
				$val = str_replace(',', ' ', $val);
		
				if ($counter < $columns) {
					$csv .= $val;
				}
				if ($counter < ($columns -1)) {
					$csv .= $delim;
				}
				if ($counter === ($columns - 1)) {
					$csv .= PHP_EOL;
				}
				$counter++;
				if ($counter === $columns) {
					$counter = 0;
				}
			}
		}
		$csv = $header . $csv;
		$csv = trim($csv);
		return $csv;
	}
	public function download($format){
		$stmt = 'SELECT * FROM subscribers;';
		$query = $this->db->query($stmt);
		$rows = $query->fetchAll(PDO::FETCH_ASSOC);
		if ($format === 'json'){
			$data = $rows;
		}
		else{
			$data = $this->csvify($rows, ',');
		}
		return $data;
		
	}
}
/*
$entries = new entries($config, TRUE);
$records = $entries->getRecords();
echo 'ok';
print_f($records);*/
?>