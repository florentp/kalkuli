<?php

class CurrencyType {
	private static $currencyList = array(
		"EUR" => array(
			'name' => 'Euro',
			'symbol' => '&euro;'
		),
		'USD' => array(
			'name' => 'US dollar',
			'symbol' => '$'
		)
	);
	
	public static function getName($currencyCode) {
		return self::$currencyList[$currencyCode]['name'];
	}

	public static function getSymbol($currencyCode) {
		return self::$currencyList[$currencyCode]['symbol'];
	}

	public static function getCurrencyCodeList() {
		$currencyCodeList = array();
		foreach(self::$currencyList as $currencyCode => $currency) {
			$currencyCodeList[] = $currencyCode;
		}
		return $currencyCodeList;
	}

	public static function exists($currencyCode) {
		return isset(self::$currencyList[$currencyCode]);
	}
}