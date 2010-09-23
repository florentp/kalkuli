{$form.javascript}

<h1>Saisir une nouvelle personne</h1>

<div class="main">
  <form {$form.attributes}>
    {$form.hidden}
    <table class="tableForm">
      <tr>
        <th>Nom&nbsp;:</th>
        <td>{$form.name.html}</td>
      </tr>
	  <tr>
	    <td colspan="2">{$form.submit.html}</td>
	  </tr>
    </table>
  </form>
</div>
