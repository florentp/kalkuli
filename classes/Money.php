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

		public static function isMobileBrowser() {

			if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0)
				return false;

			if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
				return true;

			if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']))))
				return true;

			$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
			$mobile_agents = array(
				'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
				'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
				'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
				'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
				'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
				'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
				'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
				'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
				'wapr','webc','winw','winw','xda','xda-');

			if(in_array($mobile_ua,$mobile_agents))
				return true;

			if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0)
				return true;

			return false;

		}
	}