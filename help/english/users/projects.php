<?php
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr>
  <td class='cell'>
    Projects are containers used to hold groups of tickets which have a common
    purpose.  If, for instance, building a computer was a project, then the
    tickets assigned to this project might be buying parts, assembling components,
    installing operating system, and applying case mods (this one should be 
    high priority).
    
    <p>A project cannot be closed until all of the tickets and sub-projects
    it contains are closed.
    
    <p>Other than these distinctions, and the existence of the '<?=tr('Tasks')?>'
    tab, tickets and projects are technically identical.
  </td>
</tr>
</table>

<?php
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
