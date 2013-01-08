<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }


// define some constants for field types
define("ZTFIELD_HIDDEN",0);
define("ZTFIELD_LABEL",1);
define("ZTFIELD_TEXT",2);
define("ZTFIELD_MENU",3);
define("ZTFIELD_SEARCHBOX",4);
define("ZTFIELD_CHECKBOX",5);
define("ZTFIELD_RADIO",6);
define("ZTFIELD_DATE",7);
define("ZTFIELD_SECTION",8);

/**
 * Returns properties for a field:
 * <ul>
 *  <li>searchable - (boolean)can be on search screens
 *  <li>types - (array)valid field types (takes admin screens into account)
 *  <li>multiple - (boolean)may have multiple entries (view can override this)
 *  <li>always_required - (boolean)true if this field is required by system
 *  <li>default - (boolean)true if this field can use default values
 *  <li>data_type - (string) contains 'int', 'string', 'date', 'boolean', or 'float'
 * </ul>
 *
 * @param string $view
 * @param string $field if omitted, returns all fields formatted for a given view
 */
function getFmFieldProps( $view, $field = null ) {
  global $map;
  $field = ZenFieldMap::fieldName($field);
  if( !$field ) {
    // return all fields for a view
    $set = array();
    $list = array_keys($GLOBALS['zt_field_dependencies']['fields']);
    foreach($list as $l) {
      $set[$l] = getFmFieldProps($view, $l);
    }
    return $set;
  }
  // return a single field
  if( !array_key_exists($field, $GLOBALS['zt_field_dependencies']['fields']) ) {
    return false;
  }
  $vals = $GLOBALS['zt_field_dependencies']['fields'][$field];
  $vars = array();
  // the distance between "types" and "admin_view" is important for
  // the details listed below
  $indices = array("searchable", "types", "data_type", "admin_view", "multiple", "always_required", "default");
  for($i=0; $i < count($indices); $i++) {
    if( $indices[$i] == 'admin_view' ) { continue; }
    else if( $indices[$i] == 'types' ) {
      // convert integers to names
      $set = array();
      foreach($vals[$i] as $v) {
        $set[] = ZenFieldMap::getTypeString($v);
      }
      if( $map->getViewProp($view,'admin_view') && $vals[$i+2] ) {
        foreach($vals[$i+2] as $v) {
          $set[] = ZenFieldMap::getTypeString($v);
        }
      }
      $vars[ $indices[$i] ] = $set;
    }
    else if( $map->getViewProp($view,'multiple') && $indices[$i] == 'multiple' ) {
      $vars[ $indices[$i] ] = true;
    }
    else {
      $vars[ $indices[$i] ] = $vals[$i];
    }
  }
  return $vars;   
}
 
/**
 * Returns properties for a field_type
 * <ul>
 *   <li>has_choices - (boolean) true if this field type requires a list of choices
 *   <li>multiple_rows - (boolean) true if this type allows multiple rows
 * </ul>
 *
 * @param string $type if omitted, returns properties for all types
 */
function getFmTypeProps( $type = null ) {
  if( !$type ) {
    // return the entire set
    $set = array();
    $list = array_keys($GLOBALS['zt_field_dependencies']['types']);
    foreach($list as $l) {
      $set[$l] = getFmTypeProps($l);
    }
    return $set;    
  }
  // return a single type
  $vals = $GLOBALS['zt_field_dependencies']['types'][$type];
  if( !is_array($vals) ) { return false; }
  $vars = array();
  $indices = array("has_choices", "multiple");
  for($i=0; $i < count($vals); $i++) {
    $vars[ $indices[$i] ] = $vals[$i];
  }
  return $vars;   
}

// these can't be edited or the system will break
// they define system dependancies and possible
// layouts for various fields
// this array is used by sorting.php directory (a little cheat)
$ztf = array(
  "fields" => array(//       searchable,  types                 , data_type,  admin_view, multiple, always_required, default
    "id"              => array(   true,   array(1)              , 'int'    ,      null, false,  true,  false),
    "title"           => array(   true,   array(1,2)            , 'text' ,        null, false,  true,   true),
    "priority"        => array(   true,   array(0,1,3,6)        , 'int'    ,      null, false,  true,   true),
    "status"          => array(   true,   array(0,1,3,6)        , 'string' ,      null, false,  true,  false),
    "description"     => array(   true,   array(1,2)            , 'text' ,        null, false,  false,  true),
    "otime"           => array(   true,   array(1)              , 'date'   ,  array(7), false,  true,  false),
    "ctime"           => array(   true,   array(1)              , 'date'   ,  array(7), false,  false,  false),
    "bin_id"          => array(   true,   array(1,3,4,6)        , 'int'    ,      null, false,  true,   true),
    "type_id"         => array(   true,   array(1,3,6)          , 'int'    ,      null, false,  true,   true),
    "user_id"         => array(   true,   array(1,3,4,6)        , 'int'    ,      null, false,  false,  true),
    "system_id"       => array(   true,   array(1,3,4,6)        , 'int'    ,      null, false,  true,   true),
    "creator_id"      => array(  false,   array(1)              , 'int'    ,  array(4), false,  true,  false),
    "tested"          => array(  false,   array(1,3,5,6)        , 'int'    ,      null, false,  false,  true),
    "approved"        => array(  false,   array(1,3,5,6)        , 'int'    ,      null, false,  false,  true),
    "relations"       => array(  false,   array(1,4)            , 'string' ,  array(2), true ,  false,  true),
    "project_id"      => array(  false,   array(1,3,4)          , 'int'    ,  array(2), false,  false,  true),
    "est_hours"       => array(  false,   array(1,2)            , 'float'  ,      null, false,  false,  true),
    "deadline"        => array(  false,   array(1,7)            , 'date'   ,      null, false,  false,  true),
    "start_date"      => array(  false,   array(1,7)            , 'date'   ,      null, false,  false,  true),
    "wkd_hours"       => array(  false,   array(1,2)            , 'float'  ,      null, false,  false,  true),
    "custom_string"   => array(   true,   array(1,2)            , 'text' ,        null, false,  false,  true),
    "custom_number"   => array(   true,   array(1,2)            , 'int'    ,      null, false,  false,  true),
    "custom_boolean"  => array(   true,   array(1,3,5,6)        , 'boolean',      null, false,  false,  true),
    "custom_date"     => array(   true,   array(1,7)            , 'date'   ,      null, false,  false,  true),
    "custom_menu"     => array(   true,   array(1,3,6)          , 'string' ,      null, false,  false,  true),
    "custom_multi"    => array(   true,   array(1,3)            , 'string' ,      null, true ,  false,  true),
    "custom_text"     => array(  false,   array(1,2)            , 'text'   ,      null, false,  false,  true),
    "hours"           => array(  false,   array(2)              , 'float'  ,      null, false,  false,  true),
    "comments"        => array(  false,   array(2)              , 'text'   ,      null, false,  false,  true)
  ),
  
  // "views" => array(//           disabled, view_only, has_behaviors, admin_view, multiple, sections, any_option, access_level
    // "ticket_close"    => array(    false,    false,      true, false, false, true,  false, 'level_user' ), 
    // "ticket_create"   => array(    false,    false,      true, false, false, true,  false, 'level_create' ), 
    // "ticket_custom"   => array(    false,    false,      true, false, false, true,  false, 'level_view' ),
    // "ticket_edit"     => array(    false,    false,      true,  true, false, true,  false, 'level_edit' ), 
    // "ticket_list"     => array(    false,     true,     false, false, false, false, false, 'level_view' ),
    // "ticket_options"  => array(    false,    false,     false, false, false, false, true , 'level_view' ),
    // "ticket_view_top" => array(    false,     true,     false, false, false,  true, false, 'level_view' ),
    // "ticket_tab_1"    => array(    false,     true,     false, false, false,  true, false, 'level_view' ),
    // "ticket_tab_2"    => array(    false,     true,     false, false, false,  true, false, 'level_view' ),
    // "ticket_tab_3"    => array(    false,     true,     false, false, false,  true, false, 'level_view' ),
    // "ticket_tab_4"    => array(    false,     true,     false, false, false,  true, false, 'level_view' ),
    // "ticket_tab_5"    => array(    false,     true,     false, false, false,  true, false, 'level_view' ),
    // "ticket_tab_6"    => array(    false,     true,     false, false, false,  true, false, 'level_view' ),
    // "ticket_tab_7"    => array(    false,     true,     false, false, false,  true, false, 'level_view' ),
    // "ticket_tab_8"    => array(    false,     true,     false, false, false,  true, false, 'level_view' ),
    // "project_close"   => array(    false,    false,      true, false, false, true,  false, 'level_user' ), 
    // "project_create"  => array(    false,    false,      true, false, false, true,  false, 'level_create_proj' ),
    // "project_custom"  => array(    false,    false,      true, false, false, true,  false, 'level_view' ),
    // "project_edit"    => array(    false,    false,      true,  true, false, true,  false, 'level_edit' ),
    // "project_list"    => array(    false,     true,     false, false, false, false, false, 'level_view' ),
    // "project_options" => array(    false,    false,     false, false, false, false, true , 'level_view' ),
    // "search_form"     => array(    false,    false,      true,  true, true , false, true , 'level_view' ),
    // "search_list"     => array(    false,     true,     false, false, false, false, false, 'level_view' )
  // ),
  
  "types" => array(//   choices| multirows
    "hidden"   => array(  false, false ),
    "label"    => array(  false, false ),
    "text"     => array(  false, true  ),
    "menu"     => array(  true , true  ),
    "searchbox"=> array(  false, true  ),
    "checkbox" => array(  false, false ),
    "radio"    => array(  true , false ),
    "date"     => array(  false, false ),
    "section"  => array(   true, false )
  )

);
$GLOBALS['zt_field_dependencies'] = $ztf;

include_once("$libDir/ZenContext.class.php");

/**
 * Stores information about the fields and how they are rendered on different
 * view.
 */
class ZenFieldMap {
  
  /**
   * Construct a field map
   *
   * @param object $zen instance of zenTrack.class
   */
  function ZenFieldMap(&$zen) {
    $this->_zen =& $zen;
    $this->_session =& $zen->getSessionManager();
    $this->_fieldVals = array();
  }
  
  /**
   * Return name and properties of each tab in the ticket view
   */
  function getTabs( $type, $login_id, $bin_id ) {
    $tabs = array();
    foreach($this->getViewProps() as $k=>$v) {
      if( !preg_match("@^{$type}_tab_[0-9]$@", $k) ) { continue; }
      if( $this->_zen->checkAccess($login_id, $bin_id, $this->getViewProp($k,'access_level')) ) {
        $tabs["$k"] = array();
        foreach($v as $key=>$val) {
          $tabs["$k"]["$key"] = $this->getViewProp($k,$key);
        }
      }
    }
    return $tabs;
  }
  
  /** 
   * Returns properties for a view
   * <ul>
   *  <li>disabled - (boolean)this view doesn't use field_map yet
   *  <li>view_only - (boolean)this view does not have input fields, just text
   *  <li>has_behaviors - (boolean)this view has behaviors
   *  <li>admin_view - (boolean)this is an admin screen
   *  <li>multiple - (boolean)this view allows multiple selections (overrides field->multiple)
   *  <li>sections - (boolean)true if this view can support sections
   *  <li>any_option - (boolean)true if menus should include -any- option (for searching, etc)
   * </ul>
   *
   * @param string $view if omitted, all views are returned
   */
  function getViewProps( $view = null ) {
    if( !$this->_viewProps ) {
      // attempt to retrieve from session
      $vp = $this->_session->find('view_map');
      if( is_array($vp) ) {
        $this->_zen->addDebug('ZenFieldMap->getViewProps', "Loading from session[".count($vp)."]", 3);
        $this->_viewProps = $vp;
      }
      else {
        // if not in session, load from database
        $query = "SELECT * FROM " . $this->_zen->table_view_map . " ORDER BY which_view, vm_order";

        $this->_viewProps = array();
        $vals = $this->_zen->db_queryIndexed($query);
        $this->_zen->addDebug('ZenFieldMap->getViewProps', "Loading from db[".count($vals)."]: ".$query, 3);
        foreach($vals as $v) {
          $vw = $v['which_view'];
          $field = $v['vm_name'];
          if( !array_key_exists($vw, $this->_viewProps) ) {
            // intialize the view array
            $this->_viewProps["$vw"] = array();
          }
          $this->_viewProps["$vw"]["$field"] = $v;
        }
        $this->_session->store('view_map', $this->_viewProps);
      }
    }
    return $view? $this->_viewProps["$view"] : $this->_viewProps;
  }
  
  /**
   * Update the properties of a view (in the view map).  This will insure that
   * only fields which should be editable have been updated.
   *
   * @param array updates (String)field_name => (mixed)vm_val
   */
  function updateViewProps($view, $updates) {
    $props = $this->getViewProps($view);
    $res = array(0,0);
    foreach($updates as $k=>$v) {
      // if the field is invalid, skip it
      if( !array_key_exists($k, $props) ) {
        $this->_zen->addDebug('ZenFieldMap::updateViewProps', "Invalid field specified: $k", 1);
        continue;
      }
      // get some vals
      $id = $props[$k]['view_map_id'];
      $type = $props[$k]['vm_type'];
      $val = $this->getViewProp($view,$k,'vm_val');
      // if the field cannot be updated, skip it
      if( $type == 'hidden' || $type == 'label' ) { continue; }
      // if the value hasn't changed, don't bother
      if( $v == $val ) { continue; }
      // otherwise, check for 'load' and set an appropriate value
      if( $type == 'load' ) {
        // all of this is to avoid errors caused by trying to call
        // join() on an array
        if( $v && $val && join(',',$v) == join(',',$val) ) {
          continue;
        }
        if( !$v ) { $vals = array('vm_val'=>null); }
        else { $vals = array('vm_val'=> join(",",$v)); }
      }
      else {
        $vals = array('vm_val'=>$v);
      }
      $set = $this->_zen->makeInsertVals($vals, 1);
      $query = "UPDATE  " . $this->_zen->table_view_map . " SET $set WHERE view_map_id = {$id}";
      $r = $this->_zen->db_result($query);
      $this->_zen->addDebug('ZenFieldMap::updateViewProps', "$id[$r]: $query", $res? 3 : 1);
      $res[1]++;
      if( $r ) { $res[0]++; }
    }
    $this->_session->clear('view_map');
    $this->_viewProps = false;
    return $res;
  }
  
  /**
   * Consults the field map and constructs a list of (String)field_name which
   * represents all of the fields which exist in this view. (note that some
   * of these may be hidden fields
   *
   * @param string view corresponds to the which_view field in db
   * @return array containing (string)field_name 
   */
   function listFieldsForView( $view ) {
     if( !$view ) {
       $this->_zen->addDebug('listFieldsForView', "Cannot retrieve field list without a view", 1);
       return null;
     }
     $map = $this->getFieldMap($view);
     if( !$map ) {
       $this->_zen->addDebug('listFieldForView', "Invalid view: ".$view, 1);
       return array(); 
     }
     $this->_zen->addDebug('listFieldsForView', "Found ".count($map)." entries for view '$view'", 3);
     return array_keys($map);
   }
   
   /**
    * Returns a single field from the field map
    *
    * @param string $view the view to use (from which_view field)
    * @param string $field_name the field to retrieve
    * @return array all properties for this field
    */
    function getFieldFromMap($view, $field_name) {
      $map = $this->getFieldMap();
      return $map[$view][$field_name];
    }
    
    /**
     * Returns a single property from a field in the map
     */
   function getFieldProp( $view, $field, $prop ) {
     $map = $this->getFieldMap($view);
     if( !$map ) {
       $this->_zen->addDebug('getFieldProp', "Invalid view: {$view}->{$field}->{$prop}", 1);
       return null;
     }
     if( !array_key_exists($field, $map) ) {
       $this->_zen->addDebug('getFieldProp', "Invalid field: {$view}->{$field}->{$prop}", 1);
       return null;
     }
     if( !array_key_exists($prop, $map[$field]) ) {
       $this->_zen->addDebug('getFieldProp', "Prop not found: {$view}->{$field}->{$prop}", 3);
       return null;
     }
     return $map[$field][$prop];
   }
    
  /**
   * Returns the label specified for the field in question
   */
/*old Function (wrong):
  function getLabel( $view, $field_name ) {
    $field = $this->getFieldFromMap($view,$field_name);
    return $field['field_label']? $field['field_label'] : $field['field_name'];
  }
  new Function: */
  function getLabel( $view, $field_name) {
    $field = $this->getFieldFromMap($view,is_array($field_name)?$field_name['field_name']:$field_name);
    return $field['field_label']? tr($field['field_label']) : tr($field['field_name']);
  }
  
  /**
   * Consults the field map and returns a string of suitable text to show
   * to the user for a given field.  This text will be read only, and no
   * hidden field will be rendered.  This is for display purposes only.
   *
   * The text will be truncated to the num_cols length specified in the database.
   *
   * @param string $view corresponds to the which_view field in db
   * @param string $field_name corresponds to $field_name in db
   * @return string of text to display
   */
  function getTextValue( $view, $field_name, $value ) {
    $this->_zen->addDebug("getTextValue", "rendering $view, $field_name, $value", 3);
    $field = $this->getFieldFromMap($view,$field_name);
    $userBins = $this->_zen->getUsersBins($_SESSION['login_id']);
    if( $field['is_visible'] && $field['field_type'] != 'hidden' ) {
      if( !strlen($value) ) { return '&nbsp;'; }
      switch($this->fieldName($field_name)) {
        case "priority":
        case "status":
        case "bin_id":
        case "type_id":
        case "system_id":
          $vals = $this->_zen->getValsForTicketField($field_name,$userBins);
          if( isset($vals["$value"]) ) { return $this->_zen->ffv(tr($vals["$value"])); }
          else {
            $this->_zen->addDebug("getTextValue", "Unable to find choices for {$view}->{$field_name}", 1);
            return $this->_zen->ffv($value, $field['num_cols']); 
          }
        case "user_id":
        case "creator_id":
          $name = $this->_zen->formatName($value,1);
          return $this->_zen->ffv($name,$field['num_cols']);
        case "tested":
        case "approved":
          $val = $value == 1? tr('Required') : ($value == 2? tr('Complete') : tr('n/a'));
          return $this->_zen->ffv($val,$field['num_cols']);
        case "otime":
        case "ctime":
        case "deadline":
        case "start_date":
        case "custom_date":
          if( preg_match('/[^0-9]/', $value) ) {
            return $this->_zen->ffv($value,$field['num_cols']);
          }
          if( $value == 'NULL' ) { $value = ''; }
          if( $value == 0 ) { $value = ""; }
          return $this->_zen->showDateTime($value);
        case "custom_boolean":
          $val = $value == 1? tr('Yes') : tr('No');
          return $this->_zen->ffv($val,$field['num_cols']);
        case "details":
        case "title":
        case "custom_text":
          return $this->_zen->ffvText($value);
        case "custom_multi":
//          return str_replace("\t", "; ", $value);
          return implode($this->_zen->multisep, $value);
        default:
          $val = $this->_zen->ffvText(str_replace("\t",";",$value), $field['num_cols']);
          $this->_zen->addDebug("getTextValue", "rendering default: $val", 3);
          return $val;
      }
    }
    // it's hidden, return nothing
    return '';
  }
  
  /**
   * Consults the field map to determine what sort of field we have, loads
   * this information, and renders the field to the screen appropriately.
   *
   * @param ZenFieldMapRenderContext $context
   * @return string containing html to render
   */
  function renderTicketField( $context ) {
    global $templateDir;
    global $rootUrl;
    
    $view = $context->view();
    
    $form_name = $context->form();
    $field_name = $context->field();
    $value = $context->value();
    $override_name = $context->name();
    $override_as_label = $context->force_label();
    $field_events = $context->events();
    
    // collect field properties
    $field = $this->getFieldFromMap($view,$field_name);
    $typeint = $this->getTypeInt($field['field_type']);
    $typename = $field['field_type'];
    
    // override properties if appropriate
    if( $context->columns() ) { $field['num_cols'] = $context->columns(); }
    if( $context->rows()    ) { $field['num_rows'] = $context->rows();    }
    if( $context->label()   ) { $field['label']    = $context->label();   }
    if( $context->multiple()) { $field['multiple'] = $context->multiple();}
    
    if ($typeint != ZTFIELD_SECTION && $typeint != ZTFIELD_HIDDEN && $override_as_label == 1) {
      $typeint = ZTFIELD_LABEL;
      $typename =  "label";
    }
    
    // don't waste time on spacers
    if( $typeint == ZTFIELD_SECTION ) {
      $vals = array('label'=>tr($field['field_label']));
      return $this->_template($templateDir, $typename, $vals); 
    }

    // collect system properties
    $fprops = getFmFieldProps($view, $field_name);
    $tprops = getFmTypeProps($typename);
    
    // see if this is a 'viewonly' screen, if so, no form fields needed
    if( $this->getViewProp($view, 'view_only') ) { return $this->getTextValue($view,$field_name,$value); }
    
    // collect template props
    $vals = array();
    $vals["view"]         = $view;
    $vals["form_name"]    = $form_name;
    $vals["templateDir"]  = $templateDir;
    $vals["rooturl"]      = $rootUrl;
    $vals['date_format']  = $this->_zen->popupDateFormat();
    $vals["field_name"]   = $this->_zen->ffv($override_name);
    $vals["field_events"] = $field_events;
    
    if( !isset($value) && ($view=="ticket_create" || $view=="project_create"
         || $view == 'search_form' || preg_match('@(ticket|project)_list_filters@',$view) )) {
      // if there is no value and this is a create page or search page then we will
      // retrieve a default value to use instead
      $vals["field_value"] = $this->getDefaultValue($view,$field_name);
    } else if( $typeint == ZTFIELD_DATE && !preg_match('/[^0-9]/', $value) ) {
      // if it is a date and we have a numeric value, then we will parse it to
      // a date right here
      //$vals['field_value'] = $this->_zen->showDate($value);
      $vals["field_value"] = strlen($value)? $this->_zen->showDateTime($value) : '';
    } else if( ZenFieldMap::isMultiField($vals['field_name']) ) {
/*
      $tok=strtok($value,"\t");
      $vals["field_value"]=array();
      while ($tok !== false) {
        $vals["field_value"][] = $this->_zen->ffv($tok, $field['num_cols']);
        $tok = strtok("\t");
      }
*/
      $vals["field_value"]=array();
      if ( is_array($value) ) {
        foreach($value as $element) {
          $vals["field_value"][] = $element;
        }
      } else {
        $vals["field_value"][] = $value;
      }
    } else {
      $vals["field_value"] = $value;
    }
    $vals["field_label"] = $this->getTextValue($view,$field_name,$value);
    $vals["field_max"] = $context->maxlength()? $context->maxlength() : $field['num_cols'];
    if( $tprops["has_choices"] ) {
      $vals["field_choices"] = $this->getChoices($view,$field_name);
    }
    
    // deal with fields by checking 
    // the row count to make sure it is reasonable
    if( $field['num_rows'] == 1 ) { $vals['field_cols'] = $field['num_cols'] > 30? 30 : $field['num_cols']+2; }
    else { $vals['field_cols'] = $field['num_cols'] > 50? 50 : $field['num_cols']; }
    $vals['field_rows'] = $field['num_rows'];
    
//    $vals['field_multiple'] = $view == 'search_form' && $typeint == ZTFIELD_MENU && $field['num_rows'] > 1? "multiple" : "";
//    $vals['field_multiple'] = (
//                                ( $view == 'search_form' || strpos($field_name,'custom_multi')===0 )
//                                && $typeint == ZTFIELD_MENU && $field['num_rows'] > 1
//                              ) ? "multiple" : "";
    $vals['field_multiple'] = ( $context->multiple()
                                ||
                                ( $view == 'search_form' && $typeint == ZTFIELD_MENU && $field['num_rows'] > 1 )
                                || 
                                ( ZenFieldMap::isMultiField($field_name) )
                              ) ? "multiple" : "";

    if( $vals['field_multiple'] ) {
      $vals['field_name'] .= "[]";
    }

    // set up special searchbox properties such as url and instructions
    if( $typeint == ZTFIELD_SEARCHBOX ) {
      if( $field_name == 'relations' ) { 
        $vals['search_text'] = '<br>('.tr("Enter multiple ids, separated by a comma").')';
      }
      switch($field_name) {
        case "project_id":
          $s = 'project';
          break;
        case "id":
        case "relations":
          $s = 'ticket';
           break;
        case "user_id":
        case "creator_id":
          $s = 'user';
          break;
        case "type_id":
        case "bin_id":
        case "status":
        case "priority":
        case "system_id":
          $s = 'datatype';
          break;
        default:
          $this->_zen->addDebug("renderTicketField","The field $field_name cannot have a searchbox",1);
          return $this->getTextValue($view,$field_name,$value);
      }
      $vals["search_url"] = $rootUrl."/helpers/{$s}Searchbox.php?"
        ."return_form=$form_name&return_field={$vals['field_name']}";
      if( !$fprops["multiple"] && !$this->getViewProp($view,'multiple') ) {
        $vals['search_url'] .= "&onechoice=1";
      }
    }
    
    // deal with special custom field problems
    if( ZenFieldMap::isVariableField($field_name) ) {
      $f = $this->_zen->getCustomField($field_name);
      if( $f['js_validation'] ) {
        if( $vals['field_events'] ) {
          if( preg_match("/onblur=(['\"])([^'\"]+)['\"]/", $vals['field_events'], $matches) ) {
            $q = $matches[1];
            $v = str_replace($q, "\\$q", $f['js_validation']);
            if( !preg_match('@;$@', $v) ) { $v .= ';'; }
            $val = "onblur='{$v};{$matches[2]}'";
            $vals['field_events'] = preg_replace("/onblur=['\"]([^'\"]+)['\"]/", $val, $vals['field_events']);
          }
          else {
            $vals['field_events'] .= " onblur=".$zen->fixJsVal($f['js_validation']);
          }
        }
        else {
          $vals['field_events'] = "onblur=".$zen->fixJsVal($f['js_validation']);
        }
      }
      if( strpos($field_name,'custom_date') === 0 ) {
        if( $vals['field_value'] == 'NULL' ) { $vals['field_value'] = ''; }
        if( $vals['field_value'] == 0 ) { $vals['field_value'] = ""; }
      }
    }
    
    // check for special cases, such as textarea
    if( $typeint == ZTFIELD_TEXT && $field['num_rows'] > 1 ) {
      $typename = 'textarea';
    }
    
    // check field if it is a checkbox
    if( $typeint == ZTFIELD_CHECKBOX && !$vals['field_value'] ) {
      $vals['field_value'] = null;
    }
    
    // hide any fields which are not visible
    if( $field['is_visible'] < 1 ) {
      $typename = 'hidden';
      if( $field['is_required'] && !strlen($value) ) {
        $value = $this->getDefaultValue($view, $field_name);
        if( !strlen($value) ) {
          $this->_zen->addDebug("renderTicketField", "Required field is hidden and has no value: $view, $field_name", 1);
        }
      }
    }

    if ( $typename == 'label' && strpos($field_name,"multi")>0 ) {
      $typename = "multilabel";
      $vals["field_choices"] = $this->getChoices($view,$field_name);
    }

    if ( $typename == "hidden" && ZenFieldMap::isMultiField($field_name) ) {
      $typename = "multihidden";
      $vals["field_choices"] = $this->getChoices($view,$field_name);
      //Prevent loosing current values in hidden fields:
      if( is_array($vals['field_value']) ) {
        foreach ($vals["field_value"] as $value) {
          if ( ! in_array($value, $vals["field_choices"]) ) {
            $vals["field_choices"][$value]= $value;
          }
        }
      }
    }
    
    // variable fields have some special attributes.  First, we don't want
    // to try to render keys for these (too much trouble with escaping), so
    // we render them without keys.  Second, the normal comparisons (key to
    // current value) won't work since there are no keys, so we have to
    // check the value.
    $vf = ZenFieldMap::isVariableField($vals['field_name']);
    if( $vf && $typename == 'menu' ) { $typename = 'menunokeys'; }
    
    // we escape the field_choices array here (values only) and try
    // to find the correct value to select if this is a variable field
    if( $vf && isset($vals['field_choices']) ) {
      foreach($vals['field_choices']  as $k=>$v) {
        if( $v == $vals['field_value'] ) { 
          $vals['field_selected'] = $v;
        }
      }
    }
    
    // parse and return 
    return $this->_template($templateDir, $typename, $vals);
  }
  
  /**
   * Generate a template
   */
   function _template( $templateDir, $typename, $vals ) {
     // render the template
     $this->_zen->addDebug("_template", "Rendering $templateDir/fields/$typename.template", 3);
     $templateFile = "$templateDir/fields/$typename.template";
     $template = new zenTemplate($templateFile);
     
     $vals['field_value'] = $this->_zen->ffv($vals['field_value']);
     if( isset($vals['field_choices']) ) {
       $vals['field_choices'] = $this->_zen->ffv($vals['field_choices']);
     }
     if( isset($vals['field_selected']) ) {
       $vals['field_selected'] = $this->_zen->ffv($vals['field_selected']);
     }
     
     $template->values($vals);
     return $template->process();     
   }
  
  /**
   * Returns field map, which explains how fields should be displayed, and which
   * screens they will appear on.  This array is indexed first by view, and then
   * by the field_name
   *
   * <p>This information is cached in the session.
   *
   * @param string $view if provided, only fields in this view will be returned,
   *        otherwise an array of all views will be returned.
   */
  function getFieldMap($view = false) {
    // try to retrieve from session
    $map = $this->_session->getDataType('fieldmap');
    if( $map && count($map) ) { return $view? $map[$view] : $map; }
    
    // retrieve from database
    $query = "SELECT * FROM ".$this->_zen->table_field_map." ORDER BY sort_order, field_label";

    $vals = $this->_zen->db_queryIndexed($query);
    $set = array();
    for($i=0; $i<count($vals); $i++) {
      $v = $vals[$i];
      if ( !array_key_exists($v['which_view'], $set) ) {
        $set[ $v['which_view'] ] = array();
      }
//      if (strpos($v['field_name'],"custom_multi")===0) {
//        $v['field_name'].="[]";
//      }
      $set[ $v['which_view'] ] [ $v['field_name'] ] = $v;
    }
    $this->_zen->addDebug("getFieldMap", "Loaded $i rows into field_map from database",3);
    
    // store in session
    $this->_session->storeDataType('fieldmap',$set);
    
    return $view? $set[$view] : $set;
  }
  
  /**
   * Updates the database and the session with new field map values
   *
   * @param array $updates an array structured identical to getFieldMap() results
   * @param array $newspacers array ( 'field_name' => array('field_label', 'is_visible', 'sort_order'), ... )
   * @param array $oldspacers array ( 'field_name'=>field_map_id, ... )
   * @return array(updates, attempts)
   */
  function updateFieldMap( $view, $updates, $newspacers = null, $oldspacers = null ) {
    $updateVals = array();
    $fullMap = $this->getFieldMap();
    foreach($fullMap[$view] as $k=>$v) {
      if( $updates[$k] && !Zen::arrayEquals($updates[$k], $v) ) {
        $updateVals[] = $updates[$k];
      }
    }
    $i=0;
    for($j=0; $j<count($updateVals); $j++) {
      $v = $updateVals[$j];
      $res = $this->_zen->db_update($this->_zen->table_field_map, 'field_map_id', $v['field_map_id'], $v);
      $this->_zen->addDebug('updateFieldMap', "Updating {$v['which_view']}->{$v['field_name']}", 3);
      if( $res ) { $i++; }
    }
    
    foreach($newspacers as $k=>$v) {
      $j++;
      if( $this->addSection($view, $k, $v['field_label'], $v['is_visible'], $v['sort_order']) ) { $i++; }
    }
    foreach($oldspacers as $k=>$v) {
      $j++;
      if( $this->removeSection($view, $k, $v) ) { $i++; } 
    }
    
    // clear cache so it reloads next time
    $this->_session->clearDataType('fieldmap');
    
    return array($i,$j);
  }
  
  /**
   * Adds a new section into the field map
   */
   function addSection( $view, $name, $label, $visible, $sort_order ) {
     $vals = array("which_view"  => $view, 
                   "field_name"  => $name,
                   "sort_order"  => $sort_order,
                   "is_visible"  => $visible? 1 : 0,
                   "field_label" => $label,
                   "field_type"  => 'section',
                   "num_cols"    => 100,
                   "num_rows"    =>   1);
     $res = $this->_zen->db_insert($this->_zen->table_field_map, $vals, 'field_map_id_seq');
     $this->_zen->addDebug("addSection", "Section added[$res]: $view, '$label', $sort_order", 3);
     return $res;
   }
   
   /**
    * Removes a section from the field map
    */
   function removeSection( $view, $field_name, $field_map_id ) {
     $field = $this->getFieldFromMap($view, $field_name);
     if( $field['field_type'] != 'section' ) {
       $this->addDebug("removeSection", "Field is not a section: $view-$field_name", 1);
       return false;
     }
     $id = $field['field_map_id'];
     $res = $this->_zen->db_delete($this->_zen->table_field_map, 'field_map_id', $id);
     $this->_zen->addDebug("removeSection", "Section deleted[$res]: $view, $field_name", 3);
     return $res;
   }
  
  /**
   * Returns the default value for this field
   *
   * IMPORTANT FOR CUSTOM_MENU FIELDS
   *   If the field is optional in the view, the default would be "-none-".
   *   If not, the default would be the first item.
   *   This happens no matter if the field is visible or invisible.
   *
   * IMPORTANT FOR CUSTOM_MULTI FIELDS
   *   The default is always empty.
   */
  function getDefaultValue( $view, $field_name ) {
    $field = $this->getFieldFromMap($view,$field_name);
    $retVal = 0;
    switch($this->fieldName($field_name)) {
      case "creator_id":
      case "user_id":
        if( strlen($field['default_val']) && preg_match('/[^0-9]/', $field['default_val']) ) {
          if( strpos($field['default_val'],'@') === false ) {
            $val = $this->_zen->get_user_by_login($field['default_value']);
            $this->_zen->addDebug("getDefaultValue", "Retrieved user id '$val' by login: {$view}->{$field_name}", 3);
            $retVal = $val;
          }
          else {
            $vals = $this->_zen->getUsersFromEmail($field['default_value']);
            $this->_zen->addDebug("getDefaultValue", "Retrieved ".count($vals)." user ids by email: {$view}->{$field_name}", 3);
            $retVal = $vals && count($vals)? $vals[0] : null; 
          }
        }
        else { $retVal = $field['default_val']; }
        break;
      case "custom_date":
      case "otime":
      case "ctime":
      case "deadline":
      case "start_date":
        $retVal = strlen($field['default_val'])? $this->_zen->showDateTime($this->_zen->dateParse($field['default_val'])) : "";
        break;
      case "custom_menu":
        $choices = $this->getChoices( $view, $field_name );
        $retVal = array_shift( $choices );
        break;
      case "custom_multi":
        $retVal = '';
        break;
      default:
        $retVal = $field['default_val'];
        break;
    }
    $this->_zen->addDebug('_getDefaultValue', "Returned {".$retVal."} for {$view}->{$field_name}", 3);
    return $retVal;
  }
  
  /**
   * Returns a list of valid choices for the given field in the format:
   *  array( (string)value -> (string)label )
   */
  function getChoices( $view, $field_name ) {
    if( isset($this->_fieldVals[$view]) && isset($this->_fieldVals[$view][$field_name]) ) 
      { return $this->_fieldVals[$view][$field_name]; }
      
    $field = $this->getFieldFromMap($view, $field_name);
    $fprops = getFmFieldProps($view, $field_name);
    $bins = $this->_zen->getUsersBins($_SESSION['login_id'], $this->getViewProp($view, 'access_level'));
    
    switch( $this->fieldName($field_name) ) {
      case "bin_id":
        $vals = array();
        for($i=0; $i<count($bins); $i++) {
          $b = $bins[$i];
          $vals["$b"] = $this->_zen->getBinName($b);
        }
        break;
      case "status":
        $vals = array('OPEN'=>tr("Open"),'PENDING'=>tr("Pending"),'CLOSED'=>tr("Closed"));
        break;
      case "type_id":
        $vars = $this->_zen->getValsForTicketField($field_name, $bins);
        $vals = array();
        if( strpos($view, 'project') === 0 ) {
          // only list projects
          $ids = $this->_zen->projectTypeIDs();
        }
        else if( strpos($view, 'ticket') === 0 ) {
          // only list tickets
          $ids = $this->_zen->notProjectTypeIds();
        }
        else {
          // this must be a search or admin of some kind, so just list them all
          $vals = $vars;
          break;
        }
        foreach($vars as $k=>$v) {
          if( in_array($k, $ids) ) { $vals[$k] = $v; }
        }
        break;
      case "id":
      case "title":
      case "priority":
      case "user_id":
      case "system_id":
      case "creator_id":
      case "project_id":
        $vals = $this->_zen->getValsForTicketField($field_name, $bins);
        break;
      case 'custom_boolean':
        $vals = array('1'=>'Yes', '0'=>'No');
        break;      
      case "tested":
      case "approved":
        $vals = array('1'=>tr('Required'), '2'=>tr('Completed'));
        break;
      case "custom_menu":
      case "custom_multi":
        $pts = explode("_", $view, 2);
//          $vars = $this->_zen->getCustomField($field_name);
//          $set = genDataGroupChoices($vars['field_value']);
        $vars = $this->getFieldFromMap($view, $field_name);
        $set = genDataGroupChoices($vars['default_val']);
        $vals = array();
        foreach($set as $s) {
          $vals[ $s['field_value'] ] = $s['label'];
        }
        break;
      default:
        $vals = array();
        break;
    }
    
    $this->_zen->addDebug('_getChoices', "Generated ".count($vals)." choices for {$view}->{$field_name}", 3);
    
    if( $field_name == 'type_id' && preg_match('@^(project|view)_@', $view, $matches) ) {
      // remove project types from ticket views and ticket types from
      // project views
      $newvals = array();
      $isproj = $matches[1] == 'project';
      foreach($vals as $k=>$v) {
        if( ($is_proj && $this->_zen->inProjectTypeIDs($k)) ||
        (!$is_proj && !$this->_zen->inProjectTypeIDs($k)) ) {
          $newvals[$k] = $v;
        }
      }
      $vals = $newvals;
    }
    
    if( $this->getViewProp($view, 'any_option') && $field['num_rows'] == 1 ) {
      $vals = Zen::mergeArrays( array('' => tr('-any-')), $vals );
      $this->_zen->addDebug('_getChoices', "Added '-any-' entry choices for {$view}->{$field_name}", 3);
      //$vals = array_merge(array(''=>'-any-'),$vals);
    } else if ( $field['is_required']==0 && $field['field_type'] == 'menu') {
      $vals = Zen::mergeArrays( array('' => tr('-none-')), $vals );
      $this->_zen->addDebug('_getChoices', "Added '-none-' entry choices for {$view}->{$field_name}", 3);
    }
    else if( !$field['is_required'] && $field['num_rows'] == 1 && $this->fieldName($field_name) != 'custom_boolean' ) {
      $vals = Zen::mergeArrays( array(''=>'-----'), $vals );
      $this->_zen->addDebug('_getChoices', "Added '-----' entry choices for {$view}->{$field_name}", 3);
      //$vals = array_merge(array(''=>'-----'), $vals);
    }
    if( !isset($this->_fieldVals[$view]) ) { $this->_fieldVals[$view] = array(); }
    $this->_fieldVals[$view][$field_name] = $vals;
    return $vals;
  }
  
  /**
   * Strip varfield numbers from field names for easier indexing
   *
   * @static
   */
   function fieldName( $name ) {
     return ZenFieldMap::isVariableField($name)? 
        preg_replace('/[0-9]+$/', '', $name) : $name;
   }
   
  /**
   * Returns a string representation of a field type
   *
   * This method is safe to call from a static context
   *
   * @param int $field_type
   * @return string
   */
   function getTypeString( $field_type ) {
     switch($field_type) {
       case ZTFIELD_HIDDEN:
         return "hidden";
       case ZTFIELD_LABEL:
         return "label";
       case ZTFIELD_TEXT:
         return "text";
       case ZTFIELD_MENU:
         return "menu";
       case ZTFIELD_SEARCHBOX:
         return "searchbox";
       case ZTFIELD_CHECKBOX:
         return "checkbox";
       case ZTFIELD_RADIO:
         return "radio";
       case ZTFIELD_DATE:
         return "date";
       case ZTFIELD_SECTION:
         return "section";
       default:
         if( isset($this) && isset($this->_zen) ) {       
           $this->_zen->debug("getTypeString", "Invalid fieldMap type! $field_type", 1);
         }
         return null;
     }
   }
   
  /**
   * Returns an integer representation of a field type
   *
   * This method is safe to call from a static context
   *
   * @param string $field_type
   * @return int
   */
   function getTypeInt($field_type) {
     switch(strtolower($field_type)) {
       case "hidden":
         return ZTFIELD_HIDDEN;
       case "label":
         return ZTFIELD_LABEL;
       case "text":
         return ZTFIELD_TEXT;
       case "menu":
         return ZTFIELD_MENU;
       case "searchbox":
         return ZTFIELD_SEARCHBOX;
       case "checkbox":
         return ZTFIELD_CHECKBOX;
       case "radio":
         return ZTFIELD_RADIO;
       case "date":
         return ZTFIELD_DATE;
       case "section":
         return ZTFIELD_SECTION;
       default:
         if( isset($this) && isset($this->_zen) ) {
           $this->_zen->addDebug("getTypeInt", "Invalid fieldMap type! $field_type", 1);
         }
         return null;
     }     
   }
   
   /**
    * Returns the value (from fmx_val) for a given view property
    *
    * @param string $view
    * @param string $prop
    * @return mixed value of the property (boolean, string or array)
    */
   function getViewProp( $view, $prop ) {
     $vals = $this->getViewProps($view);
     if( !$vals || !$view ) {
       $this->_zen->addDebug('getViewProp', "Invalid view $view, unable to retrieve $prop", 1);
       return null;
     }
     if( !array_key_exists($prop, $vals) ) {
       $this->_zen->addDebug('getViewProp', "Property not found: {$view}->{$prop}", 3);
       return null;
     }
     $val = $vals["$prop"]["vm_val"];
     if( $prop == 'preload' || $prop == 'postload' ) {
       // preload and postload are special cases, always return an array
       $val = $val? explode(",",$val) : array();
     }
     return $val;
   }
   
   /**
    * Returns a list of possible choices for preload/postload options
    *
    * @static
    * @param $libDir includes directory
    * @return array of (String)name values
    */
  function getLoadOptions( $templateDir ) {
    $opts = array();
    $dh = opendir($templateDir);
    while( $file = readdir($dh) ) {
      if( preg_match('@^ticket_load_([a-zA-Z0-9]+)[.]php$@', $file, $matches) ) {
        $opts[] = $matches[1];
      }
    }
    return $opts;
  }
  
  /**
   * Is this a variable field?  True if so.
   */
   function isVariableField( $field_name ) {
     return strpos($field_name, 'custom_') === 0;
   }
   
  /**
   * Is this a multi field? True if so
   */
   function isMultiField( $field_name ) {
     return strpos($field_name, 'custom_multi') === 0;
   }

  function listMultiFields() {
    return array ('custom_multi1', 'custom_multi2');
  }
  
  /** @var array $_map an array of (string)view -> array( (string)field_name->(array)values... ) */
  var $_map;
  
  /** @var array $_fieldVals contains valid entries for ticket field criteria */
  var $_fieldVals;

  /** @var ZenSessionManager $_session */
  var $_session;
  
  /** @var zenTrack $_zen */
  var $_zen;
  
  /** @var array $_viewProps properties for all views */
  var $_viewProps;
  
}

class ZenFieldMapRenderContext extends ZenContext {
  function ZenFieldMapRenderContext($vals = null) {
    $this->ZenContext($vals);
  }
  
  
  /** Sets the view (required) */
  function view() { return $this->get('view'); }
  
  /** The field name from the field map (not the one to appear in the form, required) */
  function field() { return $this->get('field'); }
  
  /** The form name (required) */
  function form() { return $this->get('form'); }  
  
  /** Overrides the field_name used in the form field */
  function name() { return $this->get('name')? $this->get('name') : $this->get('field'); }
  
  /** If set, this overrides the fields num_cols value */
  function columns() { return $this->get('columns'); }
  
  /** If set, this overrides the fields num_rows value */
  function rows() { return $this->get('rows'); }
  
  /** If set, overrides the fields max length (from num_cols) */
  function maxlength() { return $this->get('maxlength'); }
  
  /** Appends text into field, such as onclick or onmouseover events */
  function events() { return $this->get('events'); }
  
  /** Applies a stylesheet class to the field */
  function cssStyle() { return $this->get('cssStyle'); }
  
  /** Sets the default value to use */
  function value() { return $this->get('value'); }
  
  /** Overrides the fields label text */
  function label() { return $this->get('label')? $this->get('label') : $this->name(); }
  
  /** Overrides the fields setting for allowing multiple entries */
  function multiple() { return $this->get('multiple'); }
  
  /** Overrides the field_type and makes it a label */
  function force_label() { return $this->get('force_label'); }
  
}

?>
