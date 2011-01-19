<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>/kal.'ku.li/</title>

		<link href="{$CONTEXT_PATH}/css/jquery-ui/blitzer-custom/jquery-ui-1.8.8.custom.css" rel="stylesheet" type="text/css" />
		<link href="{$CONTEXT_PATH}/css/m-style.css" rel="stylesheet" type="text/css" />

		<script src="{$CONTEXT_PATH}/js/jquery-1.4.4.min.js" type="text/javascript"></script>
		<script src="{$CONTEXT_PATH}/js/jquery-ui-1.8.8.custom.min.js" type="text/javascript"></script>
		
		<script src="{$CONTEXT_PATH}/js/jquery-plugins/jquery.validate.min.js" type="text/javascript"></script>
		<script src="{$CONTEXT_PATH}/js/jquery-plugins/localization/messages_fr.js" type="text/javascript"></script>
		<script src="{$CONTEXT_PATH}/js/jquery-plugins/jquery.do.js" type="text/javascript"></script>
		<script src="{$CONTEXT_PATH}/js/sprintf.js" type="text/javascript"></script>

		<script type="text/javascript">
			const CONTEXT_PATH = '{$CONTEXT_PATH}';
		</script>

		<script src="{$CONTEXT_PATH}/js/kalkuli.js" type="text/javascript"></script>

	</head>
	<body>
		{include file="mobile/$templateName.tpl"}
		{literal}
		<script type="text/javascript">
			$(function() {
				$('.ui-mobile-widget').addClass('ui-widget ui-widget-content');
				$('.ui-mobile-widget-header').addClass('ui-widget-header');
				$('.ui-mobile-widget-separator').addClass('ui-widget-header ui-widget-separator');
				$(".ui-button").button();
			});
		</script>
		{/literal}
	</body>
</html>

