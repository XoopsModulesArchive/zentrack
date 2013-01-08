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
    Contacts are simply companies or people who can be related to tickets
    or placed on notify lists, but do not have a login to <?=$zen->getSetting('system_name')?>.
    
    <p>A Company contact can have several Person contacts associated with it.
    
    <p>Contacts can be related to tickets and used as a way to group tickets
    by customer or company.
  </td>
</tr>
<tr>
  <td class='titleCell'>Agreements</td>
</tr>
<tr>
  <td class='cell'>
    Agreements represent contracts, support terms, or other verbal or written
    terms between your organization and a contact.
    
    <p>Items on an agreement represent specific terms or conditions associated
    with the agreement.
  </td>
</tr>
</table>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
