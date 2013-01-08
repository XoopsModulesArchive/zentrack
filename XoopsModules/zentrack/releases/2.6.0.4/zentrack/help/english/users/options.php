<?
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr>
  <td class='cell'>
    Personal Options represents items which can be found on the '<?=tr('Options')?>'
    tab.  These are customizations that can be made on a per-user basis:
    
    <p><b><?=tr('Change Password')?></b> - Use this option to change your login password.
    Your login id can only be changed by an administrator.
    
    <p><b><?=tr('Change Default Bin')?></b> - This option can be used to change the
    bin which is loaded when you log in, and the bin selected by default when
    you create new tickets.
    
    <p><b><?=tr('Change Language')?></b> - You can change the language displayed
    by the application here.  This only changes your language setting and does
    not affect any other users.
  </td>
</tr>
</table>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
