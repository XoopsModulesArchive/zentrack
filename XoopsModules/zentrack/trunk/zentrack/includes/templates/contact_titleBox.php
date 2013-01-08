<?php if( !ZT_DEFINED ) { die("Illegal Access"); }
   $hotkeys->loadSection('contacts_view');
   $GLOBALS['zt_hotkeys'] = $hotkeys;
?>
<table cellpadding="0" width='600' cellspacing="1">
  <tr>
   <td><table
     align="center" width='100%'>     
     <tr>
       <td valign="top"><table border="0"
          width='100%' class='formtable' cellpadding="0" cellspacing="1">
          
    <tr>
	   <td class="subTitle" colspan="3"><p align="center"><?php echo $zen->ffv($title)." "; if(!empty($office)){ echo "[".$zen->ffv($office)."]";}?> </p></td>
	  </tr>
	  <tr>
	   <td class="headerCell" colspan="2" width="50%"><?=uptr("Info")?></td>
	   <td class="headerCell"  width="50%"><?=uptr("Address")?></td>
	  </tr>
	  <tr>
	   <td class="bars indent boxpad" colspan="2">
	   <?php
	   if(!empty($office)){ echo $zen->ffv($office)."<br>";}
	   if(!empty($email)){?><A HREF="mailto:<?=$zen->ffv($email)?>"><?=$zen->ffv($email)?></A><br><?}
	   if ($website == "http://" or $website == "") {
		 echo "<br>";  
		 } else {
	   if(!empty($website)){?><A TARGET="_blank" HREF="<?=$zen->ffv($website)?>"><?=$zen->ffv($website)?></A><?}}?>
	   </td>
	   <td class="bars small" rowspan="4">
           <?php
	   if(!empty($address1)){ echo $zen->ffv($address1)."<br>";}
	   if(!empty($address2)){ echo $zen->ffv($address2)."<br>";}
	   if(!empty($address3)){ echo $zen->ffv($address3)."<br>";}
	   if(!empty($postcode)){ echo $zen->ffv($postcode)."<br>";}
	   if(!empty($place)){ echo $zen->ffv($place)."<br>";}
	   if(!empty($pobox)){ echo $zen->ffv($pobox)."<br>";}
	   if(!empty($postcode2)){ echo $zen->ffv($postcode2)."<br>";}
	   if(!empty($country)){ echo $zen->ffv($country);}
	   ?>
	   </td>
	  </tr>
	  <tr>
	   <td class="headerCell" colspan="2"><?=uptr("Numbers")?></td> 
	  </tr>
	  <tr>
	   <td class="bars small" width="20%"><?=tr("Telephone no")?>:</td>  
	   <td class="bars small" width='30%'><?=$telephone? $zen->ffv($telephone) : '&nbsp;'?></td>
	  </tr>
	  <tr>
	   <td class="bars small"><?=tr("Fax no")?>:</td> 
	   <td class="bars small"><?=$fax? $zen->ffv($fax) : '&nbsp;'?></td> 
	  </tr>
               <?php
 if(!empty($description)) {
?>	  
	  <tr>
	   <td class="headerCell" colspan="3"><?=uptr("Comments")?></td>  
	  </tr>
	  <tr>
	   <td class="bars small" colspan="3"><?= $zen->ffvText($description) ?></td>
	  </tr>
 <?php
}
?>
	 </table></td>
       <td valign="top" width='75'>
       
<table width="120" cellpadding="0" cellspacing="3" border="0">
    <?php
			
	//1=show ADD 0=don't show ADD
      
  //button to show open tickets
  		print "<tr><td>";
      renderDivButtonFind("View Tickets");
      print "</td></tr>";

   if ($overview != "agreement") {
  	  print "<tr><td>";
      renderDivButtonFind("View Agreements");
      print "</td></tr>";
	} else {
  	  print "<tr><td>";
      renderDivButtonFind("View Employees");
      print "</td></tr>";
	}

  $actions = array(
			"employee"  => 1,
			"agreement" => 1,
			"edit"      => 0,			
			"delete"    => 0
			);	
	//show the buttons
	foreach($actions as $a=>$v) {
		$value = ($v == 1)? "Add ".ucfirst($a) : ucfirst($a);
		print "<tr><td>";
    renderDivButtonFind($value);
    print "</td></tr>";
  }
  
?>
</table>
     </td>
     </tr>
    </table></td>
  </tr>
</table>
<br>

