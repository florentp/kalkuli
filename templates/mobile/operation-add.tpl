<div class="ui-mobile-widget">
	<div class="ui-mobile-widget-header">Nouvelle opération</div>
	<form action="{$PHP_SELF}" id="addOperationForm" name="addOperationForm" method="post">
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
					<a class="datepicker" id="dateLink" href="#"></a>
					<input type="hidden" id="date" name="date" />
				</div>
				<div class="ui-mobile-widget-item-label">Date</div>
			</div>
			<div class="ui-mobile-widget-item-description">Cliquer sur la date pour la modifier.</div>
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

{literal}
<script src="js/operation-add.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {

		$('.consumerCheckbox').click(function() {
			if ($('.consumerCheckbox:checked').length < 1)
				return false;
		});
		
		$('#date').val($.datepicker.formatDate('dd/mm/yy', new Date()));
		$('#dateLink').text('Le ' + $('#date').val());

		$('#dateLink').click(function (event) {
			$(this).datepicker(
				'dialog',
				$('#date').val(),
				function(dateText, datepicker) {
					$('#date').val(dateText);
					$('#dateLink').text('Le ' + dateText);
				},
				{
					dateFormat: 'dd/mm/yy',
					duration: 0
				}
			);
			$('#ui-datepicker-div').css('z-index', '1000');
			return false;
		});

		$('#addOperationForm').validate({
			errorPlacement : function (label, element) {
				label.appendTo($('#' + element[0].id + 'FormValidationMessage'));
			}
		});

		loadValidationRules();
	});
</script>
{/literal}