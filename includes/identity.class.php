<?php 
class identity {
	private $db;
	private $conString;
	private $config;
	
	public function connect($config, $showErr = FALSE){
		$this->config = $config;
		$this->conString = 'mysql:host=' . $config['dbHost'] . ';dbname=' . $config['dbName'] . ';charset=' . $config['dbCharSet'];
		$this->db = new PDO($this->conString, $config['dbUser'], $config['dbPassword']);
		if ($showErr) {
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}
	
	public function auth($name, $pass){
		$returnVal = FALSE;
		$stmt = 'SELECT user_name, user_password, user_salt FROM users WHERE user_name = :name;';
		$prep = $this->db->prepare($stmt);
		$prep->bindValue(':name', $name, PDO::PARAM_STR);
		$result = $prep->execute();
		if($result){
			$rows = $prep->fetchAll(PDO::FETCH_ASSOC);
			if(count($rows)){
				$row = $rows[0];
				$savedPass = $row['user_password'];
				$salt = $row['user_salt'];
				$saltedPass = $pass . $salt;
				$submittedPass = $this->encrypt($saltedPass);
				if ($savedPass === $submittedPass) {
					$returnVal = TRUE;
				}
			}
		}
		return $returnVal;
	}
	
	public function changePassword($user, $pass, $salt){
		$returnVal = FALSE;
		$pass = $pass . $salt;
		$pass = $this->encrypt($pass);
		$stmt = 'UPDATE users SET user_password = :password, user_salt = :salt WHERE user_name = :name;';
		$prep = $this->db->prepare($stmt);
		$prep->bindValue(':password', $pass, PDO::PARAM_STR);
		$prep->bindValue(':salt', $salt, PDO::PARAM_STR);
		$prep->bindValue(':name', $user, PDO::PARAM_STR);
		$result = $prep->execute();
		if($result){
			$returnVal = TRUE;
		}
		return $returnVal;
	}
	
	public static function encrypt($text){
		return hash('sha256', ($text));
	}
	
	public static function checkAuth(){
		if (isset($_SESSION['auth'])){
			if ($_SESSION['auth'] === TRUE){
				return TRUE;
			}
		}
		return FALSE;
	}
}
?>