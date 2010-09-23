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

<h1>Saisir une nouvelle opération</h1>
  
<div class="main">
  <form {$form.attributes}>
    {$form.hidden}
    <table class="tableForm">
      <tr>
        <th>Contributeur&nbsp;:</th>
        <td>{$form.contributor.html}</td>
      </tr>
      <tr>
        <th>Montant&nbsp:</th>
        <td>{$form.amount.html|formatMoney}</td>
      </tr>
      <tr>
        <th>Description&nbsp;:</th>
        <td>{$form.description.html}</td>
      </tr>
      <tr>
        <th>Date (Y-m-d)&nbsp;:</th>
        <td>{$form.dateYear.html} - {$form.dateMonth.html} - {$form.dateDay.html}</td>
      </tr>
      <tr>
        <th>Participants&nbsp;:</th>
        <td style="padding:0.7em;">
	      <div><a href="javascript:;" onclick="javascript:selectDeselectAll();">Sélectionner / Désélectionner tous</a></div>
          <table style="width: 100%;">
            {foreach from=$form.consumersList key="consumerId" item="consumer"}
              <tr>
                <td style="text-align:left;">{$consumer.html}</td>
                <td>Part&nbsp;: {$form.consumersWeightsList[$consumerId].html}</td>
              </tr>
            {/foreach}
          </table>
        </td>
      </tr>
	  <tr>
	    <td colspan="2">{$form.submit.html}</td>
	  </tr>
    </table>
    
  </form>
</div>
