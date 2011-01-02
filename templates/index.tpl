{include file="menu.tpl"}
<div class="ui-main-widget">
	<div class="ui-main-widget-header">Créer une feuille de compte</div>
	<div>Créez simplement et gratuitement une feuille de compte en remplissant les champs ci-dessous. Aucune autre information ne vous sera demandée. Un email vous sera envoyé pour vous communiquer l'adresse unique de votre feuille de compte.</div>
	<form action="{$CONTEXT_PATH}" id="createSheetForm" name="createSheetForm" method="post">
		<table class="tableForm">
			<colgroup>
				<col />
				<col style="width: 8em;" />
			</colgroup>
			<tr>
				<th><label for="name">Nom de la feuille de compte&nbsp;:</label></th>
				<td>
					<input class="name" id="name" maxlength="255" name="name" type="text" />
					<div class="formValidationMessage" id="nameFormValidationMessage"></div>
				</td>
			</tr>
			<tr>
				<th><label for="currencyCode">Devise&nbsp;:</label></th>
				<td>
					<select id="currencyCode" name="currencyCode">
						<option value="EUR">Euro - &euro;</option>
						<option value="USD">US Dollard - $</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="creatorEmail">Email de rattachement&nbsp;:</label></th>
				<td>
					<input class="creatorEmail" id="creatorEmail" maxlength="255" name="creatorEmail" type="text" />
					<div class="formValidationMessage" id="creatorEmailFormValidationMessage"></div>
				</td>
			</tr>
			<tr class="buttonRow">
				<td colspan="2">
					<button class="ui-button" id="createSheetButton" name="createSheetButton" type="submit">Créer une feuille de compte</button>
				</td>
			</tr>
		</table>
	</form>
</div>

<div class="ui-main-widget">
	<div class="ui-main-widget-header">Retrouver ses feuilles de compte</div>
	<div>Saisissez l'adresse email que vous avez utilisée pour créer vos feuilles de compte. Un email vous sera immédiatement envoyé avec la liste des feuilles de compte qui y sont rattachées.</div>
	<form action="{$CONTEXT_PATH}" id="retrieveSheetsForm" name="retrieveSheetsForm" method="post">
		<table class="tableForm">
			<colgroup>
				<col />
				<col style="width: 8em;" />
			</colgroup>
			<tr>
				<th><label for="creatorEmail">Email de rattachement&nbsp;:</label></th>
				<td>
					<input class="creatorEmail" id="creatorEmail" maxlength="255" name="creatorEmail" type="text" />
					<div class="formValidationMessage" id="creatorEmailFormValidationMessage"></div>
				</td>
			</tr>
			<tr class="buttonRow">
				<td colspan="2">
					<button class="ui-button" id="retrieveSheetsButton" name="retrieveSheetsButton" type="submit">Retrouver ses feuilles de compte</button>
				</td>
			</tr>
		</table>
	</form>
</div>
