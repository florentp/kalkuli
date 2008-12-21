{$form.javascript}

<h1>Saisir une nouvelle personne</h1>

<div class="main">
  <form {$form.attributes}>
    {$form.hidden}
    <table>
      <tr>
        <td>{$form.name.label}</td>
        <td>{$form.name.html}</td>
      </tr>
    </table>
    
    <p>{$form.submit.html}</p>
  </form>
</div>
