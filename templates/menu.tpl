<ul id="menu">
	<li><a href="#" id="menuHome">/kal.'ku.li/ home</a></li>
	<li><a href="#" id="menuAbout">A propos</a></li>
</ul>

{literal}
<script type="text/javascript">
	$(function() {
		$('#menu').addClass('ui-helper-clearfix ui-state-default');
		
		$('#menu > li').hover(
			function() { $(this).addClass('ui-state-hover'); },
			function() { $(this).removeClass('ui-state-hover'); }
		);
		
		$('#menuHome').click(function() {
			$.doGet(CONTEXT_PATH + '/');
			return false;
		});
		$('#menuAbout').click(function() {
			$.doGet(CONTEXT_PATH + '/about');
			return false;
		});
	});
</script>
{/literal}