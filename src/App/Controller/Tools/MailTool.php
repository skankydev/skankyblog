<?php 
/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * @copyright     Copyright (c) SCHENCK Simon
 *
 */

namespace App\Controller\Tools;

use SkankyDev\Controller\Tools\MasterTool;
use SkankyDev\Config\Config;

use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;

class MailTool extends MasterTool {
	
	public $conf;
	public $sender;
	public $mail;

	public function __construct(){
		$this->conf = Config::get('smtp.default');
		$this->sender = $this->conf['sender'];
		unset($this->conf['sender']);

	}

	/*
	va faloir decouper tout ca pour que se soit plus paratique a utiliser
	 */

	public function creatMail($to,$subject,$template,$var = []){
		$this->mail = new Message();
		$this->mail->setFrom($this->sender);
		//$this->mail->setHeader('X-Mailer', 'skankyblog');//pour ne pas afficher Nette Mail dans le source du mail
		$this->mail->addTo($to);
		$this->mail->setSubject($subject);
		$body = $this->getBody($template,$var);//ajouter un layout ca peux etre cool 
		$this->mail->setHtmlBody($body);
	}


	public function attachment($fileName){
		$this->mail->addAttachment($fileName);
	}

	public function sendMail(){
		$mailer = new SmtpMailer($this->conf);
		$mailer->send($this->mail);
	}

	public function getBody($template,$var = []){
		$fileName = Config::mailDir().DS.$template.'.php';
		extract($var);
		ob_start();
		require($fileName);
		return ob_get_clean();
	}

	/**
	 * define the sender mail
	 * @param string $sender the new sender
	 */
	public function setSender($sender){
		$this->sender = $sender;
	}
}
