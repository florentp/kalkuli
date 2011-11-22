<?php

namespace Kalkuli\ServerBundle {
	use Symfony\Component\HttpKernel\Bundle\Bundle;

	class KalkuliServerBundle extends Bundle {
	}
}

namespace {
	function is_empty($var) {
		return empty($var);
	}

	function is_set($var) {
		return isset($var);
	}
}
