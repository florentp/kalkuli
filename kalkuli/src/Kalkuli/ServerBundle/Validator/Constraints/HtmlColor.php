<?php

namespace Kalkuli\ServerBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 */
class HtmlColor extends Constraint {

	public $message = 'This value is not a valid HTML color';
	public $validateEmpty = false;

}