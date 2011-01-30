<div data-role="page" data-theme="b" id="sheet">
	<div data-role="header">
		<h1>/kal.'ku.li/</h1>
	</div>
	<div data-role="content">
		<h2>{$sheet->getName()|escape}</h2>
		<ul data-role="listview" data-inset="true">
			{foreach from=$peopleList item="person" name="peopleList"}
				<li>
					<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/person/{$person->getPersonId()}" rel="external">{$person->getPersonName()|escape}</a>
					<span class="ui-li-aside">{$person->getBalance()|formatAmount:$sheet->getCurrencyCode()}</span>
				</li>
			{foreachelse}
				<li>Vous devez commencer par ajouter des participants</li>
			{/foreach}
		</ul>
		{if $nPeople > 0}
			<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/operation/add" data-role="button" rel="external">Saisir une opération</a>
		{/if}
		<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/person/add" data-role="button" rel="external">Ajouter des participants</a>
	</div>
</div>