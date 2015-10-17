<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<?php {
  unset($params);
  unset($orderby);
  
if(!$search_text){
	$errs[] = tr("No valid fields were provided to conduct a search");
	}

switch ($table) {
    case "company":
        $search_fields = array(
  				"title"       => "title",
		  		"office"    => "office",
		  		"description" => "description",
		  		"address1"       => "address1",
		  		"address2"      => "address2",
		  		"address3"      => "address3",
		  		"postcode"    => "postcode",
		  		"place"      => "place",
		  		"telephone"    => "telephone",
		  		"fax"   => "fax",
		  		"country"   => "country",
		  		"email"    => "email",
		  		"website"  => "website",
		  	);
		  
				$tables = $zen->table_company;	
				$orderby="company_id DESC";
        break;
        
    case "employee":
       $search_fields = array(
  			"fname"       => "fname",
		  	"lname"    => "lname",
		  	"initials" => "initials",
		  	"jobtitle"       => "jobtitle",
		  	"department"      => "department",
		  	"email"      => "email",
		  	"telephone"    => "telephone",
		  	"mobiel"      => "mobiel",
		  	"description"   => "description",
		  );
			$tables = $zen->table_employee;
			$orderby="person_id DESC";
      break;
      
    case "agreement":
       $search_fields = array(
  			"contractnr"       => "contractnr",
		  	"title"    => "title",
		  	"description"   => "description",
		  );
			$tables = $zen->table_agreement;
			$orderby="agree_id DESC";
      break;
      
      case "item":
       $search_fields = array(
		  	"name1"    => "name1",
		  	"description1"   => "description1",
		  );
			$tables = $zen->table_agreement_item;
			$orderby="item_id DESC";
      break;
      
    default:
			$errs[] = tr("No valid fields were provided to conduct a search");
			unset($tables);
} 	
	
  // see if there is a text search and
  // if so, then see what fields are to
  // be searched
  if( $search_text && is_array($search_fields) && count($search_fields)>0 ) {
    unset($sp);
    foreach($search_fields as $k=>$f) {
      $sp[] = array($f,"contains",$search_text);
    }
    $params[] = (count($sp)>1)? array("OR",$sp) : $sp[0];
  }


  unset($contacts);
if (!$errs) {
    $tickets = $zen->search_contacts($params, "AND",$orderby,$tables);//"status DESC, priority DESC"
  }
}?>
    