<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  
class zenDatabase {

   var $db_link;
   var $db_name;
   var $db_errnum;
   var $db_error;

   /*
   **  QUERIES
   */   
   
   function db_queryIndexed( $query ) {
      // retrieves an indexed array of results
      // from $query
      // stores any errors in $db_errnum(the code)
      // and $db_error(the message)
      
      $result = mysql_query( $query );
      if( $result and mysql_num_rows($result) ) {
	 while( $vals = mysql_fetch_array($result) )
	   $vars[] = $vals;	 
      } else if( !is_resource($result) ) {
	 $dbErrorNo = mysql_errno();
	 $dbErrorMst = mysql_error();
      }      
      return($vars);
   }

   function db_query( $query ) {
      // returns an array of results
      // from $query
      
      $result = mysql_query( $query );      
      if( $result and mysql_num_rows($result) ) {	 
	 while( $vals = mysql_fetch_row($result) )
	   $vars[] = $vals;
      } else if( !is_resource($result) ) {
	 $this->dbErrNo = mysql_errno();
	 $this->dbErrMsg = mysql_error();
      }
      return($vars);
   }

   function db_quickIndexed( $query ) {
      // returns an indexed row (1 row only)
      // from $query
      $result = mysql_query( $query );
      if( $result and mysql_num_rows($result) )
	$vars = mysql_fetch_array( $result );
      else if( !is_resource($result) ) {
	 $this->dbErrNo = mysql_errno();
	 $this->dbErrMsg = mysql_error();
      }      
      return($vars);
   }

   function db_quick( $query ) {
      // returns a row (1 row only) of
      // results from $query
      $result = mysql_query( $query );
      if( $result and mysql_num_rows($result) )
	$vars = mysql_fetch_row( $result );
      else if( !is_resource($result) ) {
	 $this->dbErrNo = mysql_errno();
      	 $this->dbErrMsg = mysql_error();
      }
      return($vars);
   }
   
   function db_get( $query ) {
      // returns a single value from a db query
      $result = mysql_query( $query );
      if( $result and mysql_num_rows($result) )
	$vars = mysql_fetch_row( $result );
      else if( !is_resource($result) ) {
	 $this->dbErrNo = mysql_errno();
      	 $this->dbErrMsg = mysql_error();
      }
      return($vars[0]);
   }

   function db_result( $query ) {
      // performs an insert, update, delete
      // or other query which does not retrieve
      // data
      $result = mysql_query( $query );      
      if( $result && mysql_affected_rows() ) {
	 return( mysql_affected_rows() );
      } else {
	 $this->dbErrNo = mysql_errno();
	 $this->dbErrMsg = mysql_error();
	 return('');
      }
   }

   function db_list( $query ) {
      // retrieves a single column from the db
      // and returns the results in a simple list
      // array
      $list = $this->db_query($query);
      if( is_array($list) ) {
	 foreach($list as $l) {
	    $v[] = $l[0];
	 }
	 return( $v );
      }
   }
   
   /*
   ** UTILITIES
   */
   
   function db_insertID() {
      // fetches the last mysql insert id from the db
      return( mysql_insert_id() );
   }
   
      
   function checkSlashes( $val = '' ) {
      // checks incoming data for proper escaped ' marks
      // to insure insertion integrity
      
      if( !ereg("[\\]['\"]", $val) && ereg("['\"]", $val) )
	$val = addslashes($val);
      return $val;
   }   
   
   function makeInsertVals( $params, $set = 0 ) {
      // takes an indexed array of parameters and creates a list of columns
      // and values to insert into the database
      // is sensitive to things like NULL and numbers
      // if $set is 1, then this method will return an update formatted list
      // rather than two insert formatted lists
 
      if( !$set ) {
	 foreach($params as $k=>$v) { 
	    $cols .= ($cols)? ", $k" : "$k";
	    if( ereg("^(NULL|FALSE|TRUE|[0-9]+)$", $v) ) {
	       $vals .= ($vals)? ", $v" : "$v"; 
	    } else {
	       $v = $this->checkSlashes($v);
	       $vals .= ($vals)? ", '$v'" : "'$v'";
	    }
	 }
	 return(array($cols,$vals));
      } else {
	 foreach($params as $k=>$v) {
	    if( ereg("^(NULL|FALSE|TRUE|[0-9]+)$", $v) ) {
	       $vals .= ($vals)? ", $k = $v" : "$k = $v"; 
	    } else {
	       $v = $this->checkSlashes($v);
	       $vals .= ($vals)? ", $k = '$v'" : "$k = '$v'";
	    }
	 }
	 return( $vals );
      }
   }
   
   
   /*
   **  DB RELATED
   */
   
   function db_connect( $host = '', $user = '', $passphrase = '', $database = '' ) {
      // create a db connection
      $this->db_link = mysql_connect("$host", "$user", "$passphrase");
      if( $database and $this->db_link ) {
	 $this->dbDB = $database;
	 $result = mysql_select_db( $database, $this->db_link );
      } else
	$result = 1;
      if( !$this->db_link || !$result ) {
	 $dbErrorNo = mysql_errno();
   	 $dbErrorMsg = mysql_error();
      }
      return( $this->db_link );      
   }

   function db_switch( $db ) {
      // switch database instance in use
      $result = mysql_select_db( $db, $this->db_link );
      $this->dbDB = $db;
      if( !$result ) {
      	 $dbErrorNo = mysql_errno();
      	 $dbErrorMst = mysql_error();
      }
      return( $result );
   }   
   
   /*
   **  INVOKE
   */
   
   function zenDatabase( $host = '', $user = '', $passphrase = '', $database = '' ) {
      // call the zenDatabase class
      $this->db_connect($host, $user, $passphrase, $database);
   }
      
}

?>
