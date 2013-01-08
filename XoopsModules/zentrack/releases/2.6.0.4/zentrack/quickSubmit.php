<?
  /*
  **  NEW QUICK TICKET (quick submit)
  **  
  **  Commit new ticket to database
  **
  */
  
  
  include_once("./header.php");

$userBins = $zen->getUsersBins($login_id, "level_create");
$tmpBin = $_POST['bin_id'];
if( is_array($userBins)&& in_array($tmpBin,$userBins) ) {
  
	$vals = array("creator_id"=>$login_id,"otime"=>time());
	$vals["title"] = $zen->stripPHP($_POST['title']);
	$vals["type_id"] = $_POST['type_id'];
	$vals["system_id"] = $_POST['system_id'];
	$vals["bin_id"] = $_POST['bin_id'];
	$vals["priority"] = $_POST['priority'];

	$vals["description"] = $zen->stripPHP($_POST['description']);
    $notes = "Created by $login_name using Quick Create ";
	
	$id = $zen->add_ticket($vals,$notes);
      
      // check for errors
      if( !$id ) {
        $errs[] = tr("Could not create ticket."). " ".$zen->db_error;
      }
  
	if( !$errs ) {
		$setmode = null;
		$action = null;
		$ticketTabAction = 0;
		include("ticket.php");
		exit;
	} else {
		include("$libDir/nav.php");
		$onLoad[] = "behavior_js.php?formset=ticketForm";
		$zen->print_errors($errs);
		$view = "ticket_create";
		include("$templateDir/newTicketForm.php");
		include("$libDir/footer.php");
	} 
	
}else {
        $errs[] = tr("Could not create ticket."). " ".$zen->db_error;
		include("$libDir/nav.php");
		$onLoad[] = "behavior_js.php?formset=ticketForm";
		$zen->print_errors($errs);
		$view = "ticket_create";
		include("$templateDir/newTicketForm.php");
		include("$libDir/footer.php");
}
	

?>
