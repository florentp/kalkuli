<?php

	class KeyGenerator {
		
		private $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

		public function generateKey($length) {
			$key = "";
			for ($i = 0; $i < $length; $i++)
				$key .= $this->chars[rand(0, count($this->chars) - 1)];
			
			return $key;
		}
		
	}