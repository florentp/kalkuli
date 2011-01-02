<ul id="menu">
	<li><a href="#" id="menuPeopleList">Pariticipants</a></li>
	<!--<li><a href="#" id="menuOperationsList">Opérations</a></li>-->
	<li><a href="#" id="menuNewOperation">Nouvelle opération</a></li>
	<li><a href="#" id="menuNewPerson">Nouveau participant</a></li>
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
			$.doGet(CONTEXT_PATH);
			return false;
		});
		$('#menuOperationsList').click(function() {
			$.doGet(CONTEXT_PATH + '/operation/list');
			return false;
		});
		$('#menuNewOperation').click(function() {
			$.doGet(CONTEXT_PATH + '/operation/add');
			return false;
		});
		$('#menuNewPerson').click(function() {
			$.doGet(CONTEXT_PATH + '/person/add');
			return false;
		});
	});
</script>
{/literal}