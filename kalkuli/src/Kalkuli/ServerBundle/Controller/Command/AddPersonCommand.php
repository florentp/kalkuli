<?php

namespace Kalkuli\ServerBundle\Controller\Command;

use Kalkuli\ServerBundle\Validator\Constraints as KalkuliAssert;

use Symfony\Component\Validator\Constraints as Assert;

class AddPersonCommand {

	protected $accessKey;
	protected $name;
	protected $color;

	/**
	 * @Assert\MinLength(limit=10, message="Invalid value for input property 'accessKey'. Waiting a {{ limit }} characters long value, received '{{ value }}'.")
	 * @Assert\MaxLength(limit=10, message="Invalid value for input property 'accessKey'. Waiting a {{ limit }} characters long value, received '{{ value }}'.")
	 */
	public function getAccessKey() {
		return $this->accessKey;
	}

	public function setAccessKey($accessKey) {
		$this->accessKey = $accessKey;
	}

	/**
	 * @Assert\NotBlank(message="Invalid value for input property 'name'. Waiting a not empty value, received '{{ value }}'.")
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