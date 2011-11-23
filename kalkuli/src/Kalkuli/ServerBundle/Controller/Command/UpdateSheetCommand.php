<?php

namespace Kalkuli\ServerBundle\Controller\Command;

use Kalkuli\ServerBundle\Validator\Constraints as KalkuliAssert;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateSheetCommand {
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
	 *
	 */
	public function getCurrencyCode() {
		return $this->currencyCode;
	}

	public function setCurrencyCode($currencyCode) {
		$this->currencyCode = $currencyCode;
	}

	/**
	 * @Assert\Email(checkMX=true, message="Invalid value for input property 'creatorEmail'. Waiting a valid email address, received '{{ value }}'. Both format and domain are checked.")
	 */
	public function getCreatorEmail() {
		return $this->creatorEmail;
	}

	public function setCreatorEmail($creatorEmail) {
		$this->creatorEmail = $creatorEmail;
	}
}