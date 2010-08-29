<table cellspacing="0" cellpadding="0" class="summary">
	{foreach from=$peopleList item="person"}
		<tr>
			<td>
				<a href="person-details.php?personId={$person->getPersonId()}">{$person->getPersonName()}</a>
			</td>
			<td>{$person->getBalance()|formatMoney}</td>
		</tr>
	{foreachelse}
		<tr>
			<td>Vous devez commencer par saisir des personnes</td>
		</tr>
	{/foreach}
	<tr>
		<td colspan="2">
			<a href="person-add.php">+ Nouveau participant</a>
		</td>
	</tr>
</table>

{if $nPeople != 0}
	<div style="background-color: #EEEEEE; border-top: 1px solid #444444; border-bottom: 1px solid #444444;margin-top: 2em; padding: 0.5em;">
		<a href="operation-add.php">+ Nouvelle opération</a>
	</div>
{/if}