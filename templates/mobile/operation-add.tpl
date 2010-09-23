{$form.javascript}

{literal}
<script type="text/javascript">
  var allSelected = false;
  function selectDeselectAll() {
{/literal}
    {foreach from=$form.consumersList key="consumerId" item="consumer"}
      document.getElementsByName('{$consumer.name}')[0].checked = !allSelected;
    {/foreach}
    allSelected = !allSelected;
{literal}
  }
</script>
{/literal}

<form {$form.attributes}>
	{$form.hidden}
	<table cellspacing="0" cellpadding="0" class="mobile">
		<tbody>
			<tr>
				<th colspan="2">Détail de l'opération</th>
			</tr>
			<tr>
				<td colspan="2">
					<div>Contributeur&nbsp;:</div>
					<div>{$form.contributor.html}</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div>Montant&nbsp:</div>
					<div>{$form.amount.html|formatMoney}</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div>Description&nbsp;:</div>
					<div>{$form.description.html}</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div>Date (Y-m-d)&nbsp;:</div>
					<div>{$form.dateYear.html} - {$form.dateMonth.html} - {$form.dateDay.html}</div>
				</td>
			</tr>
			<tr>
				<td class="spacer" colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<th colspan="2">Liste des participants</th>
			</tr>
			<tr>
				<td colspan="2">
					<a href="javascript:;" onclick="javascript:selectDeselectAll();">Sélectionner / Désélectionner tous</a>
				</td>
			</tr>
			{foreach from=$form.consumersList key="consumerId" item="consumer"}
				<tr>
					<td>
						<div>{$consumer.html}</div>
						<div style="font-size:80%;">Part&nbsp;: {$form.consumersWeightsList[$consumerId].html}</div>
					</td>
					<td></td>
				</tr>
			{/foreach}
			<tr>
				<td class="spacer" colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">{$form.submit.html}</td>
			</tr>
		</tbody>
	</table>
</form>
