<?
/**
 * This file depends on the $_GET['formset'] value to provide a list
 * of forms that will be managed.  If that list is not
 * provided than this javascript will be of little use.
 *
 * The form names can simply be separated by a space (or a single form name is fine)
 */

  include_once(dirname(__FILE__)."/header.php");  
  $behaviors = $zen->getBehaviorList();
  $groups = $_SESSION['data_groups'];

  /**
   * Generate field info for behaviors
   *
   * @param integer $bid behavior id
   * @param array $fields the fields to generate
   * @param array $fieldMap the map of fields to behaviors
   * @param string $setid identifier used to retrieve these later (defaults to 'default')
   */
   function genBehaviorFields($bid, $fields, &$fieldMap, $setid = 'default') {
     global $zen;
     // create a new set of matches
     foreach($fields as $f) {
       $fkey = $f['field_name'];
       // store the field to behavior mappings for use later
       if( !is_array($fieldMap["$fkey"]) ) { $fieldMap["$fkey"] = array(); }
       if( !in_array($bid, $fieldMap["$fkey"]) ) {
         $fieldMap["$fkey"][] = $bid;
       }
       
       // here we are going to try to parse the field values into
       // a simple integer date that can be used for comparisons
       $val = $f['field_value'];
       if( strpos($f['field_name'], '_date') > 0 ) {
         // can't be the first character, so 0 is not a concern
         $val = $zen->dateParse($val);
       }
       
       // create the behavior fields objects
       print "  behaviorMap['$bid'].addField(";
       print $zen->fixJsVal($f['field_name']);
       print ','.$zen->fixJsVal($f['field_operator']);
       print ','.$zen->fixJsVal($val);
       print ','.$zen->fixJsVal($setid);
       print ");\n";
     }
   }
   
   /**
    * Generate fields for groups
    *
    * @param integer $group_id
    * @param array $values
    * @param string $setid identifier used to retrieve these later (defaults to 'default')
    */
    function genGroupFields( $group_id, $values, $setid = 'default' ) {
      global $zen;
      for($i=0; $i < count($values); $i++) {
        // add all fields used for matching to the group map entry
        $f = $values[$i];
        if( is_array($f) ) {
          $v = $f['field_value'];
          $l = $f['label'];
        }
        else {
          $v = $l = $f;
        }
        print "  groupMap['$group_id'].addField(";
        print $zen->fixJsVal($v);
        print ','.$zen->fixJsVal($l);
        print ','.$zen->fixJsVal($setid);
        print ");\n";
      }      
    }
    
    $mode = $zen->checkAlpha($_GET['mode']);
    if( !$mode ) { $mode = 'view'; }
    $userBins = $zen->getUsersBins($login_id,"level_$mode");  
  
?>
//<pre>

/**
 * Create a behavior map entry
 */
function BehaviorMapEntry(group_id, name, matchall, field, disabled) {
  this.group_id = group_id;
  this.name = name;
  this.matchall = matchall;
  this.field = field;
  this.fields = new Array();
  this.disabled = disabled;
}

BehaviorMapEntry.prototype.addField = function(name, operator, value, setid) {
  if( !setid ) { setid = 'default'; }
  if( !this.fields[setid] ) { this.fields[setid] = new Array(); }
  this.fields[setid][ this.fields[setid].length ] = new BehaviorMapField( name, operator, value );    
}

BehaviorMapEntry.prototype.getFields = function( setid ) {
  if( !setid ) { setid = 'default'; }
  return this.fields[setid]? this.fields[setid] : new Array();
}

/**
 * Create a field in a behavior map
 */
function BehaviorMapField(name, operator, value) {
  this.name = name;
  this.operator = operator;
  // always store value in lower case for case insensitive matching
  this.value = (typeof value == 'string')? value.toLowerCase() : ((typeof value == 'undefined')? null : value);
}

/**
 * Create a group map entry
 */
function GroupMapEntry(id, name, table, evalType, evalText) {
  this.id = id;
  this.name = name;
  this.table = table;
  this.evalType = evalType;
  this.evalText = evalText;
  this.fields = new Array();
}

GroupMapEntry.prototype.addField = function(value, label, setid) {
  if( !setid ) { setid = 'default'; }
  if( !this.fields[setid] ) { this.fields[setid] = new Array(); }
  if( !label ) { label = value; }
  this.fields[setid][ this.fields[setid].length ] = new GroupMapField( value, label );    
}

GroupMapEntry.prototype.getFields = function( setid ) {
  if( !setid ) { setid = 'default'; }
  behaviorDebug(3, "(GroupMapEntry.getFields("+setid+"): "+this.fields[setid]);
  return this.fields[setid]? this.fields[setid] : new Array();
}

function GroupMapField(value, label) {
  this.value = value;
  this.label = label;
}

<?
  // Generate an array of possible values that can be accessed from Javascript
  $possible_variables=array('login_id',
                            'login_name',
                            'login_language',
                            'login_inits',
                            'username');
  print "var jsVarNames = new Array();\n";
  print "var jsVarValues = new Array();\n";
  foreach ($possible_variables as $vn) {
    $vv=$$vn;
    print "  jsVarNames[ jsVarNames.length ] = ".$zen->fixJsVal( $vn ).";\n";
    print "  jsVarValues[ ".$zen->fixJsVal( $vn )." ] = ".$zen->fixJsVal( $vv ).";\n";
  }
?>
var groupMap = new Array();
var behaviorMap = new Array();
<?
$fieldMap = array();
$groupsLoadedMap = array();
if( is_array($behaviors) ) {
  foreach($behaviors as $b) {
    $bid = $b['behavior_id'];
    
    $group = $_SESSION['data_groups']["{$b['group_id']}"];
    if( !$group ) {
      // ignore behaviors which do not have a valid group specified
      $zen->addDebug('behavior_js.php',"Behavior $bid specified an invalid group ({$b['group_id']}), ignored", 1); 
      continue;
    }
    
    // generate the behaviorMap entry
    print "behaviorMap['$bid'] = new BehaviorMapEntry(";
    print $zen->fixJsVal($b['group_id']);
    print ",".$zen->fixJsVal($b['behavior_name']);
    print ",".($b['match_all']? 'true' : 'false');
    print ",".$zen->fixJsVal($b['field_name']);
    print ",".($b['field_enabled']? 'false' : 'true');
    print ");\n";        
    
    // create the groupMap entry for this element if it has
    // not been loaded yet
    $k = $group['group_id'];
    if( !array_key_exists($k, $groupsLoadedMap) ) {
      print "groupMap['$k'] = new GroupMapEntry($k";
      print ','.$zen->fixJsVal($group['group_name']);
      print ','.$zen->fixJsVal($group['table_name']);
      print ','.$zen->fixJsVal($group['eval_type']);
      // encode the eval text to prevent corrupting
      // the javascript syntax
      print ", '".rawurlencode($group['eval_text'])."'";
      print ");\n";
    }

    if( is_array($b['fields']) ) {
      if( $group && $group['eval_type'] == 'File' ) {
        // this is a file group, we have a more complex match here, since
        // one behavior can map to many sets of matches.
        $sets = $zen->getBehaviorFileSet( $b, $group, $userBins, $mode );
        if( $sets && count($sets) ) {
          foreach($sets as $setid=>$vals) {
            genBehaviorFields($bid, $vals['matches'], $fieldMap, $setid); 
            genGroupFields($group['group_id'], $vals['values'], $setid);
          }
        }
      }
      else {
        // if this is not a file group, then we have a simple match pattern here
        genBehaviorFields($bid, $b['fields'], $fieldMap);
        genGroupFields($group['group_id'], $group['fields']);
      }
    }
  }
}
?>

/**
 * Field map stores a list of behaviors which might be triggered
 * by a given field, so that when the field is edited, we can review
 * and trigger behavior events accordingly.
 */
var fieldMap = new Array();
<?
foreach($fieldMap as $k=>$v) {
  print "fieldMap['{$k}'] = [".join(",",$v)."];\n";
}
?>

// stores a list of fields which have been edited by a given run, so that
// we do not enter a recursive loop
var behaviorFlags = new Array();

// used for debugging this javascript set
var behaviorDebugMessages = new Array();

// loads debugging mode from header
var useBehaviorDebug = <?= strlen($Debug_Mode)? $Debug_Mode : false  ?>;

// stores a list of the most recently entered values for a given field
// this prevents updating a list with the values it already contains
// and also prevents inifinite loops
var behaviorHistoryMap = new Array();

/**
 * When a field value is changed, we will run it through
 * the fieldChangedBehavior() method and see if any behaviors
 * should be triggered.
 */
function fieldChangedBehavior( fieldObject ) {
  // debugging
  var fieldName = fieldObject? fieldObject.form.getAttribute('name')+"."+fieldObject.name : "null";
  behaviorDebug(3, "(fieldChangedBehavior)"+fieldName);

  // clear any previously set flags
  clearBehaviorFlags();
  
  // recursively check behaviors for this field
  runFieldBehaviors( fieldObject );

  // output debug
  printBehaviorDebug();
}

/**
 * Checks a field to see if it should be triggered, runs recursively,
 * triggering subsequent events based on fields changed until either
 * no more behaviors can be triggered.
 *
 * The caller is expected to handle the clearing of the field flags
 * after completion, since this method doesn't know at what point
 * it is ok to clear them.
 */
 function runFieldBehaviors( fieldObject ) {
   // generate a useful name for debugging
   var formName = fieldObject? fieldObject.form.getAttribute('name') : "-null-";
   var fieldName = fieldObject? formName+"."+fieldObject.name : "-null-";
   
   // insure that this is a valid field and that it has
   // associated behaviors mapped in the fieldMap
   if( fieldObject && fieldObject.name && fieldMap[ fieldObject.name ] ) {
     // extract the associated behaviors and check each one
     // to see if it should be triggered.
     // We also count on the checkBehaviorStatus() method to
     // prevent infinite recursion.
     var behaviors = fieldMap[ fieldObject.name ];
     behaviorDebug(3, "(runFieldBehaviors)reviewing "+behaviors.length+" behaviors for "+fieldName);
     for(var i=0; i < behaviors.length; i++) {
       var behavior_id = behaviors[i];
       var setid = checkBehaviorStatus(fieldObject.form, behavior_id); 
       if( setid ) {
         // when the method is triggered, the field it changed
         // may trigger a behavior in turn, so we will
         // use recursion to check that field as well
         var fieldAffected = executeBehavior(fieldObject.form, behavior_id, setid);	
         var newFieldName = formName+"."+fieldAffected;
         behaviorDebug(3, "(runFieldBehaviors)updated field: ["+behavior_id+"]"+newFieldName);
         
         // fieldObject.form is a reference to the form object (Read Only)
         // which contains this field
         runFieldBehaviors( fieldObject.form[fieldAffected] );
       }
     }
     return true;
  }
  else {
    // just for debugging
    behaviorDebug(3, "(runFieldBehaviors)field ignored -- no behaviors: "+fieldName);
  }
  return false;
}


/**
 * Execute a behavior.  We flag all fields changed and insure
 * that they cannot be recursively edited by behaviors (to prevent
 * inifinite loops)
 *
 * This method returns the field affected by the behavior.
 */
function executeBehavior( formObj, behaviorId, setid ) {
  if( !setid ) { setid = 'default'; }
  behaviorDebug(3, "(executeBehavior)executing behavior "+behaviorId+"->"+formObj.getAttribute('name')+"[setid="+setid+"]");
  var behavior = behaviorMap[ behaviorId ];
  var group = groupMap[ behavior.group_id ];
  
  if( !behavior || !group ) {
    behaviorDebug(1, "(executeBehavior)Behavior/group invalid: ["+behaviorId+"]");
    return false;
  }

  var fieldObj = formObj[ behavior.field ];
  if( !fieldObj ) {
    behavior.field = behavior.field + "[]";
    fieldObj = formObj[ behavior.field ];
    if( !fieldObj ) {
      behaviorDebug(1, "(executeBehavior)Behavior field invalid: "+formObj.name+"."+behavior.field);
      return false;
    }
  }

  // note that this behavior was executed
  // this may be true even if we don't get
  // a return value from setFormValsUsingGroup
  // because it may already contain the values
  // we attempt to set there
  addBehaviorFlag( behavior.field );

  // store field modified
  var fieldModified = false;

  // only return field if it exists and was changed
  if( setFormValsUsingGroup(fieldObj, group, setid) ) {
    fieldModified = behavior.field;
  }

  // disable/enable field as appropriate
  fieldObj.disabled = behavior.disabled? true : false;

  // disable/enable calendar icon and popup as appropriate
  if (fieldObj.getAttribute('hascalendar')) {
    var calendarIcon=document.getElementById(fieldObj.getAttribute('hascalendar'));
    if (fieldObj.disabled) {
      calendarIcon.src="images/disabled-cal.gif";
      calendarIcon.oldonclick=calendarIcon.onclick;
      calendarIcon.onclick=function() {return false;};
    } else {
      calendarIcon.src="images/cal.gif";
      calendarIcon.onclick=calendarIcon.oldonclick;
    }
  }

  if( fieldObj.disabled ) {
    mClassX(fieldObj, 'inputDisabled');
  }
  else {
    mClassX(fieldObj, 'input');
  }

  return fieldModified;
}

/**
 * Set the values of a form field to the list provided
 *
 * The setid is only meaningful to file groups, all other
 * groups can simply ignore this (it passes undefined) and
 * use the defaults.
 */
function setFormValsUsingGroup( fieldObj, group, setid ) {
  if( !setid ) { setid = 'default'; }

  // we keep a history to avoid redundantly setting the values if they
  // already are and to prevent infinite loops
  if( behaviorHistoryMap[ fieldObj.name ] == group.id && group.evalType == 'Matches' ) {
    behaviorDebug(3, "(setFormValsUsingGroup)field "+fieldObj.name
		  +" is already set to "+group.name+" (skipping)");
    return false;
  }

  // record the group_id that we have used to generate the field's
  // current entries
  behaviorHistoryMap[ fieldObj.name ] = group.id;

  // handle javascript eval type
  if( group.evalType == 'Javascript' ) {
    // we encode the eval text so it won't cause erros in js
    // so we unencode it here and then replace occurences
    // of {form} with the form name
    var f = 'window.document.'+fieldObj.form.getAttribute('name');
    var fn = f+'.'+fieldObj.name
    var s = unescape(group.evalText);
    behaviorDebug(3, "(setFormValsUsingGroup)initial evalText: "+s);
    var myReplaceText;
    var myRegExp;
    for (var i=0; i < jsVarNames.length; i++) {
      myReplaceText = '\{'+jsVarNames[i]+'\}';
      myRegExp = new RegExp(myReplaceText, "ig")  
      s = s.replace( myRegExp, jsVarValues[jsVarNames[i]] );
      behaviorDebug(3, '(setFormValsUsingGroup)replacing evalText ('+myRegExp+' by '+jsVarValues[jsVarNames[i]]+') results in : '+s);
    }
    s = s.replace( /\{form\}.\{field\}/ig, "{field}" );
    s = s.replace( /{form}/ig, f);
    var vals = evalJsString( s.replace(/{field}/ig, fn) );

    // clear any existing values from fields array
    group.fields = new Array();
    
    // only bother if vals were returned
    if( vals != null && vals.length > 0 ) {
      for( var i=0; i < vals.length; i++ ) {
         if( vals[i] && typeof vals[i] == 'object' ) {
           // this is a label/value pair
           group.addField( vals[i].value, vals[i].label );
         }
         else {
           // this is just a value
           group.addField( vals[i] );
         }
      }
    }
  }
  
  var fields = group.getFields(setid);
  
  // set the field values
  var v = '';
  for(var i=0; i < fields.length; i++) {
    v += fields[i].label+",";
  }
  behaviorDebug(3, "(setFormValsUsingGroup)updating "+fieldObj.name
		+" using "+group.name+"["+fieldObj.type+"] with setid="+setid+" and values=["+v+"]");
  // To be used for hidden, text, etc: set the oldPos value if the fieldObj.value is in the list
  // (unless we do it, the first element of the list will always be assigned to the field, no matter if the fieldObj.value is in the list)
  var oldPos = -1;
  if ( fieldObj.value != null && typeof fieldObj.value != "undef" ) {
    for(var i=0; i < fields.length && oldPos == -1; i++) {
      if ( fields[i].value == fieldObj.value ) {
        oldPos=i;
      }
    }
  }
  if ( oldPos == -1) {
    for(var i=0; i < fields.length && oldPos == -1; i++) {
      if (fields[i].label == fieldObj.value) {
        oldPos=i;
      }
    }
  }
  if ( oldPos == -1) {
    oldPos=0;
    behaviorDebug(3, "(setFormValsUsingGroup)Did not recognize field value for "+fieldObj.name+" ("+fieldObj.value+")");
  } else {
    behaviorDebug(3, "(setFormValsUsingGroup)Recognized field value for "+fieldObj.name+" as ["+fields[oldPos].value+"]"+fields[oldPos].label);
  }
  switch( fieldObj.type ) {
    case "checkbox":
      if( fields[0].value ) {
        fieldObj.checked = true;
      }
      break;
    case "hidden":
      var labelText = document.getElementById(fieldObj.name+"LabelText");
      if( labelText ) {
        labelText.innerHTML = fields.length>0?fields[oldPos].label : "";
        if (fields.length>0) {
          labelText.innerHTML = fields[oldPos].value;
        } else {
          behaviorDebug(3, "(setFormValsUsingGroup) Empty string forced for "+fieldObj.name+"LabelText.innerHTML");
          labelText.innerHTML = "";
        }
      }
    case "button":
    case "submit":
    case "text":
    case "textarea":
      if (fields.length>0) {
        fieldObj.value = fields[oldPos].value;
      } else {
        behaviorDebug(3, "(setFormValsUsingGroup) Empty string forced for "+fieldObj.name+".value");
        fieldObj.value = "";
      }
      break;
    case "select":
    case "select-one":
      if( fieldObj.selectedIndex != -1 && fieldObj.options && fieldObj.options.length > 0 ) {
        // store the currently selected value and try to reproduce in a minute
        var oldValue = fieldObj.options[ fieldObj.selectedIndex ].value;
        behaviorDebug(3, "(setFormValsUsingGroup)storing oldValue="+oldValue);
      }
      behaviorDebug(3, "(setFormValsUsingGroup)storing oldValue="+oldValue); 
      fieldObj.length = 0;
      for(var i=0; i < fields.length; i++) {
        var f = fields[i];
        behaviorDebug(3, "(setFormValsUsingGroup)Setting option "+i+" to ["+f.value+"]"+f.label);
        fieldObj.options[i] = new Option();
        fieldObj.options[i].text = f.label;
        fieldObj.options[i].value = f.value;
        // try to set to the same value if possible
        if( f.value == oldValue ) {
//          fieldObj.options[i].selected = true;
          fieldObj.selectedIndex=i;
        }
      }
      break;
    case "select-multiple":
      var oldValues = new Array();
      if( fieldObj.options && fieldObj.options.length > 0 ) {
        // store the currently selected value and try to reproduce in a minute
        for (var i=0; i< fieldObj.options.length; i++) {
          if (fieldObj.options[i].selected) {
            oldValues[fieldObj.options[i].value]=1;
            behaviorDebug(3, "(setFormValsUsingGroup)storing oldValues["+fieldObj.options[i].value+"] = 1");
          }
        }
      }

      fieldObj.length = 0;
      for(var i=0; i < fields.length; i++) {
        var f = fields[i];
        behaviorDebug(3, "(setFormValsUsingGroup)Setting option "+i+" to ["+f.value+"]"+f.label);
        fieldObj.options[i] = new Option();
        fieldObj.options[i].text = f.label;
        fieldObj.options[i].value = f.value;
        // try to set to the same value if possible
        if( oldValues[f.value]==1 ) {
          fieldObj.options[i].selected = true;
//          fieldObj.selectedIndex=i;
        }
      }

      var labelText = document.getElementById(fieldObj.name+"LabelText");
      if( labelText ) {
        labelText.innerHTML = fields.length>0?fields[oldPos].label : "";
        if (fields.length>0) {
          if( fieldObj.options && fieldObj.options.length > 0 ) {
            // store the currently selected value and try to reproduce in a minute
            separator = "";
            labelText.innerHTML = "";
            for (var i=0; i< fieldObj.options.length; i++) {
              if (fieldObj.options[i].selected) {
                labelText.innerHTML = labelText.innerHTML + separator + fieldObj.options[i].value;
                separator = "; ";
                behaviorDebug(3, "(setFormValsUsingGroup)added "+fieldObj.options[i].value+"to "+fieldObj.name+"LabelText.innerHTML");
              }
            }
          }
        } else {
          behaviorDebug(3, "(setFormValsUsingGroup) Empty string forced for "+fieldObj.name+"LabelText.innerHTML");
          labelText.innerHTML = "";
        }
      }
      break;
    //case "radio":
    //case "file":
    //case "hidden":
    //case "password":
    //case "reset":
    default:
      behaviorDebug(1, "(setFormValsUsingGroup)Invalid field type: "+fieldObj.name+"["+fieldObj.type+"]");
      return false;
  }

  return true;
}

/**
 * Adds a field to the list of fields updated to prevent recursive looping
 */
function addBehaviorFlag( fieldName ) {
  if( fieldName ) {
    behaviorDebug(3, "Set behaviorFlag: "+fieldName);
    behaviorFlags[ fieldName ] = 1;
  }
}

/**
 * Clears out the list of fields that have been updated during a run
 * of behavior triggers
 */
function clearBehaviorFlags() {
  behaviorDebug(3, "(clearBehaviorFlags)all clear");
  behaviorFlags = new Array();
  behaviorHistoryMap = new Array();
}

/**
 * Checks to see if conditions have been met to trigger a behavior
 *
 * Returns the setid matched or false
 */
function checkBehaviorStatus( formObject, behaviorId ) {
  // retrieve the behavior info
  var behavior = behaviorMap[ behaviorId ];

  // just a quick check for integrity
  if( !behavior ) {
    behaviorDebug(1, "(checkBehaviorStatus)Behavior id not found: "+behaviorId);
  }

  // debugging
  var formName = formObject? formObject.getAttribute('name') : "-null-";
  behaviorDebug(3, "(checkBehaviorStatus)Checking status: ["
		+formName+"]"+behavior.name);

  // make sure this behaviors field isn't listed in the
  // flagged fields.  If it is, we return false to avoid
  // infinite recursion.
  if( behaviorFlags[ behavior.field ] ) { 
    behaviorDebug(2, "(checkBehaviorStatus)Behavior ignored -- field modified already: ["
		  +behavior.field+"]"+behavior.name);
    return false; 
  }

  // otherwise, we will check the fields and their 
  // match conditions, insuring that we monitor the 
  // "and" or "or" behavior specified.
  // we must iterate over each setid and evaluate it
  // independantly, taking the first successful result
  // that we receive.
  var numSets = 0;
  for( var setid in behavior.fields ) {
    numSets++;
    behaviorDebug(3,"(checkBehaviorStatus)checking setid="+setid);
    var matchedAll = true;
    for(var i=0; i < behavior.fields[setid].length; i++) {
      var f = behavior.fields[setid][i];
      var matched = matchBehaviorCriteria( formObject, f );
      behaviorDebug(3, "(checkBehaviorStatus)"+f.name+" "+f.operator+" '"+f.value+"' ["+matched+"]");
  
      // if matchall is set, then we must match every field
      // to succeed
      if( behavior.matchall && !matched ) {
        matchedAll = false;
        break; 
      }
      // otherwise, any match is a success
      if( behavior.matchall == false && matched ) {
        behaviorDebug(3, "(checkBehaviorStatus)setid="+setid+": matched on 'or' clause");
        return setid; 
      }
    }
    // in the event that we are looking for a matchAll and the flag is still
    // true then we have a match
    if( behavior.matchall && matchedAll ) {
      behaviorDebug(3, "(checkBehaviorStatus)setid="+setid+": all behaviors matched");
      return setid; 
    }
  }
  
  // if there are no fields to match, then the behavior always runs.
  // we cannot simply look at fields.length here, because it returns
  // zero when we have null values in the array!
  if( numSets < 1 ) {
    behaviorDebug(3, "(checkBehaviorStatus)Always true -- no fields: "+behavior.name);
    return true;
  }

  // in the point that we arrive here, nothing has matched so we return false
  behaviorDebug(3, "(checkBehaviorStatus)behavior="+behavior.name+": no matches");  
  return false;
}

/**
 * Matches a single field value against behavior criteria
 */
function matchBehaviorCriteria( formObject, behaviorMapField ) {
  var formField = formObject[ behaviorMapField.name ];

  // if the field doesn't exist, it didn't match
  if( !formField ) { 
    behaviorDebug(1, "(matchBehaviorCriteria)Field not found in form: "
		  +behaviorMapField.name);
    return false; 
  }

  fieldVal = getFormFieldValue(formField,behaviorMapField);
  if( fieldVal && fieldVal.toLowerCase ) { fieldVal = fieldVal.toLowerCase(); }

  // store result
  var res = false;

  // otherwise, evaluate the match and deal accordingly
  switch( behaviorMapField.operator ) {
  case "eq":
    // equals
    res = behaviorMapField.value == fieldVal;
    break;
  case "ne":
    // not equal
    res = behaviorMapField.value != fieldVal;
    break;
  case "co":
    // contains
    res = fieldVal.indexOf(behaviorMapField.value) > -1;
    break;
  case "nc":
    // does not contain
    res = fieldVal.indexOf(behaviorMapField.value) < 0;
    break;
  case "sw":
    // starts with
    res = fieldVal.indexOf(behaviorMapField.value) == 0;
    break;
  case "ew":
    // ends with
    var len1 = behaviorMapField.value.length;
    var len2 = fieldVal.length;
    var len3 = len2-len1;
    res = len3 >= 0 &&
      fieldVal.substr(len3,len1) == behaviorMapField.value;
    break;
  case "gt":
    // greater than
    res = fieldVal > behaviorMapField.value;
    break;
  case "lt":
    // less than
    res = fieldVal < behaviorMapField.value;
    break;
  case "ge":
    // greater than or equal
    res = fieldVal >= behaviorMapField.value;
    break;
  case "le":
    // less than or equal
    res = fieldVal <= behaviorMapField.value;
    break;
  case "js":
    // evaluate js code
    var f = 'window.document.'+formField.form.getAttribute('name');
    behaviorMapField.value = behaviorMapField.value.replace(/{form}/ig, f);
    behaviorMapField.value = behaviorMapField.value.replace(/{field}/ig, f+'.'+formField.name);
    res = eval(behaviorMapField.value);
    break;
  default:
    behaviorDebug(1, "Invalid comparator: "+behaviorMapField.operator);
    res = false;
    break;
  }

  behaviorDebug(3, "(matchBehaviorCriteria) "
	+"'"+behaviorMapField.value+"' "
	+behaviorMapField.operator+" "
	+"'"+fieldVal+"' "
	+" ["+res+"]");
  
  return res;
}

/**
 * Creates a debug message for behaviors
 */
function behaviorDebug( errorLevel, str ) {
  if( useBehaviorDebug >= errorLevel ) {
    str = "["+makeTimeString()+"] "+str;
    behaviorDebugMessages[ behaviorDebugMessages.length ] = [errorLevel, str];
  }
}

/**
 * Prints out debug messages
 */
function printBehaviorDebug() {
  var divBox = document.getElementById? document.getElementById("behaviorDebugDiv") : null;
  if( divBox ) {
    // generate or append our debug info to be placed in the div layer.
    var msg = divBox.innerHTML;
    if( !msg ) { msg = "<p>-----BEHAVIORS -----</p>\n"; }
    for(var i=0; i < behaviorDebugMessages.length; i++) {
      var m = behaviorDebugMessages[i];
      var lvl;
      if( divBox ) {
	switch(m[0]) {
	case 1:
	  lvl = "error";
	  break;
	case 2:
	  lvl = "";
	  break;
	default:
	  lvl = "note";
	}
	msg += "<span class='"+lvl+"'>"+m[1]+"</span>";
      }
      msg += "<br>\n";
    }
    divBox.innerHTML = msg;
  }
  behaviorDebugMessages = new Array();
}

/**
 * When the page loads, we want to check to see if any behaviors
 * should be run based on the loaded values and load corresponding
 * behavior info.
 */
function pageLoadedBehavior() {
  // debug output
  behaviorDebug(3, "(pageLoadedBehavior)running");
  
  // clear the behavior flags from any previous uses
  clearBehaviorFlags();


  var behaviorFormSet = new Array(<?
    if( $_GET['formset'] ) {
      $sep = false;
      foreach(explode(',',$_GET['formset']) as $b) {
      if( $sep ) { print ","; }
        print "window.document.".$zen->checkAlphaNum($b,'_.');
        $sep = true;
      }
    }
  ?>);

  // iterate over form elements and check for behaviors
  for( var x=0; x < behaviorFormSet.length; x++ ) {
    if( !behaviorFormSet[x] || !behaviorFormSet[x].elements ) {
      behaviorDebug(1, "(pageLoadedBehavior)invalid form: "+(behaviorFormSet[x]? behaviorFormSet[x].getAttribute('name') : 'undefined'));
      continue;
    }
    behaviorDebug(3, "(pageLoadedBehavior)loading form: "+behaviorFormSet[x].getAttribute('name'));
    for( var i=0; i < behaviorFormSet[x].elements.length; i++ ) {
      if( fieldMap[ behaviorFormSet[x].elements[i].name ] ) {
        setBehaviorOnChange( behaviorFormSet[x].elements[i] );
      }
      runFieldBehaviors( behaviorFormSet[x].elements[i] );
    }
  }

  // output debug
  printBehaviorDebug();
}

/**
 * Generate a function to handle onchange events for us
 */
function setBehaviorOnChange( formElement ) {
  if( formElement.type == 'checkbox' ) {
    var oldFun = formElement.onclick;
    formElement.onclick = genBehaviorFunction( formElement, oldFun );
  }
  else {
    var oldFun = formElement.onchange;
    formElement.onchange = genBehaviorFunction( formElement, oldFun );
  }
}

/**
 * This extra method is needed to handle scoping problems with
 * creating anonymous functions
 */
function genBehaviorFunction( fieldObject, oldFunction ) {
  return function() {
    var x = null;
    if( oldFunction ) {
      x = oldFunction();
    }
    fieldChangedBehavior(fieldObject);
    if (typeof(x) == 'boolean') { return x; }
  }
}

/**
 * Return a form field value by detrmining the field type and extracting value
 */
function getFormFieldValue( formField, behaviorMapField ) {
  switch( formField.type ) {
  case "checkbox":
    return formField.checked? 1 : 0;
  case "radio":
    for(var i=0; i < formField.length; i++) {
      if( formField[i].checked ) { return formField[i].value; }
    }
    return null;
  case "select":
  case "select-one":
  case "select-multiple":
    if( formField.selectedIndex < 0 ) { return ''; }
    if( probablyNumericComparator(behaviorMapField) ) {
      return formField[ formField.selectedIndex ].value;
    }
    else {
      return formField[ formField.selectedIndex ].text;
    }
  default:
    // test for date values and try to do something sensible
    // with these so that they are useful
    if( behaviorMapField.name.indexOf("_date") > 0 ) {
      //can't begin with this, so zero is not a concern
      if( formField.value.match(/[^0-9]/) >= 0 ) {
        var val = Date.parse(formField.value);
        if( val > 0 ) { return val; }
      }
    }
    return formField.value? formField.value : '';
  }
}

/**
 * Determine if a field should be matched on the numeric value or the string label
 */
function probablyNumericComparator( behaviorMapField ) {
  if( !isIntegerValue(behaviorMapField.value) ) { return false; }
  var op = behaviorMapField.operator;
  if( op == "eq" || op == "ne" || op == "gt" || op == "lt" || op == "ge" || op == "le" ) {   
    return true; 
  }
  return false;
}

/**
 * Determine if a value contains only numbers and is probably a valid id
 */
function isIntegerValue( val ) {
  try {
    if( typeof val == 'string' ) {
      return val.search(/[^0-9]/) < 0 && parseInt(val) > 0;
    }
    return parseInt(val)+"" == val;
  }
  catch( e ) {
    return false;
  }
}


/**
 * Evaluate js code and return results
 */
function evalJsString( s ) {
  eval( s );
  return x;
}


window.onload = mergeFunctions( window.onload, pageLoadedBehavior );

<?
  // print out debugging info if specified as such
  if( array_key_exists('behavior_debug', $_GET) ) {
    print "//  ------ DEBUG OUTPUT FOR BEHAVIOR_JS ------- \n";
    $zen->printJsFriendlyDebug();
    print "//  ------ END DEBUG OUTPUT FOR BEHAVIOR_JS ------- \n";
  }
?>

//</pre>
