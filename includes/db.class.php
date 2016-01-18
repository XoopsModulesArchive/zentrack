<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }


include_once("$libDir/adodb/adodb.inc.php");

class DB {
  
  var $db_link;
  var $db_name;
  var $db_errnum;
  var $db_error;
  var $db_type;
  var $sql_debug;
  
  /*
  **  QUERIES
  */   
  
  //Paging Feature 
  function db_getrowcount ($table, $where) {
    //returns the rowcount for the particular table selected by the query
    $query = "SELECT count(*) FROM $table WHERE $where";
    $this->switchQueryMode(0);
    $recordSet = &$this->db_link->Execute($query);
    if ($recordSet) {
      $vars = $recordSet->FetchRow();
      $res = $vars? $vars[0] : 0;
      $this->addDebug('db_getrowcount', "Results: $res, query=$query", 3);
      return $res; 
    }
    else {
      $this->addDebug('db_getrowcount', "Error in query: $query [" . $this->db_link->ErrorMsg()."]", 1);      
    }
  }
  
  //Paging Feature 
  function db_getlimitedIndex($query,$nosofrows, $offset) {
    //retrieves an indexed array of results from $query which has a specified limit.
    $this->switchQueryMode(1);
    $recordSet = &$this->db_link->SelectLimit($query,$nosofrows,$offset);
    if ( $recordSet ) {
      $vars = $recordSet->getArray();
      if( is_array($vars) && count($vars) ) {
        return $vars;
      }
    }
    else {
      $this->addDebug('db_getlimitedIndex', "Error in query: $query [" . $this->db_link->ErrorMsg() . "]", 1);
    }      
  }  
  
  function db_queryIndexed( $query ) {
    // retrieves an indexed array of results
    // from $query
    // stores any errors in $db_errnum(the code)
    // and $db_error(the message)
    
    $this->switchQueryMode(1);
    $recordSet = &$this->db_link->Execute($query);
    if( $recordSet ) {
      $vars = $recordSet->getArray();
      if( is_array($vars) && count($vars) > 0 )
      return($vars);
    }
    else {
      $this->addDebug('db_queryIndexed', "Error in query: $query [" . $this->db_link->ErrorMsg()."]", 1);
    }
  }
  
  function db_query( $query ) {
    // returns an array of results
    // from $query
    $this->switchQueryMode(0);
    $recordSet = $this->db_link->Execute($query);
    if( $recordSet ) {
      $vars = $recordSet->getArray();
      if( is_array($vars) && count($vars) > 0 )
      return($vars);  
    }
    else {
      $this->addDebug('db_query', "Error in query: $query [" . $this->db_link->ErrorMsg()."]", 1);      
    }
  }
  
  function db_quickIndexed( $query ) {
    // returns an indexed row (1 row only)
    // from $query
    
    $this->switchQueryMode(1);
    $recordSet = &$this->db_link->Execute($query);
    if( $recordSet ) {
      $vars = $recordSet->fields;
      if( is_array($vars) && count($vars) > 0 )
      return($vars);  
    }
    else {
      $this->addDebug('db_quickIndexed', "Error in query: $query [" . $this->db_link->ErrorMsg()."]", 1);      
    }    
  }
  
  function db_quick( $query ) {
    // returns a row (1 row only) of
    // results from $query
    
    $this->switchQueryMode(0);
    $recordSet = &$this->db_link->Execute($query);
    if( $recordSet ) {
      $vars = $recordSet->fields;
      if( is_array($vars) && count($vars) > 0 )
      return($vars);     
    }
    else {
      $this->addDebug('db_quick', "Error in query: $query [" . $this->db_link->ErrorMsg()."]", 1);      
    }
  }
  
  function db_get( $query ) {
    // returns a single value from a db query
    
    $this->switchQueryMode(0);
    $recordSet = &$this->db_link->Execute($query);
    if( $recordSet ) {
      return( $recordSet->fields[0] );
    }
    else {
      $this->addDebug('db_get', "Error in query: $query [" . $this->db_link->ErrorMsg()."]", 1);      
    }
  }
  
  function db_update( $table, $key, $val, $columns ) {
    unset($columns[$key]);
    $set = $this->makeInsertVals( $columns, 1 );
    $val = $this->checkSlashes($val);
    $query = "UPDATE $table SET $set WHERE $key = $val";
    $r = $this->db_result($query);
    $this->addDebug("db_update", "[$r]".$query, 3);
    return $r;
  }
  
  function db_delete( $table, $key, $val ) {
    $query = "DELETE FROM $table WHERE $key = '$val'";
    $r = $this->db_result($query);
    $this->addDebug("db_delete", "[$r]".$query, 3);
    return $r;
  }
  
  function db_insert( $table, $params, $sequence = '' ) {
    // performs an insert statement
    // if $sequence is not given, then it will default as follows:
    //   [table]_id_seq
    // where ZENTRACK_TICKETS would result in:
    //   tickets_id_seq
    // all sequence ids should be named accordingly
    // 
    // requires abstraction because
    // returning the insert_id varies
    // in method from db to db
    // for instance:  in oracle or postgres
    // it is easiest to SELECT nextval() the 
    // sequence/trigger/etc and then insert 
    // the query with that value attached
    // so that the insertID can then be returned
    // .. in mysql, there is no SELECT nextval()
    // so it is easieast to run the query, then return
    // the mysql function mysql_insert_id()
    if( !Zen::inString('mysql',$this->database_type) ) {
      if( !$sequence ) {
        $sequence = ereg_replace("zentrack_", "", strtolower($table));
        $sequence .= "_id_seq";
      }
      $id = $this->db_insertID($sequence);
      $id_field = ZenTrack::getTableId($table);
      if( !$id_field ) {
        $fields = $this->db_get_fields($table);
        $id_field = $fields[0];
      }
      $params["$id_field"] = $id;
    }
    list($cols,$vals) = $this->makeInsertVals($params);
    $query = "INSERT INTO $table ($cols) VALUES($vals)";
    $res = $this->db_link->Execute($query);
    $this->addDebug("db_insert","[$res]".$query,3);
    if( !$res && strlen(strpos($this->database_type,"mssql")) ) {
      // deal with sql server id issues by automagically
      // incrementing the counter when a problem occurs
      $query = "SELECT max($id_field) FROM $table";
      $max = $this->db_get($query);
      $this->addDebug("db_insert", "Checking $id vs max ($max)", 3);
      if( $max >= $id ) {
        $this->addDebug("db_insert", "Max id ($max) greater than current sequence ($id), will auto increment (this should only happen immediately after an install or upgrade)", 1);
        // oops, we have a bad sequence set (this should only happen immediately
        // after an install) so go ahead and increment until it works
        while( $max >= $id ) {
          $id = $this->db_insertID($sequence);
        }
        $this->addDebug("db_insert", "Sequence incremented to $id", 1);
        // now try our query again
        $params["$id_field"] = $id;
        list($cols,$vals) = $this->makeInsertVals($params);
        $query = "INSERT INTO $table ($cols) VALUES($vals)";
        $res = $this->db_link->Execute($query);
      }
    }
    if( $res && Zen::inString('mysql',$this->database_type) ) {
      $id = $this->db_insertID();
    }
    if( $res ) {
      return( $id );
    }
  }
  
  function db_result( $query ) {
    // performs an insert, update, delete
    // or other query which does not retrieve
    // data
    $res = $this->db_link->Execute($query);
    if( $this->_returnsResult ) { 
      if( !$res ) {
        $this->addDebug('db_result', "query failed: $query [" . $this->db_link->ErrorMsg()."]", 2);
      }
      return $res; 
    }
    else { return true; }
  }
  
  function db_list( $query ) {
    // retrieves a single column from the db
    // and returns the results in a simple list
    // array
    
    $this->switchQueryMode(0);
    $recordSet = &$this->db_link->Execute($query);
    $this->addDebug('db_list','['.$recordSet.'] '.$query,3);
    $vals = array();
    if( $recordSet ) {
      $vars = $recordSet->getArray();
      if( is_array($vars) && count($vars) > 0 ) {
        foreach($vars as $v) {
          $vals[] = $v[0];
        }
      }
    }
    else {
      $this->addDebug('db_list', "Error in query: $query [" . $this->db_link->ErrorMsg()."]", 1);      
    }
    return($vals);
  }
  
  function db_listIndexed( $query ) {
    // retrieves a list from the database indexed
    // by the [0] column and containing the [1] column
    $this->switchQueryMode(0);
    $recordSet = &$this->db_link->Execute($query);
    $vals = array();
    if( $recordSet ) {
      $vars = $recordSet->getArray();
      for($i=0; $i<count($vars); $i++) {
        $v = $vars[$i];
        $vals["{$v[0]}"] = $v[1];
      }
    }
    return($vals);
  }
  
  /*
  ** UTILITIES
  */
  
  function db_insertID($sequence = '') {
    // fetches the last mysql insert id from the db
    // if using mysql, call this AFTER the insert statement
    // and will return the ID used by the preceding INSERT
    // otherwise, call it BEFORE. 
    // if using something other than msyql... this will actually
    // increment the insert sequence... essentially reserving that
    // insert id for the INSERT statement about to take place... don't
    // forget to manually add the id with the insert statement in 
    // this case!
    if( $this->database_type == 'mysqli' ) {
      $id = mysqli_insert_id();
    }
    else if( Zen::inString('mysql',$this->database_type) ) {
      $id = mysql_insert_id();
    } else {
      $id = $this->db_link->genID($sequence);
    }
    $this->addDebug("db_insertID", "created id '$id' for sequence '$sequence'", 3);
    return $id;
  }
  
  function checkSlashes( $val = '' ) {
    // checks incoming data for proper escaped ' marks
    // to insure insertion integrity
    if( is_array($val) ) {
      foreach($val as $v) {
        $text .= ($text)? ",".$this->checkSlashes($v) : $this->checkSlashes($v);
      }
      $val = "(".$text.")";
    } else {
      $val = $this->db_link->qstr($val,false);//get_magic_quotes_gpc());
      if( $val == "''" ) {
        $val = "NULL";
      }
    }
    return $val;
  }   
  
  function makeInsertVals( $params, $set = 0 ) {
    // takes an indexed array of parameters and creates a list of columns
    // and values to inseRt into the database
    // is sensitive to things like NULL and numbers
    // if $set is 1, then this method will return an update formatted list
    // rather than two insert formatted lists
    
    if( !$set ) {
      $cols = "";
      $vals = "";
      foreach($params as $k=>$v) {
        $cols .= ($cols)? ", $k" : "$k";
        if( ereg("^(NULL|FALSE|TRUE)$", $v) ) {
          $vals .= strlen($vals)? ", $v" : "$v"; 
        } else {
          $vals .= strlen($vals)? ", ".$this->checkSlashes($v) : $this->checkSlashes($v);
        }
      }
      return(array($cols,$vals));
    } else {
      $cols = "";
      $vals = "";
      foreach($params as $k=>$v) {
        if( ereg("^(NULL|FALSE|TRUE)$", $v) ) {
          $vals .= strlen($vals)? ", $k = $v" : "$k = $v"; 
        } else {
          $vals .= strlen($vals)? ", $k = ".$this->checkSlashes($v) : "$k = ".$this->checkSlashes($v);
        }
      }
      return( $vals );
    }
  }
  
  function simpleWhere( $params, $andor = 'AND' ) {
    // takes an indexed array as a list of columns and
    // their values to match and makes them into an sql
    // format ready for use in a WHERE statement
    
    foreach($params as $k=>$v) {
      if( $text )
      $text .= " $andor ";
      if( is_array($v) ) {
        $text .= "$k IN(";
        $i = 0;
        foreach($v as $vi) {
          if( ereg("^(NULL|FALSE|TRUE|[0-9]+)$", $vi) ) {
            $text .= ($i > 0)? ", ".$vi : $vi;
          } else {
            $text .= ($i > 0)? ", ".$this->checkSlashes($vi) : $this->checkSlashes($vi);
          }
          $i++;
        }
        $text .= ")";
      } else {
        if( ereg("^(NULL|FALSE|TRUE|[0-9]+)$", $v) ) {
          $text .= "$k = $v";
        } else {
          $text .= "$k = ".$this->checkSlashes($v);
        }
      }
    }
    return($text);
  }
  
  function complexWhere( $params, $andor = 'AND' ) {
    // takes an indexed array as a list of columns and
    // an array containing the operator and value of each
    // to match and makes them into an sql
    // format ready for use in a WHERE statement
    // the format is ["column_name"] = array("operator","value")
    // where operator is a comparitor like =,>,>=,LIKE,etc
    $text = "";
    foreach($params as $k=>$v) {
      if( $text != "" ) {
        $text .= " $andor ";
      }
      if( is_array($v[1]) && $v[0] == "AND" || $v[0] == "OR" ) {
        $text .= " (".$this->complexWhere($v[1], $v[0]).") ";
      } else {
        if( !ereg("^(NULL|FALSE|TRUE|[0-9]+)$", $v[2]) )
        $v[2] = $this->checkSlashes($v[2]);
        $text .= " $v[0] $v[1] $v[2] ";
      }
    }
    return($text);
  }            
  
  function db_get_fields( $table, $flag = 0 ) {
    // returns the names of the columns
    // in $table of the current database
    // if $flag is set, returns the ADODB meta object
    // containing all parameters for the fields
    // (see ADODB method MetaColumns() for more info)
    // http://php.weblogs.com/ADOdb_manual#metacolumns
    // otherwise, just an array of names
    
    // postgres hack until adodb fixes this bug
    if( preg_match("@^postgr@", $this->db_type) ) {
      $table = strtolower($table);
    }
    if( !$flag ) {
      return( $this->db_link->MetaColumnNames($table) );
    } else {
      return( $this->db_link->MetaColumns($table) );
    }
  }   
  
  function switchQueryMode($mode = 1) {
    // switches the return array method
    // 1 - associative array
    // 0 - non-associative array
    // mode is associative by default
    global $ADODB_FETCH_MODE;
    $ADODB_FETCH_MODE = ($mode)? ADODB_FETCH_ASSOC : ADODB_FETCH_NUM;
    return $ADODB_FETCH_MODE;
  }
  
  function build_search_clause($params, $andor = "AND") {
    /* 
    ** This function accepts a complex array containing the following format:
    **   "index_name" => array( field_name, condition, value[, flag] )
    ** where:
    **   index_name is a reference for this search parameter (must be unique, can be [])
    **       the index name is used primarily after search completion to check if search
    **       was performed using a certain field (for displaying results)
    **   field_name is the column name in the database
    **   condition is one of the following:
    **      =        !=
    **      contains !contains
    **      like     !like
    **      >        <
    **      >=       <=
    **      in
    **   value is the value to be matched against
    **   value is the value to be matched against
    **      or a comma seperated list of values in
    **      the case that the condition is "in"
    **   flag is an optional parameter which, if set
    **      to 1, would make the match case sensitive
    **
    **   optionally, any of the sets of data in the incoming
    **   params clause could also be an array of data sets with
    **   an and/or modifier to start them (modifier must be in all caps)
    **
    **   EXAMPLE USAGE:
    **
    **  $colorSet           = array();
    **  $colorSet["index2"] = array("field2", "like", "red%");  // begins with red
    **  $colorSet["index3"] = array("field3", ">", "2" );       // greater than 2
    **
    **  $dataSet             = array();
    **  $dataSet["index"1"]  = array("field1", "=","apples",1);    //case sensitive
    **  $dataSet["index2_3"] = array("OR", $colorSet );
    **  $dataSet["index4"]   = array("field4", "in","Fall,Autumn,Winter");
    */
    return $this->recursiveSearchClause($params,$andor);
  }
  
  function recursiveSearchClause($params, $andor) {
    // INTERNAL USE ONLY
    // see the build_search_clause() method for more details
    // recursively prepare a search clause
    
    foreach($params as $p) {
      $list = 0;
      if( $text )
      $text .= " $andor ";
      if( $p[0] == "AND" or $p[0] == "OR" ) {
        $t = $this->recursiveSearchClause( $p[1], $p[0] );
        $text .= "($t)";
      } else {
        $not = ereg("^!",$p[1]);
        $p[1] = ereg_replace("^!", "", $p[1]);
        switch(strtolower(substr($p[1],0,1))) {
          case "c":
          $p[1] = "LIKE";
          $p[2] = "%$p[2]%";
          break;
          case "b":
          $p[1] = "LIKE";
          $p[2] = "$p[2]%";
          break;
          case "e":
          $p[1] = "LIKE";
          $p[2] = "%$p[2]";
          break;
          case "i":
          $p[1] = "IN";
          $p[2] = (is_array($p[2]))? $p[2] : explode(",",$p[2]);
          break;
          case "=":
          break;
          default:
          $p[3] = 1;
          break;
        }
        $p[2] = $this->checkSlashes($p[2]);
        if( !$p[3] && ereg("[a-zA-Z]",$p[2]) ) {
          if( !Zen::inString('mysql',$this->database_type) 
            && !Zen::inString('mssql',$this->database_type) ) {
            $p[0] = "lower($p[0])";
            $p[2] = strtolower($p[2]);
          }
        }
        if( ereg("^NULL$",$p[2]) ) {
          $p[1] = ($not)? "IS NOT" : "IS";
        } else if($not) {
          $p[1] = (ereg("[A-Z]",$p[1]))? "NOT $p[1]" : "!$p[1]";
        }
        $text .= "$p[0] $p[1] $p[2]";
      }
    }
    return($text);
  }
  
  /*
  **  DB RELATED
  */
  
  function db_connect( $host = '', $user = '', $passphrase = '', $database = '' ) {
    // create a db connection
    // see configVars.php for details on how to 
    // configure the db connection
    
    // connect
    $this->db_link->Connect($host, $user, $passphrase, $database);
    if( $database and $this->db_link ) {
      $this->dbName = $database;
    }
    
    if( $this->db_link ) {
      $this->addDebug('db_connect', "Connected successfully to database", 3);
    }
    else {
      $this->addDebug('db_connect', "Could not connect to $user@$host:$database", 1);
    }
    return( $this->db_link );      
  }
  
  /*
  **  INVOKE
  */
  
  function DB( $host = '', $user = '', $passphrase = '', $database = '' ) {
    // call the zenDatabase class
    
    $this->db_type = $this->database_type;
    // create the object
    $this->db_link = &ADONewConnection($this->database_type);
    $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;      
    if( $this->sql_debug == "on" ) { $this->db_link->debug = true; }
    if( preg_match("/postgr/", $this->db_type) ) {
      $this->_returnsResult = false;
    }
    $this->db_connect($host, $user, $passphrase, $database);
  }
  
  var $_returnsResult = true;
  
}

?>