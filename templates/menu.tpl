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
			window.location.href = 'index.php';
			return false;
		});
		$('#menuOperationsList').click(function() {
			window.location.href = 'operations.php';
			return false;
		});
		$('#menuNewOperation').click(function() {
			window.location.href = 'operation-add.php';
			return false;
		});
		$('#menuNewPerson').click(function() {
			window.location.href = 'people-add.php';
			return false;
		});
	});
</script>
{/literal}