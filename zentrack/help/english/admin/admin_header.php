<?
  $b = dirname(dirname(dirname(__FILE__)));
  include_once("$b/help_header.php");
  
  $page_section = tr("Administrator's Manual");  
  include("$libDir/nav.php");
  
  $adminUrl = $helpUrl."/admin";
  
  $script = basename($_SERVER['SCRIPT_NAME']);
  if( $script == 'varfields.php' ) {
     $page_name = 'Variable Fields';
  }
  if( $script == 'find.php' ) {
    $page_name = $zen->checkAlphaNum($_GET['p']);
    if( $page_name == 'varfields' ) { $page_name = 'Variable Fields'; }
    $page_name = ucwords(str_replace('_', ' ',$page_name));
  }
  if( !$page_name ) {
    $page_name = ucwords(str_replace('_', ' ', str_replace('.php','',$script)));
    if( $page_name == 'Index' ) { $page_name = 'Overview'; }
  }
  
  renderNavbar('admin');  
?>
<p class='bigBold' align='center'>
<?= $page_name ?>
</p>
