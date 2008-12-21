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
    <table>
      <tr>
        <td>{$form.contributor.label}</td>
        <td>{$form.contributor.html}</td>
      </tr>
      <tr>
        <td>{$form.amount.label}</td>
        <td>{$form.amount.html|formatMoney}</td>
      </tr>
      <tr>
        <td>{$form.description.label}</td>
        <td>{$form.description.html}</td>
      </tr>
      <tr>
        <td>Date (Y-m-d)</td>
        <td>{$form.dateYear.html} - {$form.dateMonth.html} - {$form.dateDay.html}</td>
      </tr>
      <tr>
        <td>Ceux qui ont consommé</td>
        <td style="padding:0.7em;">
	  <div><a href="javascript:;" onclick="javascript:selectDeselectAll();">Sélectionner / Désélectionner tous</a></div>
          <table>
            {foreach from=$form.consumersList key="consumerId" item="consumer"}
              <tr>
                <td style="text-align:left;">{$consumer.html}</td>
                <td>Part&nbsp;: {$form.consumersWeightsList[$consumerId].html}</td>
              </tr>
            {/foreach}
          </table>
        </td>
      </tr>
    </table>
    
    <p>{$form.submit.html}</p>
  </form>
</div>
