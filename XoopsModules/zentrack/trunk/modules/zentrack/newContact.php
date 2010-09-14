<?php
  /*
  **  NEW CONTACT
  **  
  **  Create a new Contact
  **
  */
  
  
  include("contact_header.php");

  // security measure
  if( $login_level < $zen->getSetting('level_contacts') ) {
    print "Illegal access.  You do not have permission to access contacts.";
    exit;
  }
  
  $hotkeys->loadSection('contacts_new_menu');
  $GLOBALS['zt_hotkeys'] = $hotkeys;

  $page_title = tr("Create a new Contact");
  $page_section =  tr("Create a new Contact");
  $expand_contacts = 1;
  include("$libDir/nav.php");
  
if ($mode2==1){
	  	include("$templateDir/newContactForm.php");
} elseif ($mode2==2){
		  include("$templateDir/newContacteForm.php");
} else {
?>
<br>
<br>
<br>
<br>
<ul>
  <b><?php echo tr("Contacts Administration"); ?></b>
  <ul>
    <b><a href='<?php echo $rootUrl?>/newContact.php?mode2=1' title="<?php echo $hotkeys->tt("New Company"); ?>"><?php echo $hotkeys->ll("New Company"); ?></a></b>
    <br><b><a href='<?php echo $rootUrl?>/newContact.php?mode2=2' title="<?php echo $hotkeys->tt("New Person"); ?>"><?php echo $hotkeys->ll("New Person"); ?></a></b>
  </ul>
  
</ul>

<?php
} 

  include("$libDir/footer.php");
?>
