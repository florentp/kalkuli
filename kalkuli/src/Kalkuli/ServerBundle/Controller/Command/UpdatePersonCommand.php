<?php

namespace Kalkuli\ServerBundle\Controller\Command;

use Kalkuli\ServerBundle\Validator\Constraints as KalkuliAssert;

use Symfony\Component\Validator\Constraints as Assert;

class UpdatePersonCommand {

	protected $accessKey;
	protected $name;
	protected $color;

	/**
	 * @Assert\NotBlank(message="Missing or empty value for property 'accessKey'.")
	 */
	public function getAccessKey() {
		return $this->accessKey;
	}

	public function setAccessKey($accessKey) {
		$this->accessKey = $accessKey;
	}

	/**
	 *
	 */
	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @KalkuliAssert\HtmlColor(message="Invalid value for input property 'color'. Waiting an HTML color code, received '{{ value }}'.")
	 */
	public function getColor() {
		return $this->color;
	}

	public function setColor($color) {
		$this->color = $color;
	}

}