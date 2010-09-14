<?php
//For these settings use 1 (yes) or 0 (no)
  $mailOwner=1;
  $mailManager=1;
  $mailTester=1;
  $mailNotifylist=1;
  $includeProjects=0;
  $includePending=0;

//Fill these with the text you want to use in tha notification emails
  $mailSubject="Overdued tickets";
  $mailHeader="This is an automatic message from zenTrack";

//Here you can include a list of users who should never receive notification emails (use full lowercase)
  $ignoreMailsTo=array("dontsend@mails.to.me",
                       "neither@for.me");

//The following lines should be copied from your header.php file
  $libDir = "/home/zen/zentrack_2/includes";
  $rootUrl = "http://your.root.url";
  $Db_Type      = "mysql";      //sql type
  $Db_Instance  = "mybase";       //db name
  $Db_Login     = "myuser";   //username
  $Db_Pass      = "mypass";   //password
  $Db_Host      = "localhost";  //host of database
  $page_prefix = "zenTrack | ";
  $page_title = "Welcome to zenTrack";
  $configFile = "$libDir/configVars.php";
  $system_message_limit = 20;
  setlocale(LC_TIME, "es_AR.iso88591");
//You shouldn't touch anything after here
//==============================================================
  include_once("$libDir/translator.class.php");
  include_once("$libDir/zenTrack.class.php");
  include_once("$libDir/zenTemplate.class.php");
  $zen = new zenTrack( $configFile );
  $managers=array();
  $testers=array();

  /**
   * Translator Object Initialization (mlively)
   */
  // set language to default if unspecified
  if( !$login_language ) {
    $login_language = $zen->getSetting("language_default");
  }

  //Create the initialization array for the translator object
  //this data set also appears in the egate_utils.php script
  $translator_init = array(
     'domain' => 'translator',
     'path' => "$libDir/translations",
     'locale' => $login_language
  );
  $translator_init['zen'] =& $zen;
  tr($translator_init);
  //save a bit on memory
  unset($translator_init);

  $mainQuery= "SELECT user_id, email, lname, fname FROM ".$zen->table_users;
  $vars = $zen->db_queryIndexed($mainQuery);
  if (is_array($vars) && count($vars)) {
    $users=array();
    foreach($vars as $v) {
      $i=$v["user_id"];
      unset($v["user_id"]);
      $users[$i]=$v;
    }
  }
  $mainQuery= "SELECT bid FROM ".$zen->table_bins." WHERE active=1";
  $vars = $zen->db_queryIndexed($mainQuery);
  if (is_array($vars) && count($vars)) {
    if ($mailManager) {
      foreach($vars as $v) {
        $list=$zen->fetch_bin_roles( $v["bid"], 'manager' );
        if (is_array($list) && count($list)) {
          $managers[$v["bid"]]=array();
          foreach($list as $u) {
            $em=$users[intval($u["user_id"])]["email"];
            if(!is_null($em)) {
              $managers[$v["bid"]][]=$em;
            }
          }
        }
      }
    }
    if ($mailTester) {
      foreach($vars as $v) {
        $list=$zen->fetch_bin_roles( $v["bid"], 'tester' );
        if (is_array($list) && count($list)) {
          $testers[$v["bid"]]=array();
          foreach($list as $u) {
            $em=$users[intval($u["user_id"])]["email"];
            if(!is_null($em)) {
              $testers[$v["bid"]][]=$em;
            }
          }
        }
      }
    }
  }

  $mainQuery="SELECT id, title, otime, status, bin_id, deadline, bin_id, ZB.name BIN_NAME, ZY.name TYPE_NAME, "
            ."       ZT.user_id, ZT.priority PID, email, ZP.name PRIORITY_NAME "
            ."FROM ".$zen->table_tickets." ZT, ".$zen->table_types." ZY, ".$zen->table_bins." ZB, ".$zen->table_priorities." ZP "
            ."     LEFT JOIN ".$zen->table_users." ZU ON ZT.user_id=ZU.user_id "
            ."WHERE ZT.bin_id=ZB.bid AND ZT.type_id=ZY.type_id AND ZB.active=1 AND ZT.priority=ZP.pid"
            ."     AND deadline<".$zen->currTime." AND deadline>0 AND (ctime IS NULL OR ctime=0) ";
  if ($includeProjects==0) {
    $mainQuery.="     AND ZY.name NOT LIKE '%project%' ";
  }
  if ($includePending==1) {
    $mainQuery.="     AND status<>'CLOSED' ";
  } else {
    $mainQuery.="     AND status='OPEN' ";
  }
  $mainQuery.="ORDER BY PID, status, id";
  $tickets = $zen->db_queryIndexed($mainQuery);
  if( is_array($tickets) && count($tickets) ) {
    $ticketsByID=array();
    foreach($tickets as $t) {
      $ticketsByID[$t["id"]]=$t;
      if($mailOwner==1 && isset($t["email"])) {
        $notification[$t["email"]][$t["BIN_NAME"]][intval($t["id"])]=1;
      }
      if(isset($managers[intval($t["bin_id"])])) {
        foreach ($managers[intval($t["bin_id"])] as $email) {
          $notification[$email][$t["BIN_NAME"]][intval($t["id"])]=1;
        }
      }
      if(isset($testers[intval($t["bin_id"])])) {
        foreach ($testers[intval($t["bin_id"])] as $email) {
          $notification[$email][$t["BIN_NAME"]][intval($t["id"])]=1;
        }
      }
    }
  }
  $headers = "Subject: $mailSubject \n"
            ."Content-Type: text/html; charset=\"iso-8859-1\"\n";
  foreach ($notification as $mailTo => $v)
  {
    if( !in_array(strtolower($mailTo), $ignoreMailsTo) )  {

      $message = "
<html>
  <head>
    <title>Overdue Notification</title>
  </head>
  <body><b>".$mailHeader."</b><br><br>";
      foreach($v as $bin => $ids) {
        $message.="<br><b>$bin</b><br>
    <table width='100%' cellspacing='1' cellpadding='2' bgcolor='".$zen->getSetting("color_alt_background")."'>
      <tr bgcolor='".$zen->getSetting("color_title_background")."'>
        <td height='25' valign='middle' width='32'>
          <div align='center'><span style='color: rgb(255, 255, 255);'><b><span class='small'>".tr("ID")."</span></b></span></div>
        </td>
        <td height='25' valign='middle'>
          <div align='center'><span style='color: rgb(255, 255, 255);'><b><span class='small'>".tr("Title")."</span></b></span></div>
        </td>
        <td height='25' valign='middle' width='32'>
          <div align='center'><span style='color: rgb(255, 255, 255);'><b><span class='small'>".tr("Pri")."</span></b></span></div>
        </td>
        <td height='25' valign='middle' width='32'>
          <div align='center'><span style='color: rgb(255, 255, 255);'><b><span class='small'>".tr("Status")."</span></b></span></div>
        </td>
        <td height='25' valign='middle' width='32'>
          <div align='center'><span style='color: rgb(255, 255, 255);'><b><span class='small'>".tr("Type")."</span></b></span></div>
        </td>
        <td height='25' valign='middle' width='60'>
          <div align='center'><span style='color: rgb(255, 255, 255);'><b><span class='small'>".tr("Open Time")."</span></b></span></div>
        </td>
        <td height='25' valign='middle' width='60'>
          <div align='center'><span style='color: rgb(255, 255, 255);'><b><span class='small'>".tr("Deadline")."</span></b></span></div>
        </td>
        <td height='25' valign='middle' width='40'>
          <div align='center'><span style='color: rgb(255, 255, 255);'><b><span class='small'>".tr("Owner")."</span></b></span></div>
        </td>
      </tr>";

        foreach($ids as $id => $one) {  
          $link=$rootUrl."/ticket.php?id=".$id;
          if ( isset($users[$ticketsByID[$id]["user_id"]]["email"]) && strlen($users[$ticketsByID[$id]["user_id"]]["email"]) ) {
            $userinfo="<a href='mailto:".$users[$ticketsByID[$id]["user_id"]]["email"]
                     ."'>".$users[$ticketsByID[$id]["user_id"]]["lname"].", "
                     .$users[$ticketsByID[$id]["user_id"]]["fname"]."</a>";
          } else {
            $userinfo=$users[$ticketsByID[$id]["user_id"]]["lname"].", ".$users[$ticketsByID[$id]["user_id"]]["fname"];
          }
          $message.="
      <tr>
        <td height='25' valign='middle'>
          <a href='$link'>$id</a>
        </td>
        <td height='25' valign='middle'>
          <a href='$link'>".substr($ticketsByID[$id]["title"],0,40)."</a>
        </td>
        <td height='25' valign='middle'>
          <a href='$link'>".$ticketsByID[$id]["PRIORITY_NAME"]."</a>
        </td>
        <td height='25' valign='middle'>
          <a href='$link'>".$ticketsByID[$id]["status"]."</a>
        </td>
        <td height='25' valign='middle'>
          <a href='$link'>".$ticketsByID[$id]["TYPE_NAME"]."</a>
        </td>
        <td height='25' valign='middle'>
          <a href='$link'>".$zen->showDateTime($ticketsByID[$id]["otime"])."</a>
        </td>
        <td height='25' valign='middle'>
          <a href='$link'>".$zen->showDateTime($ticketsByID[$id]["deadline"])."</a>
        </td>
        <td height='25' valign='middle'>
          $userinfo
        </td>
      </tr>";
        }
        $message.="
    </table>";
      }



      $message.="
  </body>
</html>";
      mail($mailTo, $mailSubject, $message, $headers);
    }
  }
?>
