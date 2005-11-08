{$form.javascript}

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
        <td>
          <table>
            {foreach from=$form.consumersList key="consumerId" item="consumer"}
              <tr>
                <td>{$consumer.html}</td>
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