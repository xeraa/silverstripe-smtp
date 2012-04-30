<?php


require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'class.phpmailer.php');


class SmtpMailer extends Mailer {
	var $mailer = null;


	function __construct($mailer = null){
		parent::__construct();
		$this->mailer = $mailer;
	}


	protected function instanciate(){
		if($this->mailer == null){
			$this->mailer = new PHPMailer(true);
			$this->mailer->IsSMTP();
			$this->mailer->CharSet = defined('SMTPMAILER_CHARSET_ENCODING') ? SMTPMAILER_CHARSET_ENCODING : "utf-8";
			$this->mailer->Host = defined('SMTPMAILER_SMTP_SERVER_ADDRESS') ? SMTPMAILER_SMTP_SERVER_ADDRESS : "localhost";
			$this->mailer->Port = defined('SMTPMAILER_SMTP_SERVER_PORT') ? SMTPMAILER_SMTP_SERVER_PORT : 25;
			$this->mailer->SMTPSecure = defined('SMTPMAILER_USE_SECURE_CONNECTION') ? strtolower( SMTPMAILER_USE_SECURE_CONNECTION ) : '';
			$this->mailer->SMTPAuth = defined('SMTPMAILER_DO_AUTHENTICATE') ? SMTPMAILER_DO_AUTHENTICATE : false;
			if($this->mailer->SMTPAuth){
				$this->mailer->Username = defined('SMTPMAILER_USERNAME') ? SMTPMAILER_USERNAME : "username";
				$this->mailer->Password = defined('SMTPMAILER_PASSWORD') ? SMTPMAILER_PASSWORD : "password";
			}
			$this->mailer->SMTPDebug = defined('SMTPMAILER_DEBUG_MESSAGING_LEVEL') ? SMTPMAILER_DEBUG_MESSAGING_LEVEL : 0;
			$this->mailer->SetLanguage(defined('SMTPMAILER_LANGUAGE_OF_MESSAGES') ? SMTPMAILER_LANGUAGE_OF_MESSAGES : 'en');
		}
	}


	/* Overwriting SilverStripe's Mailer function */
	function sendPlain($to, $from, $subject, $plainContent, $attachedFiles = false, $customheaders = false){
		$this->instanciate();
		$this->mailer->IsHTML(false);
		$this->mailer->Body = $plainContent;
		$this->sendMailViaSmtp($to, $from, $subject, $attachedFiles, $customheaders, false);
	}


	/* Overwriting SilverStripe's Mailer's function */
	function sendHTML($to, $from, $subject, $htmlContent, $attachedFiles = false, $customheaders = false, $plainContent = false, $inlineImages = false){
		$this->instanciate();
		$this->mailer->IsHTML( true );
		if( $inlineImages ) {
			$this->mailer->MsgHTML( $htmlContent, Director::baseFolder() );
		}
		else {
			$this->mailer->Body = $htmlContent;
			if( empty( $plainContent ) ) $plainContent = trim( Convert::html2raw( $htmlContent ) );
			$this->mailer->AltBody = $plainContent;
		}
		$this->sendMailViaSmtp( $to, $from, $subject, $attachedFiles, $customheaders, $inlineImages );
	}


	protected function sendMailViaSmtp($to, $from, $subject, $attachedFiles = false, $customheaders = false, $inlineImages = false){
		if($this->mailer->SMTPDebug > 0){
			echo "<em><strong>*** Debug mode is on</strong>, printing debug messages and not redirecting to the website:</em><br />";
		}
		$msgForLog = "\n*** The sender was : $from\n*** The message was :\n{$this->mailer->AltBody}\n";

		try {
			$this->buildBasicMail($to, $from, $subject);
			$this->addCustomHeaders($customheaders);
			$this->attachFiles($attachedFiles);
			$this->mailer->Send();

			if($this->mailer->SMTPDebug > 0){
				echo "<em><strong>*** E-mail to $to has been sent.</strong></em><br />";
				echo "<em><strong>*** The debug mode blocked the process</strong> to avoid the url redirection. So the CC e-mail is not sent.</em>";
				die();
			}

		} catch(phpmailerException $pe){
			$this->handleError($pe->errorMessage(), $msgForLog);
		} catch(Exception $e){
			$this->handleError($e->getMessage(), $msgForLog);
		}
	}


	function handleError($msg, $msgForLog ){
		echo $msg;
		Debug::log($msg . $msgForLog);
		die();
	}


	protected function buildBasicMail($to, $from, $subject){
		if(preg_match('/(\'|")(.*?)\1[ ]+<[ ]*(.*?)[ ]*>/', $from, $from_splitted)){ //If $from countains a name, e.g. "My Name" <foo@gmail.com>
			$this->mailer->SetFrom($from_splitted[3], $from_splitted[2]);
		} else {
			$this->mailer->SetFrom($from);
		}

		$to = validEmailAddr($to);
		$this->mailer->ClearAddresses();
		$this->mailer->AddAddress($to, ucfirst(substr($to, 0, strpos($to, '@')))); //For the recipient's name, the string before the @ from the e-mail address is used
		$this->mailer->Subject = $subject;
	}


	protected function addCustomHeaders($headers){
		if(($headers == null) || !is_array($headers)){
			$headers = array();
		}
		if(!isset($headers["X-Mailer"])){
			$headers["X-Mailer"] = X_MAILER;
		}
		if(!isset($headers["X-Priority"])){
			$headers["X-Priority"] = 3;
		}

		$this->mailer->ClearCustomHeaders();
		foreach($headers as $header_name => $header_value){
			$this->mailer->AddCustomHeader($header_name . ':' . $header_value);
		}
	}


	protected function attachFiles($attachedFiles){
		if(!empty($attachedFiles) && is_array($attachedFiles)){
			foreach($attachedFiles as $attachedFile){
				if(Utils::StartsWith($attachedFile['filename'],Director::baseFolder())) {
					$filePath = $attachedFile['filename'];
				}
				else {
					$filePath = Director::baseFolder() . DIRECTORY_SEPARATOR . $attachedFile['filename'];
				}
				$this->mailer->AddAttachment($filePath);
			}
		}
	}


}