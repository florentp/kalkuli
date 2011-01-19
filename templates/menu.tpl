<ul id="menu">
	<li><a href="#" id="menuHome">Accueil</a></li>
	<li><a href="#" id="howItWorks">Comment ça marche&nbsp;?</a></li>
	<li><a href="#" id="menuFaq">FAQ</a></li>
	{if $TESTS_SITE}
		<img id="testsStamp" alt="Tests" height="38" src="{$CONTEXT_PATH}/images/tests-stamp.png" title="Site de tests. Les données peuvent être effacées à n'importe quel moment." width="74" />
	{/if}
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
		$('#howItWorks').click(function() {
			$.doGet(CONTEXT_PATH + '/howItWorks');
			return false;
		});
		$('#menuFaq').click(function() {
			$.doGet(CONTEXT_PATH + '/faq');
			return false;
		});
	});
</script>
{/literal}