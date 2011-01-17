<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<title>/kal.'ku.li/</title>

		<link href="{$CONTEXT_PATH}/css/jquery-ui/blitzer-custom/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
		<link href="{$CONTEXT_PATH}/css/style.css" rel="stylesheet" type="text/css" />

		<script src="{$CONTEXT_PATH}/js/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="{$CONTEXT_PATH}/js/jquery-ui-1.8.5.custom.min.js" type="text/javascript"></script>
		
		<script src="{$CONTEXT_PATH}/js/jquery-plugins/jquery.validate.min.js" type="text/javascript"></script>
		<script src="{$CONTEXT_PATH}/js/jquery-plugins/localization/messages_fr.js" type="text/javascript"></script>
		<script src="{$CONTEXT_PATH}/js/jquery-plugins/jquery.do.js" type="text/javascript"></script>
		<script src="{$CONTEXT_PATH}/js/sprintf.js" type="text/javascript"></script>
		
		<script type="text/javascript">
			const CONTEXT_PATH = '{$CONTEXT_PATH}';
			{if isset($sheet)}
				const SHEET_ACCESS_KEY = '{$sheet->getAccessKey()}';
			{/if}
		</script>

		<script src="{$CONTEXT_PATH}/js/kalkuli.js" type="text/javascript"></script>

		<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-15" />
	</head>

	<body>
		{include file="$templateName.tpl"}
		{literal}
		<script type="text/javascript">
			$(function() {
				$('.ui-main-widget').addClass('ui-widget ui-widget-content ui-corner-all');
				$('.ui-main-widget-header').addClass('ui-widget-header ui-corner-all');
				$('.ui-main-widget-separator').addClass('ui-widget-header ui-widget-separator ui-corner-all');
				$(".ui-button").button();
			});
		</script>
		{/literal}
		{if $GOOGLE_ANALYTICS_ID}
			<script type="text/javascript">
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', '{$GOOGLE_ANALYTICS_ID}']);
				_gaq.push(['_trackPageview']);

				(function() {ldelim}
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				{rdelim})();
			</script>
		{/if}
	</body>
</html>

