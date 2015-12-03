<?php 
class settings{
	private $db;
	private $config;
	private $conString;
	
	function __construct($config, $showErr = FALSE){
		$this->config = $config;
		$this->conString = 'mysql:host=' . $config['dbHost'] . ';dbname=' . $config['dbName'] . ';charset=' . $config['dbCharSet'];
		$this->db = new PDO($this->conString, $config['dbUser'], $config['dbPassword']);
		if ($showErr) {
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}
	
	public function getSettings(){
		$stmt = 'SELECT
		campaign_name,
		campaign_date,
		campaign_location,
		campaign_contact,
		campaign_email,
		campaign_phone,
		campaign_message,
		campaign_terms,
		campaign_note,
		campaign_brand,
		layout_signup
		FROM settings WHERE campaign_id = 1;';
		
		$query = $this->db->query($stmt);
		$result = $query->execute();
		$rows = $query->fetchAll(PDO::FETCH_ASSOC);
		if ($result){
			return $rows[0];
		}
		else{
			return array();
		}
	}
	
	public function setSettings($data){
		//Reform date from front-end
		$date = $data['campaign_date'];
		$date = explode('-', $date);
		$date = $date[0] . '-' . $date[1] . '-' . $date[2];
		
		$stmt = 'UPDATE settings SET
		campaign_name = :name,
		campaign_date = :date,
		campaign_location = :location,
		campaign_contact = :contact,
		campaign_email = :email,
		campaign_phone = :phone,
		campaign_message = :message,
		campaign_terms = :terms,
		campaign_note = :note,
		campaign_brand = :brand,
		layout_signup = :signup
		WHERE settings.campaign_id = 1;';
	
		$prep = $this->db->prepare($stmt);
		$prep->bindValue(':name', $data['campaign_name'], PDO::PARAM_STR);
		$prep->bindValue(':date', $data['campaign_date'], PDO::PARAM_STR);
		$prep->bindValue(':location', $data['campaign_location'], PDO::PARAM_STR);
		$prep->bindValue(':contact', $data['campaign_contact'], PDO::PARAM_STR);
		$prep->bindValue(':email', $data['campaign_email'], PDO::PARAM_STR);
		$prep->bindValue(':phone', $data['campaign_phone'], PDO::PARAM_STR);
		$prep->bindValue(':message', $data['campaign_message'], PDO::PARAM_STR);
		$prep->bindValue(':terms', $data['campaign_terms'], PDO::PARAM_STR);
		$prep->bindValue(':note', $data['campaign_note'], PDO::PARAM_STR);
		$prep->bindValue(':brand', $data['campaign_brand'], PDO::PARAM_STR);
		$prep->bindValue(':signup', (int)$data['layout_signup'], PDO::PARAM_STR);
		
		$result = $prep->execute();
		if ($result) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	
	}
?>