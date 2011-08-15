<?php

/*
 * Copyright 2006-2011 Florent Paillard
 * 
 * This file is part of /kal.'ku.li/.
 * 
 * /kal.'ku.li/ is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * /kal.'ku.li/ is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with /kal.'ku.li/.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

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
