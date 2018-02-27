<?php 

namespace Shadow\Mailer;

class Mail 
{

	public $name_field = "Don Bosco";
	public $email_field = "don@gmail.com";
	
	public $from = "noreply@shadow.com";
	public $headers;

	public function send($to, $subject, $message) {
		$this->subject = $subject;
		$this->to = $to;
		$this->body = "From: Don Bosco\n E-Mail: don@gmail.com\n Message:\n $message";
		$headers = "From: noreply@shadow.com\n";

		$mail = mail($this->to, $this->subject, $this->body, $headers);
		
		return $mail;
	}	
}
