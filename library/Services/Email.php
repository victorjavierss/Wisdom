<?php
class Services_Email{

	protected $_to      = NULL;
	protected $_cc      = NULL;
	protected $_bcc     = NULL;
	protected $_from    = NULL;
	protected $_content = NULL;
	protected $_subject = NULL;

	public function setSubject($subject){
		$this->_subject = $subject;
	}
	public function setFrom($from){
		$this->_from = $from;
	}

	public function addTo($to){
		$this->_to[] = $to;
	}

	public function addCC($cc){
		if( !isset($this->_cc[$cc]))
			$this->_cc[$cc] = $cc;
	}

	public function addBCC($bcc){
		$this->_bcc [] = $bcc;
	}

	public function setContet($html){
		$this->_content = str_replace(array('[',']'),array('<','>'), $html);
	}

	public function send(){
		$to = is_array( $this->_to ) ? implode(",", $this->_to) : $this->_to;
		$cc = is_array($this->_cc) ? implode(",", $this->_cc) : NULL;
		$bcc = is_array($this->_bcc) ? implode(",", $this->_bcc) : NULL;

		$subject = $this->_subject;
		$message = $this->_content;

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";

		
		
		// Additional headers
		$headers .= "From:  {$this->_from}\r\n";

		$cc  && $headers .= "Cc: {$cc}\r\n";
		$bcc && $headers .= "Bcc: {$bcc}\r\n";

		$success = FALSE;
		
		$to && $subject && $message && $success = mail($to, $subject, $message, $headers);

		return $success;
	}
}