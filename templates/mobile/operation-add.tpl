<div class="ui-mobile-widget">
	<div class="ui-mobile-widget-header">Nouvelle opération</div>
	<form action="{$CONTEXT_PATH}/operation/add" id="addOperationForm" name="addOperationForm" method="post">
		<div class="ui-mobile-widget-separator">Détails</div>

		<div class="ui-mobile-widget-item">
			<div class="ui-helper-clearfix">
				<div class="ui-mobile-widget-item-field">
					<select class="contributor" id="contributorId" name="contributorId">
						{foreach from=$peopleList item="person"}
							<option value="{$person->getPersonId()}">{$person->getPersonName()|escape}</option>
						{/foreach}
					</select>
				</div>
				<div class="ui-mobile-widget-item-label">Contributeur</div>
			</div>
		</div>

		<div class="ui-mobile-widget-item">
			<div class="ui-helper-clearfix">
				<div class="ui-mobile-widget-item-field">
					<input class="amount" id="amount" maxlength="10" name="amount" type="text" />&nbsp;{$CURRENCY}
				</div>
				<div class="ui-mobile-widget-item-label">Montant</div>
			</div>
			<div class="ui-mobile-widget-item-description">
				<div class="formValidationMessage" id="amountFormValidationMessage"></div>
			</div>
		</div>

		<div class="ui-mobile-widget-item">
			<div class="ui-helper-clearfix">
				<div class="ui-mobile-widget-item-field">
					<input class="description" id="description" maxlength="255" name="description" type="text" />
				</div>
				<div class="ui-mobile-widget-item-label">Description</div>
			</div>
			<div class="ui-mobile-widget-item-description">
				<div class="formValidationMessage" id="descriptionFormValidationMessage"></div>
			</div>
		</div>

		<div class="ui-mobile-widget-item">
			<div class="ui-helper-clearfix">
				<div class="ui-mobile-widget-item-field">
					{html_select_date start_year="-2" end_year="+2" field_order="DMY" month_format="%m" prefix="date" day_extra='id="dateDay"' month_extra='id="dateMonth"' year_extra='id="dateYear"'}
					<input type="hidden" id="date" name="date" />
				</div>
				<div class="ui-mobile-widget-item-label">Date</div>
			</div>
		</div>
		<div class="ui-mobile-widget-separator">Participants</div>
			{foreach from=$peopleList key="consumerId" item="consumer"}
				<div class="ui-mobile-widget-item">
					<div class="ui-helper-clearfix">
						<div class="ui-mobile-widget-item-field">
							<label for="consumersWeightsList{$consumer->getPersonId()}">Part&nbsp;:</label>
							<input class="weight" id="consumersWeightsList{$consumer->getPersonId()}" maxlength="255" name="consumersWeightsList[{$consumer->getPersonId()}]" type="text" value="1" />
						</div>
						<div class="ui-mobile-widget-item-label">
							<input checked="checked" class="consumerCheckbox" id ="consumersIdList{$consumer->getPersonId()}" name="consumersIdList[{$consumer->getPersonId()}]" type="checkbox" />
							<label for="consumersIdList{$consumer->getPersonId()}">{$consumer->getPersonName()|escape}</label>
						</div>
					</div>
					<div class="ui-mobile-widget-item-description">
						<div id="consumersWeightsList{$consumer->getPersonId()}FormValidationMessage" class="formValidationMessage"></div>
					</div>
				</div>
			{/foreach}
			<div class="ui-mobile-widget-buttons">
					<button class="ui-button" id="addOperationButton" name="addOperationButton" type="submit">Enregistrer</button>
			</div>
		</div>
	</form>
{include file="mobile/menu-people-list.tpl"}

<script src="{$CONTEXT_PATH}/js/operation-add.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
	$(function() {

		$('.consumerCheckbox').click(function() {
			if ($('.consumerCheckbox:checked').length < 1)
				return false;
		});
		
		$('#dateDay, #dateMonth, #dateYear').change(function() {
			$('#date').val($('#dateDay').val() + '/' + $('#dateMonth').val() + '/' + $('#dateYear').val());
		})
			.first().change();

		$('#addOperationForm').validate({
			errorPlacement : function (label, element) {
				label.appendTo($('#' + element[0].id + 'FormValidationMessage'));
			}
		});

		loadValidationRules();
	});
</script>
{/literal}