<?
  /*
  **  
  **  
  **  Contacts list
  **
  */
  
  include("contact_header.php");

  // security measure
  if( $login_level < $zen->getSetting('level_contacts') ) {
    print "Illegal access.  You do not have permission to access contacts.";
    exit;
  }

  switch ($overview) {
    case "company":
        $tabel = $zen->table_company; 
        $title = "title";
        $page_section = tr("Contact list - Company");
        $ie = NULL;
        break;
    case "external":
        $tabel = $zen->table_employee; 
        $title = "lname"; 
        $page_section = tr("Contact list - Persons Extern");
        $ie = 1;
        break;
    case "internal":
        $tabel = $zen->table_employee;
        $title = "lname";  
        $page_section = tr("Contact list - Persons Intern");
        $ie = 2;
        break;
    default:
        $tabel = $zen->table_company; 
        $title = "title";
        $overview = "company";
        $ie = NULL;
        $page_section = tr("Contact list - Company");
	  }
	   

  $expand_contacts = 1;
  include("$libDir/nav.php");
		
  include("$templateDir/contactView.php");

  include("$libDir/footer.php");
?>