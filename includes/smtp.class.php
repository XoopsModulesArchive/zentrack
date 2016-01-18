<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  /**************************************************************************\
  * smtp mailer                                                              *
  * Written by Itzchak Rehberg <izzysoft@qumran.org>                         *
  * ------------------------------------------------                         *
  *  This module should replace php's mail() function. It is fully syntax    *
  *  compatible. In addition, when an error occures, a detailed error info   *
  *  is stored in the array $smtp->err                                       *
  * ------------------------------------------------------------------------ *
  * It is recommended to define YOUR local settings.   Please, do so only in *
  * the function send() - unless you are really sure what you are doing!     *
  \**************************************************************************/

  /* $Id: smtp.class,v 1.2 2005/05/02 06:59:35 phpzen Exp $ */

# echo "<!-- *** " . basename(__FILE__) . " starts here. *** -->\n";

class smtp {

    var $err       = array("code","msg","desc");
    var $to_res    = array();
    
    function smtp() {
      global $HOSTNAME, $zen;
      if ($zen->hostname) {
        $this->hostname    = $zen->hostname;
      } else {
        $this->hostname    = $HOSTNAME;
      }
      if ( !strpos($this->hostname,".") ) $this->hostname .= ".einsurance.de";
      $this->fromuser    = $zen->fromuser;
      $this->smtpserver  = $zen->smtpserver;
      $this->port        = 25;
      $this->mimeversion = "1.0";
      $this->charset     = "iso-8859-1";
      // don't change anything below here - unless you know what you're doing!
      $this->err["code"] = "000";
      $this->err["msg"]  = "init";
      $this->err["desc"] = "Session is just initializing.";
    }

 // ==================================================[ some sub-functions ]===

 function socket2msg($socket) {
   $followme = "-"; $this->err["msg"] = "";
   do {
     $rmsg = fgets($socket,255);
//     echo "< $rmsg<br>\n";
     $this->err["code"] = substr($rmsg,0,3);
     $followme = substr($rmsg,3,1);
     $this->err["msg"] = substr($rmsg,4);
     if (substr($this->err["code"],0,1) != 2 && substr($this->err["code"],0,1) != 3) {
       $rc  = fclose($socket);
       return false;
     }
     if ($followme = " ") { break; }
   } while ($followme = "-");
   return true;
 }

 function msg2socket($socket,$message) { // send single line\n
//  echo "> $message<BR>\n";
  $rc = fputs($socket,"$message");
  if (!$rc) {
    $this->err["code"] = "420";
    $this->err["msg"]  = "lost connection";
    $this->err["desc"] = "Lost connection to smtp server.";
    $rc  = fclose($socket);
    return false;
  }
  return true;
 }

 function put2socket($socket,$message) { // check for multiple lines 1st
  $this->err["code"] = "000";
  $this->err["msg"]  = "init";
  $this->err["desc"] = "The session is still to be initiated.";
  $pos = strpos($message,"\n");
  if (!is_int($pos)) { // no new line found
    $message .= "\n";
    $this->msg2socket($socket,$message);
  } else {                         // multiple lines, we have to split it
    do {
      $msglen = $pos + 1;
      $msg = substr($message,0,$msglen);
      $message = substr($message,$msglen);
      $pos = strpos($msg,"\n");
      if (!is_int($pos)) { // line not terminated
        $msg .= "\n";
      }
      $pos = strpos($msg,".");  // escape leading periods
      if (is_int($pos) && !$pos):
        $msg = "." . $msg;
      endif;
      if (!$this->msg2socket($socket,$msg)): return false; endif;
      $pos = strpos($message,"\n");
    } while (strlen($message)>0);
  }
  return true;
 }

 function check_header($to,$subject,$header) { // check if header contains subject and
                                               // recipient and is correctly terminated
  // first we check for the subject
  if ( !(is_string($subject) && !$subject) ) { // subject specified?
   $theader = strtolower($header);
   $nl  = strpos($theader,"\nsubject:"); // found after a new line
   $beg = strpos($theader,"subject:");   // found at start
   if ( !(is_int($nl)) || (is_int($beg) && !$beg) ) {
    $subject = "Subject: " . stripslashes($subject);
    $pos = substr($subject,"\n");
    if (!is_int($pos)) $subject .= "\n";
    $header .= $subject;
   }
  }
  // now we check for the recipient
  if ( !(is_string($to) && !$to) ) { // recipient specified?
   $nl  = strpos($theader,"\nto:"); // found after a new line
   $beg = strpos($theader,"to:");   // found at start
   if ( !(is_int($nl)) || (is_int($beg) && !$beg) ) {
    $pos = substr($to,"\n");
    if (!is_int($pos)) $subject .= "\n";
    $to = "To: " .$to ."\n";
    $header .= $to;
   }
  }
  // so what about the mime version...
  $nl  = strpos($theader,"\nmime-version:"); // found after a new line
  $beg = strpos($theader,"mime-version:");   // found at start
  if ( !(is_int($nl)) || (is_int($beg) && !$beg) ) {
   $header .= "MIME-Version: " . $this->mimeversion . "\n";
  }
  // and the content type?
  $nl  = strpos($theader,"\ncontent-type:"); // found after a new line
  $beg = strpos($theader,"content-type:");   // found at start
  if ( !(is_int($nl)) || (is_int($beg) && !$beg) ) {
   $header .= "Content-type: text/plain; charset=" . $this->charset . "\n";
  }
  // now we complete the header (make sure it's correct terminated)
  $header = chop($header);
  $header .= "\n";
  return $header;
 }

 function make_header($to,$subject) { // generate the mails header
  $now = getdate();
  $header  = "Date: " . gmdate("D, d M Y H:i:s") . " +0000\n";
  $header .= "To: $to\n";
  $header .= "Subject: " . stripslashes($subject) . "\n";
  $header .= "MIME-Version: " . $this->mimeversion . "\n";
  $header .= "Content-type: text/plain; charset=" . $this->charset . "\n";
  return $header;
 }

 // ==============================================[ main function: smail() ]===

 function smail($to,$subject,$message,$header="") {
  $errcode = ""; $errmsg = ""; // error code and message of failed connection
  $timeout = 5;                // timeout in secs

  // now we try to open the socket and check, if any smtp server responds
  $socket = fsockopen($this->smtpserver,$this->port,$errcode,$errmsg,$timeout);
  if (!$socket) {
    $this->err["code"] = "420";
    $this->err["msg"]  = "$errcode:$errmsg";
    $this->err["desc"] = "Connection to $smtpserver:$port failed - could not open socket.";
    return false;
  } else {
    $rrc = $this->socket2msg($socket);
  }

  // now we can send our message. 1st we identify ourselves and the sender
  $cmds = array (
     "\$src = \$this->msg2socket(\$socket,\"HELO \$this->hostname\n\");",
     "\$rrc = \$this->socket2msg(\$socket);",
     "\$src = \$this->msg2socket(\$socket,\"MAIL FROM:<\$this->fromuser>\n\");",
     "\$rrc = \$this->socket2msg(\$socket);"
  );
  for ($src=true,$rrc=true,$i=0; $i<count($cmds);$i++) {
   eval ($cmds[$i]);
   if (!$src || !$rrc) return false;
  }

  // now we've got to evaluate the $to's
  $toaddr = explode(",",$to);
  $numaddr = count($toaddr);
  for ($i=0; $i<$numaddr; $i++) {
    $src = $this->msg2socket($socket,"RCPT TO:<$toaddr[$i]>\n");
    $rrc = $this->socket2msg($socket);
    $this->to_res[$i][addr] = $toaddr[$i];     // for lateron validation
    $this->to_res[$i][code] = $this->err["code"];
    $this->to_res[$i][msg]  = $this->err["msg"];
    $this->to_res[$i][desc] = $this->err["desc"];
  }

  //now we have to make sure that at least one $to-address was accepted
  $stop = 1;
  for ($i=0;$i<count($this->to_res);$i++) {
    $rc = substr($this->to_res[$i][code],0,1);
    if ($rc == 2) { // at least to this address we can deliver
      $stop = 0;
    }
  }
  if ($stop) return false;  // no address found we can deliver to

  // now we can go to deliver the message!
  if (!$this->msg2socket($socket,"DATA\n")) return false;
  if (!$this->socket2msg($socket)) return false;
  if ($header != "") {
    $header = $this->check_header($to,$subject,$header);
  } else {
    $header = $this->make_header($to,$subject);
  }
  if (!$this->put2socket($socket,$header)) return false;
  if (!$this->put2socket($socket,"\n")) return false;
  $message  = chop($message);
  $message .= "\n";
  if (!$this->put2socket($socket,$message)) return false;
  if (!$this->msg2socket($socket,".\n")) return false;
  if (!$this->socket2msg($socket)) return false;
  if (!$this->msg2socket($socket,"QUIT\n")) return false;
  Do {
   $closing = $this->socket2msg($socket);
  } while ($closing);
  return true;
 }

} // end of class
?>