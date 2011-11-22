<?php

namespace Kalkuli\ServerBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HtmlColorValidator extends ConstraintValidator {

	public function isValid($object, Constraint $constraint) {
		if (empty($objet) && $constraint->validateEmpty)
			return true;

		if (preg_match('/^#[0-9a-fA-F]{3}([0-9a-fA-F]{3})?$/', $object))
			return true;
		else {
			$this->setMessage($constraint->message);
			return false;
		}
	}

}