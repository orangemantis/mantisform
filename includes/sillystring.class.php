<?php
class SillyString {
	private $chars;
	private $charCount;
	private $str;
	private $strCount;
	private $strLength;
	
	function __construct(){
		$this->chars = array('a',
				'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 
				'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 
				't', 'u', 'v', 'W', 'x', 'y', 'z', 'A', 'B', 
				'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 
				'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 
				'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', 
				'3', '4', '5', '6', '7', '8', '9');
		
		$this->charCount = count($this->chars);
		$this->Str = '';
		$this->strCount = 0;
		$this->strLength = 0;
	}
	public function getRandom($len = 16){

		$this->strLength = $len;
		
		while($this->strCount < $len) {
			$randNo = mt_rand(0, ($this->charCount - 1));
			$this->str .= $this->chars[$randNo];
			$this->strCount++;
		}
		return $this->str;
	}
	
}
?>