<ul id="menu">
	<li><a href="#" id="menuPeopleList">Pariticipants</a></li>
	<!--<li><a href="#" id="menuOperationsList">Opérations</a></li>-->
	<li><a href="#" id="menuNewOperation">Nouvelle opération</a></li>
	<li><a href="#" id="menuNewPerson">Nouveau participant</a></li>
	{if $TESTS_SITE}
		<img id="testsStamp" alt="Tests" height="38" src="images/tests-stamp.png" title="Site de tests. Les données peuvent être effacées à n'importe quel moment." width="74" />
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
		
		$('#menuPeopleList').click(function() {
			$.doGet(sprintf('%s/%s', CONTEXT_PATH, SHEET_ACCESS_KEY));
			return false;
		});
		$('#menuOperationsList').click(function() {
			$.doGet(sprintf('%s/%s/operation/list', CONTEXT_PATH, SHEET_ACCESS_KEY));
			return false;
		});
		$('#menuNewOperation').click(function() {
			$.doGet(sprintf('%s/%s/operation/add', CONTEXT_PATH, SHEET_ACCESS_KEY));
			return false;
		});
		$('#menuNewPerson').click(function() {
			$.doGet(sprintf('%s/%s/person/add', CONTEXT_PATH, SHEET_ACCESS_KEY));
			return false;
		});
	});
</script>
{/literal}