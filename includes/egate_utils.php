<?php {  define("ZT_DEFINED",true);
  
  /*
  **  EGATE UTILS
  **  
  **  The funtions that process incoming data
  */
 
  // get configuration
  include_once("egate_config.php");

  // just a list of valid template forms I have created
  $form_template_list = array("create","help","log","move");

  // initialize log
  $egate_log = array();
  // initialize the templates
  $email_templates = array();

  /**
   * Check quoting, since adodb will escape based on magic_quotes_gpc...
   * Thus if magic_quotes are on, we need to add slashes to the incoming
   * values to simulate magic quotes so that adodb can function accordingly
   *
   * @param array $vals is the body values passed to the ticket action functions
   * @return array the $vals with slashes simulating the current setting of magic_quotes_gpc()
   */
  function check_magic_quotes( $vals ) {
    if( get_magic_quotes_gpc() > 0 ) {
      foreach($vals as $k=>$v) {
	$vals[$k] = addslashes($v);
      }
    }
    return $vals;
  }

  /**
   * Stores log info
   *
   * @param string/array $text the text to store
   * @param integer $lvl 1-error(system), 2-warning, 3-notice
   */
  function egate_log( $text, $lvl = 3 ) {
    // if we get an array, handle it gracefully
    if( is_array($text) ) {
      foreach($text as $t)
        egate_log($text, $lvl);
      return;
    } 
    // get the log text
    global $egate_log;
    // check for this fatal error, which isn't really an error
    if( preg_match("@mailbox is empty@i", $text) ) {
      $text = "Mailbox was empty";
      $egate_log[] = array($text,3);
    }
    else {
      $egate_log[] = array($text,$lvl);
    }
  }

  /**
   * returns a list of messages for use by user
   *
   * @param integer lvl 1-errors, 2-warning, 3-notices
   * @return array of log entries
   */
  function egate_fetch_messages( $lvl = '' ) {
    global $egate_log;
    // save time if there is nothing to fetch
    if( $lvl === 0 || !count($egate_log) ) { return; }
    // get appropriate logs
    $vars = null;
    foreach($egate_log as $l) {
      if( $l[1] <= $lvl ) { $vars[] = $l[0]; }
    }
    return $vars;
  }

  /**
   * stores footer templates that should be
   * included in an email reply
   *
   * @param string $template is the template name to include
   * @param int $id is the ticket id, if available (for creating subject)
   */
  function egate_store_template( $template, $id = 0 ) {
    global $email_templates;
    // create a subject if appropriate
    $sub = egate_get_subject();
    if( !strlen($sub) ) {
      global $form_template_list;
      $tmp = str_replace(".template","",$template);
      $tmp = str_replace("form_","",$tmp);
      // we only want it if it's a real template value
      if( in_array($tmp,$form_template_list) ) {
	$txt = ucwords(str_replace("_"," ",$tmp));
	if( $id )
	  $txt = "#$id: $txt";
	egate_store_subject($txt);
      }
    }
    // store our template
    $email_templates[] = $template;
  }

  /**
   * stores the subject of template[somthing] emails to be retrieved by mail fxn
   *
   * @param string $subject of the email
   */
  $template_subject = "";
  function egate_store_subject( $subject ) {
    global $template_subject;
    $template_subject = $subject;
  }

  /**
   * retrieves the subject for template emails
   *
   * @return string subject of email
   */
  function egate_get_subject() {
    global $template_subject;
    return $template_subject;
  }

  /**
   * returns the email templates which have been collected
   *
   * @return array of template strings
   */
  function egate_fetch_templates() {
    global $email_templates;
    return $email_templates;
  }
  
  /**
  * writes logs to file
  * 
  * Opens the log file and writes all existing entries
  * can also send an email if informed to do so
  * 
  */
  function egate_log_write() {
    global $egate_log;
    global $libDir;
    global $egate_log_level;
    if( count($egate_log) ) {
      $text = "---".date("Y-m-d H:i")."---\n";
      foreach($egate_log as $l) {
        if( $l[1] <= $egate_log_level ) {
          $text .= $l[0]."\n";
        }
      }    
      $fp = fopen("$libDir/logs/egate_log","a");
      fputs($fp,$text);
      fclose($fp);
      $egate_log = array();
    }
  }

  // check for proper setup
  if( !file_exists($header_file_location) ) {
    egate_log("ERROR: \$header_file_location not set correctly... exiting",1);
    egate_log_write();
    exit;
  }

  // get the system settings
  // and process them, but don't include
  // the headerInc.php file, just get
  // the setting values
  $file = file($header_file_location);
  foreach($file as $f) {
    if( preg_match("/^ *([$]|set_locale)/", $f)) {
      eval($f);
    }
  }

  //initialize zen base object
  include_once("$libDir/zenTrack.class.php");
  $zen = new zenTrack( $configFile );

  // include the zen objects
  include_once("$libDir/zenTemplate.class.php");
  include_once("$libDir/translator.class.php");

  //Create the initialization array for the translator object
  $translator_init = array(
     'domain' => 'translator',
     'path' => "$libDir/translations",
     'locale' => $login_language
  );
  $translator_init['zen'] =& $zen;
  tr($translator_init);

  // include the mail decoding functions
  include_once('Mail/mimeDecode.php');
  
  // make sure we are using the email interface
  if( !$zen->settingOn("email_interface_enabled") ) {
    egate_log("ERROR: email ignored, email_interface_enabled = off",1);
    egate_log_write();
    exit;
  }
  
  // determine the egate user's settings and access rights
  $egate_user = $zen->get_user_by_login($egate_account);
  
  // produce an error if the egate user is not in database
  if( !is_array($egate_user) || !count($egate_user) ) {
    egate_log("ERROR: egate user account not found",1);
    egate_log_write();
    exit;    
  }
  
  // get the egate access priviledges
  $egate_user["access"] = $zen->get_access($egate_user["user_id"]);

  /**
   * parses out the body of the email, looking for template properties
   *
   * removes comments and reply portions of the message (> ..)
   * and parses out useful information
   *
   * @param string raw message body
   * @return array "details" and any other parameters found in the message
   */ 
  function parse_message_body( $body ) {
    // get the zen object
    global $zen;
    
    // initialize the return array
    $params = array("details"=>"");
    
    // remove comments
    $body = preg_replace("/\(\*[^)]*\*\)/s", "", $body);
    
    // parse the contents
    $lines = explode("\n",$body);
    $in = false;
    for($i=0; $i<count($lines); $i++) {
      $l = trim($lines[$i]);
      if( preg_match("/^[> ]*@([a-zA-Z0-9_ -]+):(.*)/", $l, $matches) ) {
	// determine the index
	$n = strtolower(trim($matches[1]));
	$t = trim($matches[2]);
	// if we didn't get a proper index, then skip it
	if( !$n ) { continue; }
	if( strlen($t) && preg_match("/^\[ *[xX] *\]/", $t) ) {
	  // it's a checkbox on this line, so return a 1
	  $params["$n"] = 1;
	  continue;
	} else if( strlen($t) && preg_match("/^\[ *\]/", $t) ) {
	  // it's an empty checkbox, so return 0
	  $params["$n"] = 0;
	  continue;
	}
	else if( strlen($t) ) {
	  // it's something, so it's a single line of text
	  $params["$n"] = $t;
	}
	else {
	  $params["$n"] = "";
	  
	  // we didn't find a checkbox on the @...: line, so look further
	  while(true) {
	    $i++;
	    // make sure we don't cause an infinite loop
	    if( $i >= count($lines) ) { break; }
		
	    // get the next line
	    $l = trim($lines[$i]);
	    
	    // parse the line
	    // this line is blank, so skip it
	    if( preg_match("/^[> ]*$/", $l) ) { continue; }
	    // if this line starts with [ ]...
	    // it's unchecked, so keep looking
	    else if( preg_match("/^[> ]*\[ *\]/", $l) ) { continue; }
	    else if( preg_match("/^[> ]*\[ *[xX] *] *(.+)/", $l, $matches) ) {
	      // this line starts with [x] wordswords, 
	      // then wordswords is our value
	      $params["$n"] = trim($matches[1]);
	      break;
	    }
	    else if( preg_match("/^[> ]*(@end|@[a-zA-Z0-9_ -]+:)/", $l) ) {
	      // if we come to the next parameter, or an @end, we are done
	      $i--;
	      break;
	    } else {
	      // we don't have a [ ] or a [x], so this must be
	      // a text entry, concat it together and return it
	      $params["$n"] .= preg_replace("/^[> ]*/", "", $l)."\n";
	    }
	  }
	}
      }
      // this is some junk text returned by the user hitting the reply
      // button, or an @end comment so skip it
      else if( preg_match("/^( *>| *@end)/", $l) ) { continue; }
      // all other text becomes part of the details
      else { $params["details"] .= $l."\n"; }      
    }
    $params["details"] = trim($params["details"]);
    return( $params );
  }


  /**
   * Decode the message and return params
   *
   * @param string $input the raw data
   * @return object params
   */
  function decode_contents($input) {
    global $zen;
    // set up params and execute decoding
    $params['include_bodies'] = TRUE;
    $params['decode_bodies']  = TRUE;
    $params['decode_headers'] = TRUE;
    $decoder = new Mail_mimeDecode($input);
    $structure = $decoder->decode($params);
    
    // record what we recieved
    egate_log( "From: ".$structure->headers["from"]
	       ."\nReply-to: ".$structure->headers["reply-to"]
	       ."\nSubject: ".$structure->headers["subject"], 2 );
    
    return $structure;
  }

  /**
   * ensures that we have valid contents to work with
   *
   * @param object the decoded object obtained from decode_contents()
   * @return boolean contents are valid
   */
  function validate_params( $params ) {
    $valid = true;
    // validate the file parameters
    if( $params->headers["subject"] == "" ) {
      $errors = false;
      egate_log("ERROR: Subject was blank",2);
    }
    if( !$params->headers["from"] && !$params->headers["reply-to"] ) {
      $valid = false;
      egate_log("ERROR: There is no return address",2);
    }
    return $valid;
  }

  /**
   ** returns a list of valid actions for the ticket and user
   **
   ** @param integer $ticket_id the ticket id
   ** @return array of actions which are valid
   */
  function fetch_valid_actions( $ticket_id ) {
    global $egate_user;
    global $zen;
    $vars = array("remove","help","template","options");
    $vals = $zen->listValidActions($ticket_id,$egate_user["user_id"]);
    foreach($vals as $k=>$v) {
      if( $v["egate"] > 0 ) {
	$vars[] = $k;
      }
    }
    natsort($vars);
    return $vars;
  }

  /**
   * returns the entries needed to complete the template forms
   *
   * @param array $vals the template vals so far
   * @return array the $vals from input plus the new.template vals
   */
  function fetch_template_vals( $vals ) {
    global $zen;
    global $egate_user;
    $vals["types"] = $zen->getTypes();
    $vals["systems"] = $zen->getSystems();
    $bins = $zen->getUsersBins($egate_user["user_id"],"level_create");
    if( is_array($bins) ) {
      $vals["bins"] = array();
      foreach($bins as $b) {
	$vals["bins"][] = $zen->getBinName($b);
      }
    }
    $vals["priorities"] = $zen->getPriorities();
    $vals["activities"] = $zen->getActivities();
    $vals["default_start_date"] = $zen->getDefaultValue("default_start_date");
    if( strlen($vals["default_start_date"]) )
      $vals["default_start_date"] = $zen->showDate($vals["default_start_date"]);
    $vals["default_deadline"] = $zen->getDefaultValue("default_deadline");
    if( strlen($vals["default_deadline"]) )
      $vals["default_deadline"] = $zen->showDate($vals["default_deadline"]);
    $vals["default_test"] = 
      ($zen->getDefaultValue("default_tested_checked")==" checked ")? "x" : "";
    $vals["default_approve"] = 
      ($zen->getDefaultValue("default_aprv_checked")==" checked ")? "x" : "";    
    return $vals;
  }

  /**
   * returns the action for this ticket
   *
   * parses the subject to obtain this ticket action, and
   * validates that action against the allowed actions
   *
   * @param object email object obtained from decode_contents()
   * @return array containing action and ticket array
   */
  function parse_subject( &$params ) {
    global $zen;
    $errors = false;
    $ticket = null;

    // parse the subject
    preg_match("@#([0-9]+):? *([a-zA-Z0-9_-]+)@", 
	       $params->headers["subject"], $matches);
    $matches[1] = (count($matches)>2)? 
      preg_replace("@[^0-9]@", "", $matches[1]) : 0;

    // check for create action
    if( (count($matches) < 3 || $matches[1] <= 0) 
	&& preg_match("@(help|create|template)@i",$params->headers["subject"],$specs) ) {
      $action = strtolower(trim($specs[1]));      
    }
    else if( count($matches) > 1 && $matches[1] > 0 ) {
      // set the action and id
      $action = strtolower(trim($matches[2]));
      $id = trim($matches[1]);
      // make sure we have a valid ticket and action
      $ticket = $zen->get_ticket($id);    
      if( !is_array($ticket) || !count($ticket) ) {
	$errors = true;
	egate_log("Ticket #$id is not a valid ticket",2);
	return;
      }
    } else {
      // try to divine the action anyways, even though the format wasn't correct
      // start by removing [zenBot] tag
      $test = preg_replace("/\[".$zen->getSetting('bot_name')."]/","",$params->headers["subject"]);
      if( strlen($test) ) {
	// look for an id
	if( preg_match("/#([0-9]+)/", $subject, $matches) ) {
	  $id = $matches[1];
	}
	// get a list of valid actions
	$valid_actions = fetch_valid_actions($id);
	// get a string of possible action names
	$str = join('|',$valid_actions);
	if( preg_match("/($str)/", $subject,$matches) ) {
	  $action = $matches[1];
	}
      }
      if( !$action || !$id ) {
	// no valid action
	$errors = true;
	egate_log("ERROR - no valid action was found for header:"
		  .$params->headers["subject"],2);
	return;
      }
    }

    if( !is_array($valid_actions) ) {
      $valid_actions = fetch_valid_actions($id);
    }

    // customize the notify actions
    if( $action == "add" || $action == "drop" ) {
      $action = "notify_$action";
    }
    if( $action == "status" ) {
      $action = "view";
    }
    if( $action == "help" ) {
      $action = "template";
      $params->headers["subject"] = "template help";
    }

    // determine which actions might be in the subject
    if( !in_array($action,$valid_actions) ) {
      $errors = true;
      egate_log("The action $action was not valid.  This could be because of access or ticket status conditions. Try replying to this email with the subject \"#nnnn: options\" to see a list of valid actions.",2);
      return;
    }

    // return the results
    if( !$errors ) { return array($action,$ticket); }
    else { return false; }
    
  }

  /**
   * Creates a new ticket entry
   *
   * @param integer $user_id the user id to use for creation 
   * @param string $name the name of the sender
   * @param string $email the email of the sender
   * @param array $body the indexed array from parse_message_body()
   * @param object $params the object obtained from decode_contents()
   * @return integer ticket id or 0 if failed
   */
  function create_new_ticket($user_id, $name, $email, $body) {
    global $zen;
    global $egate_user;
    $vals = array("creator_id"=>$user_id,"otime"=>time());
    $fullname = ($name)? "\"$name\" <$email>" : $email;
    // here we run through all the body elements
    // and prepare the results
    foreach($body as $k=>$v) {
      $v = trim($v);
      switch(strtolower($k)) {
      case "parent":
      case "project":
	if( strlen($v) ) 
	  $vals["project_id"] = get_ticket_id($v);
	break;
      case "title":
	$vals["title"] = $zen->stripPHP($v);
	break;
      case "type":
	$vals["type_id"] = get_type_id("types",$v);
	break;
      case "system":
	$vals["system_id"] = get_type_id("systems",$v);
	break;
      case "owner":
	{
	  if( strtolower($v) == "me" || strtolower($v) == "myself" ) {
	    $vals["user_id"] = $user_id;
	  }
	  else if( preg_match("/^[0-9]+$/", $v) ) {
	    $user = $zen->get_user($v);
	    if( $user ) {
	      egate_log("created owner from id '$v': ".($user?$user['user_id']:'<null>'), 3);
	      $vals["user_id"] = $user['user_id'];
	    }
	    else {
	      egate_log("could not locate owner by id '$v', skipped",2);
	    }
	  }
	  else if( strpos($v, '@') > 0 ) {
	    $user = find_user_id('',$v);
	    if( $user ) {
	      $vals['user_id'] = $user['user_id'];
	      egate_log("created owner from email '$v': ".($vals['user_id']?$vals['user_id']:'<null>'), 3);
	    }
	    else {
	      egate_log("could not create owner from email '$email', skipped",2);
	    }
	  }
	  else if( strlen($v) ) {
	    $user = find_user_id('','',$v);
	    if( $user ) {
	      $vals['user_id'] = $user['user_id'];
	      egate_log("created owner by login '$v': ".($vals['user_id']?$vals['user_id']:'<null>'), 3);
	    }
	    else {
	      egate_log("could not create owner from login '$login', skipped", 3);
	    }
	  }
	}
	break;
      case "bin":
	$vals["bin_id"] = get_type_id("bins",$v);
	break;
      case "priority":
	$vals["priority"] = get_type_id("priorities",$v);
	break;
      case "start":
      case "start_date":
      case "start date":
	if( strlen($v) ) {
	  $vals["start_date"] = strtotime($v);
	}
	break;
      case "deadline":
	if( strlen($v) ) {
	  $vals["deadline"] = strtotime($v);
	}
	break;
      case "worked":
      case "wkd_hours":
      case "hours worked":
	if( strlen($v) ) {
	  $vals['wkd_hours'] = $zen->checkNum($v);
	}
	break;
      case "est_hours":
      case "estimated hours":
      case "estimated":
	if( strlen($v) ) {
	  $vals['est_hours'] = $zen->checkNum($v);
	}
      case "testing":
      case "testing required":
      case "testing_required":
	{
	  if( $v == 1 )
	    $vals["tested"] = 1;
	  else
	    $vals["tested"] = 0;
	}
	break;
      case "approval required":
      case "approval_required":
      case "approval":
	{
	  if( $v == 1 )
	    $vals["approved"] = 1;
	  else
	    $vals["approved"] = 0;
	  break;
	}
      case "details":
	$vals["description"] = $zen->stripPHP($v);
	break;
      }      
    }
    
    $vals = check_magic_quotes($vals);

    // include the proper template
    //egate_store_subject("Create New Ticket");
    //egate_store_template("create.template");

    // check required fields
    $success = true;
    $required = array(
		   "title",
		   "priority",
		   "description",
		   "bin_id",
		   "type_id",
		   "system_id",
		   "creator_id"
		   );
    foreach($required as $r) {
      if( !isset($vals[$r]) || !$vals[$r] ) {
	$success = false;
	egate_log( ucfirst(str_replace("_id","",$r))." is required",2);
      }
    }
    if( $success == true ) {
      $notes = ($user_id == $egate_user["user_id"])? 
	"Created by $fullname" : "";
      $id = $zen->add_ticket($vals,$notes);
      if( $id ) {
	egate_log("Ticket created with id #$id",3);
	// add user to notify list if they create
	// a ticket through the egate system
	// and default_notify_creator == "on"
	if( $user_id == $egate_user["user_id"] && $zen->settingOn("default_notify_creator") ) {
	  $zen->add_to_notify_list( $id, array("name"=>$name,"email"=>$email) );
	}
	return $id;
      }
      else {
	egate_log("Ticket create failed",2);
	return 0;
      }
    }
    return 0;
  }

  /**
   * try to find a user in the system based on their name and email
   *
   * @param string $name is the users name
   * @param string $email is the users email
   * @return integer user_id to use, returns egate_user id if no id found
   */
  function find_user_id($name,$email,$login = '') {
    global $zen;
    global $egate_user;
    // find out what user_id to apply
    // by trying to find this user in
    // the system 
    $users_by_email = '';
    if( $login ) {
      $user_id = $zen->get_user_by_login($login);
      if( $user_id ) {
	egate_log("found user by login  '$login': $user_id",3);
      }
      else {
	egate_log("invalid login name ignored: $login",2);
      }
    }
    if( !$user_id && $email ) {
      egate_log("locating user by email '$email'", 3);
      $users_by_email = $zen->get_users_by_email($email);
      if( is_array($users_by_email) ) {
	// if we got more than one user for this email address
	// then try looking at the name
	if( count($users_by_email) > 1 && strlen($name) ) {
	  $vals = array();
	  $users_by_name = $zen->get_users_by_name($name);
	  if( is_array($users_by_name) ) {
	    // foreach name found, see if this user_id also
	    // has the correct email, if so, it's a possible match
	    foreach($users_by_name as $u) {
	      if( in_array($u,$users_by_email) ) {
		$vals[] = $u;
	      }
	    }
	  }
	  // if there are more than one, we can't be sure, so skip
	  if( count($vals) == 1 ) {
	    $user_id = $vals[0];
	  }
	  egate_log("multiple users have address '$email', tried to select by name '$name': $user_id",2);
	}
	else if( count($users_by_email) == 1 ) {
	  // we only found one, so that must be it
	  $user_id = $users_by_email[0];
	  egate_log("selected user by email '$email': $user_id",3);
	}
      }
    }
    if( !$user_id ) {
      egate_log("selected default user (egate account): $user_id",3);
      $user_id = $egate_user["user_id"];
    }
    return $user_id;
  }

  /**
   * returns a third param from a ticket subject (or body if found)
   *
   * @param object $params the params from parse_subject()
   * @param string $body_tag (optional) will search body for this tag and use if found
   * @param array $body (optional) the body tags from parse_message_body()
   * @return string value of param or body tag if found
   */
  function get_subject_param( $params, $body_tag = '', $body = '' ) {
    // search body element for tag
    if( is_array($body) && $body_tag ) {
      if( isset($body[$body_tag]) ) {
	return $body[$body_tag];
      }
    }
    // return tag from subject
    if( $body_tag == "template" ) {
      preg_match("/template:? ([a-zA-Z0-9_-]+)/", $params->headers["subject"],$matches);
      return trim($matches[1]);
    }
    preg_match("/#[0-9]+:? *[a-zA-Z0-9_-]+ +(.*)/",$params->headers["subject"],$matches);
    if( $matches[1] ) {
      return trim($matches[1]);
    }
    return "";
  }

  /**
   * attempts to retrieve a ticket by the title, or by the id
   *
   * @param string $text title or id
   * @return integer id of ticket or 0 if failed
   */
  function get_ticket_id( $text ) {
    global $zen;
    // insure the input is cleaned up
    $text = trim($text);
    // check for #nnnn
    $text = preg_replace("/^#([0-9]+)$/", "\\1", $text);
    if( !preg_match("/[^0-9]/", $text) && strlen($text) && intval($text) > 0 ) {
      // here we look for an id, if found, we validate it
      $ticket = $zen->get_ticket($text);
      if( is_array($ticket) ) {
	return $ticket["id"];
      }
      else {
	egate_log("Ticket #$text not found",2);
	return 0;
      }
    }
    else {
      if( strlen($text) ) {
	// here we look for a complete title match
	$params = array("title"=>array("title","=",$text));
	$vals = $zen->search_tickets($params);
	if( !is_array($vals) || !count($vals) ) {
	  // here we try for a partial title match
	  $params["title"][1] = "contains";
	  $vals = $zen->search_tickets($params);
	}
      }
      if( is_array($vals) ) {
	if( count($vals) > 0 ) {
	  // if we have more than one, we return an error, since
	  // we aren't sure what the right one is
	  egate_log("More than one ticket with that title, please try the id",2);
	  return 0;
	}
	else {
	  // otherwise, we have success
	  return $vals[0]["id"];
	}
      }
      else {
	egate_log("Title didn't match any active tickets",2);
	return 0;
      }
    }
  }

  /**
   * evaluates the users input and determines what id it stands for
   *
   * @param string $type the data type(plural): systems, types, bins, priorities, etc
   * @param string $input the users input
   * @return integer the id to use. returns null on failure
   */
  function get_type_id( $type, $input ) {
    global $zen;
    $id = null;
    $n = "get".ucfirst($type);
    $vals = $zen->$n();
    $input = trim($input);
    if( is_integer($input) && isset($vals["$input"]) ) {
      return $input;
    }
    else if( !is_integer($input) ) {
      foreach($vals as $k=>$v) {
	if( strtolower($v) == strtolower($input) )
	  return $k;
      }
    }
    egate_log(($input?$input:"<null>")." was not a valid $type entry",2);    
    return $id;
  }

  /**
   * Conduct a ticket action
   *
   * @param string $name the name of the sender
   * @param string $email the email of the sender
   * @param string $action the action to perform
   * @param array $ticket properties of the ticket
   * @param array $body the parsed body properties (from parse_body())
   * @param array $params the mail params from parse_contents()
   * @return boolean succeeded
   */
  function perform_ticket_action($name,$email,$action,$ticket,$body,$params) {
    global $zen;
    global $egate_user;
    $success = true;

    // see if we have a valid system user
    // which we can apply here
    $user_id = find_user_id($name,$email);

    // extract the ticket id for convenience
    if( is_array($ticket) ) {
      $id = $ticket["id"];      
    }

    // check and see if this user is on the
    // notify list, otherwise they can't edit
    // anything about this ticket
    if( is_array($ticket) ) {
      $list = $zen->get_notify_recipients($id);
      if( !in_array($email,$list) 
	  && find_user_id($name,$email)==$egate_user["user_id"] ) {
	egate_log("Sorry, you aren't on the notify list for this ticket,"
		  ."and aren't a registered user.",2);
	return false;
      }
    }

    // make sure we have a valid string
    if( !isset($body["details"]) )
      $body["details"] = "";
    
    $body = check_magic_quotes($body);

    // format a name entry for logging
    $fullname = ($name)? "\"$name\" <$email>" : $email;

    // take an appropriate ticket action
    switch( $action ) {
    case "approve":
      {
	if( $user_id == $egate_user["user_id"] ) {
	  $body["details"] = "Approved by $fullname\n\n".$body["details"];
	}
	$res = $zen->approve_ticket($id,$user_id,$body["details"]);
	if( $res ) {
	  egate_log("Ticket was closed successfully",3);
	}
	else {
	  egate_log("Ticket could not be closed.",2);
	  $success = false;
	}
	break;
      }
    case "accept":
      {
	if( $user_id == $egate_user["user_id"] ) {
	  egate_log("Ticket could not be accepted, user $fullname not registered.",2);
	  $success = false;
	} else {
	  $res = $zen->accept_ticket($id,$user_id,$body["details"],$ticket["bin_id"]);
	  if( $res ) {
	    egate_log("Ticket was accepted",3);
	  }
	  else {
	    egate_log("Ticket could not be accepted.",2);
	    $success = false;
	  }
	}
	break;
      }
    case "assign":
      {
	// find the users id
	$txt = get_subject_param($params,"user",$body);
	if( preg_match("/[^0-9]/", $txt) ) {
	  $rec = find_user_id('',$txt);
	  if( $rec != $egate["user_id"] ) {
	    $uid = $rec;
	  }
	}
	else {
	  $uid = $txt;
	}
	if( $uid ) {
	  // if we have an id, do the assignment
	  if( $user_id == $egate_user["user_id"] ) {
	    $notes = "Assigned by $fullname";
	  }
	  if( $zen->assign_ticket($id,$uid,$user_id,$notes) ) {
	    egate_log("Ticket assigned to user $uid",3);
	  }
	  else {
	    egate_log("Ticket could not be assigned",2);
	    $success = false;
	  }	    
	}
	else {
	  // otherwise generate error
	  egate_log("Entry $txt not a valid user id or email address",2);
	  $success = false;
	}
	break;
      }
    case "close":
      {
	if( $user_id == $egate_user["user_id"] ) {
	  $body["details"] = "Closed by $fullname\n\n".$body["details"];
	}
	$hours = (isset($body["hours"]))? $body["hours"] : null;
	$res = $zen->close_ticket($id,$user_id,$hours,$body["details"]);
	if( $res ) {
	  egate_log("Ticket was closed successfully",3);
	}
	else {
	  egate_log("Ticket could not be closed",2);
	}
	break;
      }
    case "create":
      {
	// create a new ticket
	$res = create_new_ticket($user_id,$name,$email,$body);
	if( !$res )
	  $success = false;
	else
	  $success = $res;
	break;
      }
    case "view":
      {
	// set the recipients then fall through to the
	// next case
	$body["recipients"] = $email;
      }
    case "email":
      {
	// set up email params
	$mp["message"] = $body["details"];
	$mp["link"] = $id;
	$mp["tid"] = $id;
	$mp["log"] = $id;	
	// get a formatted message
	$message = $zen->formatEmailMessage($mp);
	// create a subject
	$subject = "Ticket #$id summary";
	// find out who recipients are
	$str = get_subject_param($params,"recipients",$body);
	if( strlen($str) ) {
	  $recipients = split("[ ,]+", $str);
	}
	if( is_array($recipients) ) {
	  // do the message
	  $err = $zen->sendEmail($recipients,$subject,$message,$user_id);
	  if( !$err ) {
	    egate_log("Ticket summary delivered: $str",3);
	    $success = true;
	  }
	  else {
	    egate_log("Deliver of ticket #$id to $str failed: $err",2);
	    $success = false;
	  }
	}
	else {
	  // no one to send to
	  egate_log("No recipients specified",2);
	  $success = false;
	}
	break;
      }
    case "estimate":
      {
	$hours = get_subject_param($params,"hours",$body);
	if( strlen($hours) ) {
	  $params = array("est_hours"=>$hours);
	  $res = $zen->update_ticket($id, $params);
	  if( $res ) {
	    egate_log("Estimated hours updated",3);
	    // create a ticket log
	    $name = $zen->formatName($user_id);
	    $log_entry = "{$action} added via egate system by $name";
	    $zen->add_log( $id, array('user_id' => $user_id, 
				      'bin_id'  => $ticket['bin_id'],
				      'entry'   => $log_entry,
				      'action'  => 'ESTIMATE') );
	  }
	  else {
	    egate_log("Estimate hours failed",2);
	    $success = false;
	  }
	}
	else {
	  egate_log("No hours were submitted",2);
	  $success = false;
	}
	break;
      }
    case "log":
      {
	if( $body["details"] ) {
	  $logParams = array(
			     "bin_id"    => $ticket["bin_id"],
			     "entry"     => $body["details"],
			     "user_id"   => $user_id,
			     "ticket_id" => $id
			     );
	  $logParams["hours"] = $zen->checkNum($body["hours"])?
	    $zen->checkNum($body["hours"]) : null;
	  if( isset($body["activity"]) 
	      && in_array(strtoupper($body["activity"]),$zen->getActivities()) ) {
	    $logParams["action"] = strtoupper($body["activity"]);
	  } else {
	    $logParams["action"] = "NOTE";
	  }
	  $res = $zen->log_ticket($id,$user_id,$logParams["action"],
				  $logParams["hours"], $logParams["entry"]);
	  if( $res ) {
	    egate_log("Log entry added",3);
	  }
	  else {
	    egate_log("Log entry failed",2);
	    $success = false;
	  }
	}
	else {
	  egate_log("Log entry failed, there was no message to add",2);
	  $success = false;
	}
	break;
      }
    case "move":
      {
	$binput = get_subject_param($params,"bin",$body);
	$bin_id = get_type_id("bins",$binput);
	if( $bin_id ) {
	  $res = $zen->move_ticket($id,$bin_id,$user_id,$body["details"]);
	  if( $res ) {
	    egate_log("moved to bin ".$zen->getBinName($bin_id),3);
	  }
	  else {
	    egate_log("couldn't move ticket to new bin.",2);
	    $success = false;
	  }
	}
	else {
	  $success = false;
	}
	break;
      }
    case "notify_add":
      {
	// add user to notify list
	$str = get_subject_param($params,"recipients",$body);
	$entries = array();
	if( !strlen(trim($str)) ) {
	  // add the sender
	  $em = array($zen->checkEmail($email));
	  $en = $name;
	  $fullname = "$en <$em>";
	  $vars = array("ticket_id" => $id,
			"priority"  => 1);
	  if( strlen($en) ) {
	    $vars["name"] = $en;
	  }
	  if( $user_id != $egate_user["user_id"] ) {
	    $vars["user_id"] = $user_id;
	  } else {
	    $vars["email"] = $em;
	  }
	  $entries = array($vars);
	}
	else {
	  // add the list
	  $list = split("[ ,]+", trim($str));
	  foreach($list as $l) {
	    // look for an id
	    $uid = find_user_id('',$l);
	    if( $uid != $egate["user_id"] ) {
	      $entries[] = array("user_id"=>$uid,"priority"=>1,"ticket_id"=>$id);
	    }
	    else {
	      $em = $zen->checkEmail($l);
	      $entries[] = array("email"=>$em,"priority"=>1,"ticket_id"=>$id);
	    }
	  }
	  $en = "";
	  $fullname = $em;
	}
	$i = 0;
	foreach($entries as $e) {
	  $n = ($e["user_id"])? "user id {$e['user_id']}":$e['email'];
	  $res = $zen->add_to_notify_list( $id, $e );
	  if( $res && $res != "duplicate" ) {
	    egate_log("added $n to notify for #$id",3);
	  } else if( $res && $res == "duplicate" ) {
	    egate_log("Recipient $n already on notify for #$id",3);
	    $success = false;
	  } else {
	    egate_log("Unable to add $n to notify for #$id",2);
	    $success = false;
	  } 
	}
	break;
      }
    case "notify_drop":
      {
	// grap the recipient to remove from the body["details"]
	// and send him bye bye
	$vals = split("[, \n]", $body["details"]);
	if( is_array($vals) && count($vals) ) {
	  $i = 0;
	  foreach($vals as $v) {
	    // see if it's an email, or a user_id
	    if( is_numeric($v) ) {	    
	      // user id
	      $res = $zen->drop_from_notify($v,$id);
	      if( $res ) { $i++; }
	      else { egate_log("user_id $v not found in #$id notify list",2); }
	    }
	    else if( str_pos("@",$v) ) {
	      // email address
	      $res = $zen->drop_notify_by_email($v,$id);
	      if( $res ) { $i++; }
	      else { egate_log("email $v not found in #$id notify list",2); }
	    }
	    else {
	      egate_log("$v was not a valid email address or user_id",2);
	    }
	  }
	  if( $i > 0 ) {
	    egate_log("$i recipients dropped from #$id notify list",3);
	  }
	  else {
	    // nobody was found to remove
	    egate_log("No recipients were found to remove from $id notify list",2);
	    $success = false;
	  }
	}
	break;
      }
    case "options":
      {
	// return a list of valid options for this ticket
	egate_store_template("options.template");
	egate_log("Returning options template",3);
	break;
      }
    case "reject":
      {
	if( $body["details"] ) {
	  $res = $zen->reject_ticket($id,$user_id,$body["details"]);
	  if( $res ) {
	    egate_log("Rejected to sender",3);
	  }
	  else {
	    egate_log("Could not reject ticket",2);
	    $success = false;
	  }
	}
	else {
	  egate_log("You must provide a reason when rejecting a ticket",2);
	  $success = false;
	}
	break;
      }
    case "remove":
      {
	// remove user from notify list
	$res = $zen->drop_notify_by_email($email,$id);
	if( $res ) {
	  egate_log("dropped $email from ticket $id notify list",3);
	}
	else {
	  egate_log("unable to remove $email from ticket $id notify list",2);
	  $success = false;
	}
	break;
      }
    case "template":
      {
	global $form_template_list;
	$str = strtolower(get_subject_param($params,"template",$body));
	if( in_array($str,$form_template_list) ) {
	  egate_store_template("form_$str.template", $id);
	  egate_log("returning $str form",3);
	}
	else {
	  egate_log("$str is an invalid template",2);
	  $success = false;
	}
	break;
      }
    case "test":
      {
	$hours = strlen($body["hours"])? $body["hours"] : null;
	$res = $zen->test_ticket($id,$user_id,$hours,$body["details"]);
	if( $res ) {
	  egate_log("ticket tested",3);
	}
	else {
	  egate_log("could not test ticket",2);
	  $success = false;
	}
	break;
      }
    default:
      {
	egate_log("Invalid action, could not be processed",1);
	$success = false;
      }
    }
    return $success;
  }

  /**
   * process raw message and create new ticket from contents
   *
   * @param string $input is the raw message data
   * @return boolen succeeded
   */
  function create_ticket_from_message($input) {
    // process the input data and return results
    $success = true;
    global $zen;
    global $egate_user;
    global $egate_default_options;
    global $egate_create_fields;
    global $egate_create_overrides;

    // decode the data
    $params = decode_contents($input);
    
    // validate the data
    if( !validate_params($params) ) { egate_log_write(); return false; }

    // create the body elements
    $body = $egate_default_options;
    $body["title"] = $params->headers["subject"];
    $body["details"] = trim($params->body);
    $body["creator_id"] = $egate_user["user_id"];

    // add in overrides, if the user has specified any by putting
    // 'field:value' entries at the top of the message body
    if( $egate_create_overrides == 1 && count($egate_create_fields) > 0 ) {
      $i=0;
      $match = '/^ *('.join('|',$egate_create_fields).') *: *(.+)/i';
      while( preg_match( $match, $body['details'], $matches) && $i < 1000 ) {
	$body["{$matches[1]}"] = trim($matches[2]);
	$body['details'] = trim(preg_replace($match, '', $body['details']));
	$i++;
      }
    }

    // determine who sent the email and make sure it has
    // a return address
    list($name,$email) = get_name_and_email($params);
    $user_id = find_user_id($name,$email);

    // don't process tickets with no return address
    if( !$email ) {
      egate_log("No return email address",2);
      $success = false;
    }    
    
    // create the ticket
    if( $success ) {    
      $id = create_new_ticket($user_id,$name,$email,$body);
    }

    // todo: send a reply email
    $rec = array(array("name"=>$name,"email"=>$email));
    $rep = send_reply_mail( $rec, $id, $success, "new ticket" );
    if( !$rep ) {
      egate_log("reply email failed to $name <$email>",2);
    }

    // close up shop
    egate_log_write();
    return $success;
  }

  /**
   * parse out the user's email address and name
   *
   * @param $params is the output from decode_contents()
   * @return array (name,email)
   */
  function get_name_and_email($params) {
    // initialize
    $name = "";
    $email = "";
    
    // set up the return email address
    // and the user's name, if it can be found
    $email = $params->headers["reply-to"]? 
      trim($params->headers["reply-to"]) : trim($params->headers["from"]);
    if( preg_match("/([^<]*)<([a-zA-Z0-9_@.-]+)>/", $email, $matches) ) {
      $name = trim($matches[1]);
      $email = trim($matches[2]);
    }
    if( !$name ) {
      if( preg_match("/([^<]*)<([a-zA-Z0-9_@.-]+)>/", 
		     $params->headers["from"], 
		     $matches) ) {
	$name = trim($matches[1]);
      }
      else {
	$name = "unknown";
      }
    }
    $name = preg_replace('/["\'<>]/',"",$name);
    $email = preg_replace('/["\'<>]/',"",$email);
    return array($name,$email);
  }
  
  /**
   * process raw message and take appropriate actions 
   *
   * @param string $input is the raw message data
   * @return boolean succeeded
   */ 
  function process_message($input) {
    // process the input data for an email and return results
    $success = true;     
    global $valid_actions;
    global $zen;
    global $egate_user;

    // check for input
    if( $input == "" ) {
      egate_log("input stream was empty",2);
      return;
    }

    // decode the data
    $params = decode_contents($input);

    // validate the data
    if( !validate_params($params) ) { $success = false; }
    
    // find out what action we are taking
    $res = parse_subject($params);
    if( is_array($res) ) {
      list($action,$ticket) = $res;
    } 
    else { $success = false; }    

    // retrieve the contents from the body
    // of the email
    $body = parse_message_body($params->body);
    list($name,$email) = get_name_and_email($params);

    // don't process tickets with no return address
    if( !$email ) {
      egate_log("No return email address",2);
      $success = false;
    }
    
    if( $success ) {
      // peform the action
      $success = perform_ticket_action($name,$email,$action,$ticket,$body,$params);
    }

    if( strtolower(trim($action)) == "create" ) {
      $id = $success;
      $ticket = $zen->get_ticket($id);
    }

    // todo: send a reply email
    $rec = array(array("name"=>$name,"email"=>$email));
    $rep = send_reply_mail( $rec, $ticket["id"], $success, $action );
    if( !$rep ) {
      egate_log("reply email failed to $name <$email>",2);
    }

    // write the log entry
    egate_log_write();

    // todo: fix user_id to match person sending, rather than egate for
    //       checking owner of ticket/valid actions

    // success
    return $success;
  }

  /**
   * make an email reply for the sender
   * 
   * this will send a reply to the person
   * who submitted the entry, compliant
   * with $egate_notify_level
   *
   * @param array $recipients is an indexed array of email addresses and names (names optional)
   * @param integer $id is the tickets id
   * @param boolean $success is whether action was completed successfully
   * @param string $action is the action taken
   * @return integer number of emails sent
   */
  function send_reply_mail( $recipients, $id, $success, $action ) {    
    // employ $egate_notify_level (0-3)
    global $egate_notify_level;
    global $libDir;
    global $egate_user;
    global $zen;
    global $egate_bcc_address;
    
    // get the messages
    $messages = egate_fetch_messages($egate_notify_level);
    $templates = egate_fetch_templates();
    
    // send an email if we have data
    if( (is_array($messages)&&count($messages))
	||(is_array($templates)&&count($templates)) ) {
      $text = "";
      
      if( !is_array($templates) || !count($templates) ) {
	$templates = array("reply.template");
      }

      // grab the params
      $valid_actions = fetch_valid_actions($id);      
      $vals = array("success"  =>   $success,
		    "id"       =>   $id,
		    "messages" =>   $messages,
		    "action"   =>   $action,
		    "valid_actions" => $valid_actions);
      
      // create header
      $temp = new zenTemplate("$libDir/templates/email/heading.template");
      $temp->values($vals);
      $txt .= $temp->process();

      if( $id > 0 && !in_array($action,array("help","template")) ) {
	// create reply
	$temp = new zenTemplate("$libDir/templates/email/reply.template");
	$temp->values($vals);
	$txt .= $temp->process();
	$subject = "Ticket #$id: results";
	$subject .= ($success)? " (successful)" : " (failed)";
      }
      else if( $action == "template" ) {
	$subject = egate_get_subject();
	// get ticket fields we may need
	$vals = fetch_template_vals($vals);
      }
      else if( $action ) {
	$subject = "Re: $action ";
	$subject .= ($success)? " (successful)" : " (failed)";
      } else {
	$subject = "request ".($success? "(successful)":"(failed)");
      }
      
      // include extra footer templates
      if( is_array($templates) ) {
	// run through templates
	foreach( $templates as $t ) {
	  $temp = new zenTemplate("$libDir/templates/email/$t");
	  $temp->values($vals);
	  $txt .= $temp->process();
	}
      }
      
      if( $action != "help" && $action != "template" ) {
	// create footer	
	$temp = new zenTemplate("$libDir/templates/email/footer.template");
	$temp->values($vals);	
	$txt .= $temp->process();
      }

      $subject = "[".$zen->getSetting("bot_name")."] ".$subject;

      // send messages
      $i=0;
      $from = $egate_user["email"];
      $bcc = $egate_bcc_address? "Bcc:$egate_bcc_address\r\n" : "";
      foreach($recipients as $r) {
        if( is_array($r) && count($r) && $r["email"] != $egate_user["email"] ) {
        $res = mail($r['email'],$subject,$txt,"From:$from\r\nReply-to:$from\r\n$bcc");
        if( $res )
          $i++;
        }
      }
      return $i;
    }
    // if we skipped the results, we sent 0 emails
    return 0;
  }

}?>
