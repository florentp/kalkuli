<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<title>/kal.'ku.li/</title>

		<link href="css/jquery-ui/blitzer-custom/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />

		<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="js/jquery-ui-1.8.5.custom.min.js" type="text/javascript"></script>
		
		<script src="js/jquery-plugins/jquery.validate.min.js" type="text/javascript"></script>
		<script src="js/jquery-plugins/localization/messages_fr.js" type="text/javascript"></script>
		<script src="js/sprintf.js" type="text/javascript"></script>
		
		<script src="js/kalkuli.js" type="text/javascript"></script>

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
	</body>
</html>

