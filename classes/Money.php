<?php

	require_once('include/config.inc.php');

	class Money {
		
		public static function formatMoney($value) {
			$formatedMoney = "";
			
			if (IS_CURRENCY_SYMBOLE_BEFORE_VALUE)
				$formatedMoney .= CURRENCY;
			if (is_numeric($value))
				$formatedMoney .= ($value >= 0 ? '+' : '') . number_format(round($value, N_DECIMALS),N_DECIMALS);
			else
				$formatedMoney .= $value;
			if (!IS_CURRENCY_SYMBOLE_BEFORE_VALUE)
				$formatedMoney .= CURRENCY;
			
			return $formatedMoney;
		}
	}