<?php
class responder {
	private $message;
	private $success;

	function __construct(){
		$this->message = '';
		$this->success = FALSE;
	}
	
	public function setMessage($msg){
		if($msg){
			$this->message = $msg;
		}
	}

	public function broadcast($results = array()){
		if (count($results) > 0 && is_array($results)) {
			$this->success = TRUE;
			if ($this->message) {
				$results['message'] = $this->message;
			}
			else{
				$this->message = $results['message'];
			}
			
			$payload = array(
				'message' => $this->message,
				'success' => $this->success,
				'data' => $results['data'],
				'meta' =>$results['meta']
			);
			
			header('Content-Type: application/json');
			echo json_encode($payload);
		}
	}
}
?>