<div class="ui-mobile-widget">
	<div class="ui-mobile-widget-header">Ajouter des participants</div>

	<form action="{$PHP_SELF}" id="addPeopleForm" name="addPeopleForm" method="post">
		{section start=0 loop=5 name="peopleList"}
			<div class="ui-mobile-widget-item">
				<div class="ui-helper-clearfix">
					<div class="ui-mobile-widget-item-field">
						<input class="name" id="namesList{$smarty.section.peopleList.iteration}" maxlength="255" name="namesList[{$smarty.section.peopleList.iteration}]" type="text" />
					</div>
					<div class="ui-mobile-widget-item-label">Participant {$smarty.section.peopleList.iteration}</div>
				</div>
				<div class="ui-mobile-widget-item-description">
					<div id="namesList{$smarty.section.peopleList.iteration}FormValidationMessage" class="formValidationMessage"></div>
				</div>
			</div>
		{/section}
		<div class="ui-mobile-widget-buttons">
			<button class="ui-button" name="addPeopleButton" type="submit">Enregistrer</button>
		</div>
	</form>
</div>
{include file="mobile/menu-people-list.tpl"}

{literal}
<script src="js/people-add.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {

		$('#addPeopleForm').validate({
			errorPlacement : function (label, element) {
				label.appendTo($('#' + element[0].id + 'FormValidationMessage'));
			}
		});
		
		loadValidationRules();
	});
</script>
{/literal}