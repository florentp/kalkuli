<?php

namespace Kalkuli\ServerBundle\Controller\Command;

use Kalkuli\ServerBundle\Validator\Constraints as KalkuliAssert;

use Symfony\Component\Validator\Constraints as Assert;

class CreateSheetCommand {
	protected $name;
	protected $currencyCode;
	protected $creatorEmail;

	/**
	* @Assert\NotBlank(message="Missing or empty value for property 'accessKey'.")
	*/
	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @Assert\NotBlank(message="Missing or empty value for property 'currencyCode'.")
	 */
	public function getCurrencyCode() {
		return $this->currencyCode;
	}

	public function setCurrencyCode($currencyCode) {
		$this->currencyCode = $currencyCode;
	}

	/**
	 * @Assert\NotBlank(message="Missing or empty value for property 'creatorEmail'.")
	 * @Assert\Email(checkMX=true, message="Invalid value for input property 'creatorEmail'. Waiting a valid email address, received '{{ value }}'. Both format and domain are checked.")
	 */
	public function getCreatorEmail() {
		return $this->creatorEmail;
	}

	public function setCreatorEmail($creatorEmail) {
		$this->creatorEmail = $creatorEmail;
	}
}