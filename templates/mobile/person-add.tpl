{$form.javascript}

<form {$form.attributes}>
	{$form.hidden}
	<table cellspacing="0" cellpadding="0" class="mobile">
		<tbody>
			<tr>
				<th>Nouveau participant</th>
			</tr>
			<tr>
				<td class="spacer">&nbsp;</td>
			</tr>
			<tr>
				<td>
					<div>Nom&nbsp;:</div>
					<div>{$form.name.html}</div>
				</td>
			</tr>
			<tr>
				<td class="spacer">&nbsp;</td>
			</tr>
			<tr>
				<td>{$form.submit.html}</td>
			</tr>
		</tbody>
	</table>
</form>
