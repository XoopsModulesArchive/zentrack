<?php {
  /**
  **  ADD ENTRIES TO NOTIFY LIST
  **  
  **  Checks for duplicates and adds users/email addresses
  **  to a ticket's notify list
  */
  
  $action = "notify";  
  include("./action_header.php");
  
  if( $actionComplete == 1 ) {
    $ticket_id = $id;
    $priority = 1;
    // clean input vars
    $users = null;
    if( strlen($user_accts) ) {
      $users = split("[, \n]+", $user_accts);
    }
    if( strlen($unreg_name) ) {
      $unreg_name = strip_tags($unreg_name);
    }
    if( strlen($unreg_email) ) {
      $unreg_email = $zen->checkEmail($unreg_email);
    }
    
    if( strlen($company_id) ) {
      $company_id = $zen->checkNum($company_id); 
    }
    
    if( strlen($person_id) ) {
      $person_id = $zen->checkNum($person_id); 
    }
    
    if( !count($users) 
    && (!strlen($unreg_name)||!strlen($unreg_email)) 
    && !strlen($company_id) && !strlen($person_id) ) {
      $errs[] = tr("You must provide at least one registered user, or a valid name and email address");
    }
    
    if( !$errs ) {
      $i = 0;
      if( count($users) ) {
        foreach($users as $u) {
          if( !$zen->check_user_id($u) ) {
            $errs[] = tr("? was not a valid user id", array($u));
          } else {
            $params = array("user_id"   => $u,
            "priority"  => $priority,
            "ticket_id" => $ticket_id);
            $res = $zen->add_to_notify_list($ticket_id, $params);
            if( $res && $res != "duplicate" ) {
              $i++;
            }
            else if( $res && $res == "duplicate" ) {
              $msg[] = tr("User ? already on notify list", $u);        
            }
          }
        }
      }
      if( strlen($unreg_name) && strlen($unreg_email) ) {
        $params = array("name"      => $unreg_name,
        "email"     => $unreg_email,
        "priority"  => $priority,
        "ticket_id" => $ticket_id);
        $res = $zen->add_to_notify_list($ticket_id,$params);
        if( $res && $res != "duplicate" ) {
          $i++;
        }
        else if( $res && $res == "duplicate" ) {
          $msg[] = tr("Email ? already on notify list", $unreg_email);        
        }
      }
      if(strlen($company_id) || strlen($person_id)) {
        
        $dups = false;
        $parms = array(array("ticket_id", "=", $id));
        $currentContacts = $zen->get_contacts($parms,$zen->table_related_contact);
        if( $currentContacts ) {
          foreach($currentContacts as $c) {
            if( !$person_id && $c['type'] == 1 && $company_id && $c['cp_id'] == $company_id ) { 
              $msg[] = tr("Company already in contact list");
              $dups = true;
              break;
            }
            else if( $person_id && $c['type'] != 1 && $c['cp_id'] == $person_id ) { 
              $msg[] = tr("Employee already exists in contact list");
              $dups = true;
              break;
            }
          }
        }
    
        if( !$errs && !$dups ) {
          $params = array('ticket_id'   =>   $ticket_id,
                          'priority'    =>   $priority);
          if($company_id) {
            $data = $zen->get_contact($company_id,$zen->table_company,'company_id');
            $params['name'] = $data['title']." ".$data['office'];
            $params['email'] = $data['email']; 
          }
          
          if($person_id) {
            $data = $zen->get_contact($person_id,$zen->table_employee,'person_id' );
            $params['name'] = $data['fname'].' '.$data['lname'];
            $params['email'] = $data['email'];  
          }	 
          
          if( strlen($params['name']) && strlen($params['email']) ) {
            $res = $zen->add_to_notify_list($ticket_id,$params);
            if($res)$i++;
          }
          else {
            $zen->addDebug('addToNotify.php',"A valid name and email does not exist: $company_id / $person_id", 1);
            $errs[] = "Contact does not have a valid name and email";
          }
        }
      }		
      
      
      if( $i > 0 ) {
        $msg[] = tr("? recipients added", $i);
        $action = '';
        $page_mode = $setmode;
      }
    }
  }
  
  include("$libDir/nav.php");
  $zen->printErrors($errs);  
  if( $actionComplete == 1 && $page_type == "project" ) {
    $ticket = $zen->get_project($id);
  }
  else if( $actionComplete ) {
    $ticket = $zen->get_ticket($id);
  }
  if( $page_type == "project" ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  include("$libDir/footer.php");

}?>
