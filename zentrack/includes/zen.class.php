<?php
/* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */
if( !ZT_DEFINED ) { die("Illegal Access"); }


include_once("$libDir/zenDate.class.php");
  
class zen extends zenDate {
 
   // this class includes basic formatting functions
   // and utilities used by the various pages.
   // it also extends the zenDate class to pull those
   // functions into use for the rest of zenTrack.
   
  /**
   * STATIC: safely check for equality of two values when type is unsure
   *
   * This method can accurately compare nulls, values which are not set,
   * Objects and most other things accurately.
   *
   * @param mixed $val1
   * @param mixed $val2
   * @return boolean
   */
  function safeEquals( $val1, $val2 ) {
    if( !isset($val1) xor !isset($val2) ) {
      // if only one is set
      return false;
    }
    else if( is_array($val1) && is_array($val2) ) {      
      return Zen::arrayEquals($val1, $val2);
    }
    else if( $val1 != $val2 || strlen($val1) != strlen($val2) ) {
      return false;
    }
    return true;
  }
   
   
  /**
   * STATIC: Recursively checks values of two arrays for equality
   *
   * @param array $arr1
   * @param array $arr2
   * @return boolean
   */
  function arrayEquals( $arr1, $arr2 ) {
    foreach( $arr1 as $key=>$val ) {
      if( !isset($arr2[$key]) ) {
        // don't try to test if arr2[key] isn't set or causes warnings
        // so see if val isset
        if( isset($val) ) {
          return false;
        }
        continue;
      }
      if( !Zen::safeEquals($val, $arr2[$key]) ) {
        return false;
      }
    }
    return true;
  }

   /*
   **  TEXT FORMATTING
   */
   
   /**
    * Translates text, and then converts it to title case
    */
    function ttl( $text ) {
      return $this->titleCase($this->trans($text));
    }
   
   function titleCase( $text ) {
      /*
      ** The title case function converts the string to a title ready
      ** format by capitalizing all words, excepting those 
      ** found in lcwords, and converting all words found in ucwords to
      ** all upper case
      */
      if( strlen($text) ) {
       $text = ucwords(strtolower($text));
       $text = ereg_replace(" $lu\b", " $l", $text);
       // fix lower case words
       foreach($this->getLcWords() as $l) {
         $text = preg_replace("/\b".ucfirst($l)."\b/", $l, $text);
       }
       // fix acronyms
       foreach($this->getUcWords() as $u) {
          $text = preg_replace("/\b".ucfirst(strtolower($u))."\b/", "$u", $text);
       }
       // fix funny first characters
       if( preg_match("/^([^a-zA-Z]*[a-z])/", $text, $matches) ) {
          $text = preg_replace("/^([^a-zA-Z]*[a-z])/", strtoupper($matches[1]), $text);
       }
       // fix words with dashes
       $text = preg_replace("/([a-z])+-([A-Z])/", "'\\1-'.strtolower('\\2')", $text);
       return $text;
      }
   }

   /**
    * returns a list of words that should be in lower case (prepositions and articles)
    */
   function getLcWords() {
     if( !is_array($this->_lcwords) ) {
        $this->_lcwords = array();
        foreach($this->getFileArray($this->listDir."/lcwords") as $l) {
          $this->_lcwords[] = trim($l);
        }
     }
     return $this->_lcwords;
   }
   
   /**
    * returns an array of words that should be shown in upper case (acronyms)
    */
   function getUcWords() {
     if( !is_array($this->_ucwords) ) {
        $this->_ucwords = array();
        foreach($this->getFileArray($this->listDir."/ucwords") as $u) {
          $this->_ucwords[] = trim($u);
        }
        foreach($this->getFileArray($this->listDir."/stateAcronyms") as $u) {
          list(,$u) = explode(",",$u);
          $this->_ucwords[] = trim($u);
        }
     }
     return $this->_ucwords;
   }
   
   function ffvText( $val = '', $strlen = 0 ) {
     $val = $this->ffv($val, $strlen);
     $val = nl2br($val);
     return $val;
   }

   function ffv( $val = '', $strlen = 0 ) {
     // converts special characters to ascii codes
     // to be used in <input> fields
     if( is_array($val) ) {
       $vars = array();
       foreach($val as $k=>$v) {
         $vars[$k] = $this->ffv($v);
       }
       return $vars;
     }
     if( strlen($val) ) {
       if( $strlen && strlen($val) > $strlen ) { $val = substr($val,0,$strlen); }
       if( $val ) {
         $val = htmlspecialchars($val,ENT_QUOTES,$this->settings["character_set"]);
         $val = str_replace('\\', '&#92;', $val);
         // $val = str_replace('&amp;', '&', $val);
       }
     }
     return $val;
   }
   
   function fhv( $val = '', $strlen = 0 ) {
     $val = Zen::ffv($val,$strlen);
     return strlen($val)? $val : '&nbsp;';
   }
   
   function fixJsHtml( $val, $char = '"' ) {
     $val = str_replace($char, ($char == '"'? '&quot;' : '&#39;'), $val);
     $val = str_replace('<', '&lt;', $val);
     $val = str_replace('>', '&gt;', $val);
     return $char.$val.$char;
   }

   function fixJsVal( $val, $char = '"' ) {
     // escape any js sensitive characters for use in strings
     if( is_null($val) ) { return "null"; }
     if( preg_match('@^[0-9]+$@', $val) ) {
       return $val;
     }
     if( strlen($val) == 0 ) { return "$char$char"; }
     $val = str_replace($char, "\\$char", str_replace("\\", "\\\\", $val));
     return $char.$val.$char;
   }
   
   function checkAlpha( $val = '', $special = '_' ) {
     // strips all chars not in a-z, A-Z and $special
     if( !strlen($val) )
       return '';
     return preg_replace("@[^a-zA-Z$special]@", "", $val);
   }

   function checkAlphaNum( $val = '', $special = '_' ) {
     // strips all non a-z, A-Z, 0-9 and chars in $special
     // from the entry
     if( !strlen($val) )
       return '';
     return preg_replace("@[^a-zA-Z0-9$special]@", "", $val);
   }
   
   function checkNum( $val = 0, $decimal=false ) {
     if( is_array($val) ) {
       for($i=0; $i<count($val); $i++) {
         $val[$i] = Zen::checkNum($val[$i]);
       }
       return $val;
     }
     
     // converts values to integer or 
     // decimal if $decimal == true;
     $val = ($decimal)? 
        preg_replace("@[^0-9.]@", "", $val) : preg_replace("@[^0-9]@", "", $val);
     return strlen($val)? $val : 0;
   }

   function checkEmail( $val = '' ) {
     if( $val ) {
       $val = preg_replace("/[^a-zA-Z0-9_.@-]/", "", $val);
       if( !preg_match("/[a-zA-Z0-9_.-]+@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_.-]+/",
             $val) ) {
         $val = "";
       }
     }
     return $val;
   }
   
   function stripPHP( $val = '' ) {
     // replaces php tags with ascii code
      if( strlen($val) )
   return str_replace("<?", "&lt;?", str_replace("?>", "?&gt;", $val));
   }
   
   function getFileArray( $file, $delim = '', $index = '', $combined = 0 ) {
      // makes an array from a file, each line of the file is one line in the array
      // if $delim is given, then each row of data is split on that expression and 
      // made into a sub-array if $index is set to an integer, then that number of 
      // the sub-array is assigned as the index of the sub-array
      // if $combined is set to 1, then the array is constructed with multiple rows
      // under each index id (rather than overwriting if there is a duplicate)
      if( file_exists($file) ) {
    $vals = $this->cleanText(file($file));
    if( is_array($vals) ) {
       foreach($vals as $v) {
          if( strlen($v) && !ereg("^#", $v) ) {
        if( strlen($delim) ) {
           $vals = explode($delim,$v);
           if( strlen($index) ) {
         list($n) = array_splice($vals,$index,1);
         if( $combined ) {
            $arr["$n"][] = $vals;
         } else {
            $arr["$n"] = $vals;
         }
           } else {
         $arr[] = $vals;       
           }
        } else {
           $arr[] = $v;
        }
          }
       }
    }
    return $arr;
      }
   }
   
   function cleanText( $text = '' ) {   
      /*
      ** The clean text method creates an array out of a multi-line file
      ** by splitting the contents on the carriage returns, and strips
      ** any extraneous carriage return chars from the file
      */
      
      $contents = (is_array($text))? $text : explode("\n", $text);
      for( $i=0; $i<count($contents); $i++ ) {
    $contents[$i] = ereg_replace(chr(13), "", $contents[$i]);
    $contents[$i] = ereg_replace(chr(14), "", $contents[$i]);
    $contents[$i] = ereg_replace(chr(10), "", $contents[$i]);
    $contents[$i] = trim($contents[$i]);
      }
      return $contents;
   }

   function highlight( $text, $match, $h = '' ) {
     /*
     ** The highlight function searches for matches and highlights them
     ** using the two values of array $h as opening and closing tags
     **    Example:
     **       $text = 'some goats ran';
     **       $match = 'goats';
     **       $h = array('<b>','</b>');
     **    Result:
     **       'some <b>goats</b> ran'
     **
     **  text  - full text
     **  match - words/expressions to highlight
     **  h     - [optional,default is <b></b>] array containing the pre 
     **          and post tags to use for highlighting
     */
     
     if( !$match ) { return $text; }

     if( !is_array($h) )
        $h = $this->defaultHighlight;
     if( !is_array($text) ) {
       $join = 1;
       $text = array($text);
     }
     else { $join = 0; }
     if( !is_array($match) )
        $match = array($match);
     for( $i=0; $i<count($text); $i++ ) {
       foreach($match as $m) {
         $m = str_replace('/','\\/',$m);
         $text[$i] = preg_replace("/($m)/i", "$h[0]\\1$h[1]", $text[$i]);
       }
     }
     if( $join ) {
       return($text[0]);
     } else {
       return($text);
     }
   }

   /********************
   **  FORM UTILITIES
   *********************/


   /*
   **  Formats incoming data from forms.  To clean a single value, see Zen::cleanValue instead.
   **
   **  There are several ways to call this function:
   **    With with only $vals -- strips html excepting html_allowed from $vals and returns array
   **    With $fields & $vals -- formats $vals as specified in $fields(both indexed arrays) 
   **                            and returns array
   **    With only $fields -- pulls variables listed in $fields by reference, formats 
   **                         (using global attribute) and returns nothing
   **
   **  There are several values for the indexed array 'fields' which can be used
   **
   **    case "alpha":     letters only
   **    case "alphanum":  letters and numbers only
   **    case "string":    [a-zA-Z0-9_ '-]
   **    case "filename":  [a-zA-Z0-9_.-]
   **    case "num":       numbers and decimal symbols only
   **    case "int":       numbers only
   **    case "date":      date chars format only
   **    case "html":      all but php tags allowed
   **    case "text":      strip all html
   **    case "ignore":    leave this fields alone
   **    case "email":     email format
   **    case "array":     ignored (legacy entry)
   **    case "":          strip all html excepting $mda->html_allowed (determined by lists/okhtmltags)
   */
   function cleanInput( $fields = '', $vals = '' ) {
     if( is_array($vals) ) {
       $vars = $vals;
       $vals = array();
       foreach($vars as $k=>$v ) {
         if( is_array($fields) ) {
           $f = $fields["$k"];
         } else if( $fields ) {
           $f = $fields;
         }
         if( !$f ) {
           $vals["$k"] = strip_tags( $v, $this->html_allowed );
         } else if( !strlen($v) ) {
           $vals["$k"] = null;
         } else {
           $vals["$k"] = Zen::cleanValue($f, $v);
         }       
       }
       return $vals;
     } else {
       foreach( $fields as $k=>$v ) {
         $GLOBALS["$k"] = Zen::cleanValue($v, $GLOBALS["$k"]);
       }
     }
   }
   
   function cleanValue( $type, $v ) {
     $v = Zen::dropSlashes($v);
     switch( strtolower($v) ) {
       case "alpha":
         $v = $this->checkAlpha($v);
         break;
       case "alphanum":
         $v = $this->checkAlphaNum($v);
         break;     
       case "array":
         $v = (is_array($v))? $v : null;
         break;       
       case "date":
         $v = ereg_replace("[^0-9/: -]", "", $v);
         break;
       case "email":
         $v = ereg_replace("[^0-9a-zA-Z@._-]", "", $v);
         break;             
       case "html": 
         $v = $this->stripPHP( $v );
         break;
       case "int":
         $v = $this->checkNum($v);
         break;       
       case "ignore":
         break;
       case "num":
         $v = $this->checkNum($v,true);
         break;
       case "string":
         $v = $this->checkAlphaNum($v, " _-");
         break;
       case "filename":
         $v = $this->checkAlphaNum($v, "_.-");
         break;
       case "text":
         //$v = $v;
         break;
       default:
         $v = strip_tags($v, $this->html_allowed);
     }
     return $v;
   }
   
   function dropSlashes($val) {
     if( !get_magic_quotes_gpc() ) { return $val; }
     if( is_array($val) ) {
       foreach($val as $k=>$v) {
         $val[$k] = Zen::dropSlashes($v);
       }
       return $val;
     }
     return stripslashes($val);
   }

   function hiddenField( $name, $value = '' ) {
     // there are 4 possibilities for this function
     // option 1: $name is string, $value is string
     //     one hidden tag created for this
     // option 2: $name is array, $value = ""
     //     name is expected to be an indexed array
     //     containing array("name"=>"value",...)
     //     one hidden tag created for each name/value pair
     // option 3: $name is array, $value is array
     //     each element of $name matched to $value
     //     arrays must be equal length
     // option 4: $name is string, $value is array
     //     $name is the name of an array that is to
     //     be submitted, and $value contains the values
     //     <... name='name_string[]' value='value_1'...>, etc
     // option 5: $name is an array, $value is a string
     //     $name is a list of names, and $value is to
     //     be assigned to all of them
     // this function checks the data for funky symbols, etc
     // before displaying

     if( is_array($name) && !strlen($value) ) {
       // show each name=>value pair
       foreach($name as $k=>$v) {
    print "<input type=\"hidden\" name=\"".$this->ffv($k)
      ."\" value=\"".$this->ffv($v)."\">\n";
       }
     } else if( is_array($name) && is_array($value) ) {
       // show each matching pair
       for($i=0; $i<count($name); $i++) {
    print "<input type=\"hidden\" name=\"".$this->ffv($name[$i])
      ." value=\"".$this->ffv($value[$i])."\">\n";  
       }
     } else if( is_array($name) ) {
       // show same value for all of $name
       $value = $this->ffv($value);
       for($i=0; $i<count($name); $i++) {
    print "<input type=\"hidden\" name=\""
          .$this->ffv($name[$i])."\" value=\"".$value."\">\n";  
       }
     } else if( is_array($value) ) {
       // make an array set
       $name = $this->ffv($name);
       for($i=0; $i<count($value); $i++) {
    print "<input type=\"hidden\" name=\"".$name."[".$i."]\" value=\""
               .$this->ffv($value[$i])."\">\n";  
       }
     } else {
       print "<input type=\"hidden\" name=\"".$this->ffv($name)
    ."\" value=\"".$this->ffv($value)."\">\n";
     }
   }

   /*
   **  UTILITIES
   */   
   
   function encval( $text ) {
      // creates an encrypted value suitable
      // for passphrase use
      // abstracted to prevent problems
      // with future versions
      return( md5($text) );
   }

   function setOffsetImages( $left, $right ) {
     // replaces the images used for createOffsetLinks()
     // method.  These should be arrays containing the following:
     // ( "valid url", "image width", "image height" )

     $this->leftOffsetImage = $left;
     $this->rightOffsetImage = $right;
   }

   function createOffsetLinks( $current, $step, $total, $more = '' ) {
     // return 4 links for offsetting
     // they are: ( start, left, text, right )
     // corresponding to "<<<<", "<<previous", "x of n", and "next>>"
     // if $more is given, then it will be added onto the query string
     // for the links (i.e. "id=20&name=ralph" will add &id=20&name=ralph to the url)
     // example: 10-30 of 50
     // $current corresponds to the offset number, i.e. 10
     // $step corresponds to the number per page, i.e. 20
     // $total corresponds to the total number, i.e. 50

     // find out where we are (for links)
     global $SCRIPT_NAME;
     // make sure links are applicable
     if( $total > $step ) {
       if( $more )
         $more_link = "&$more";
       // set image properties
       $pts = $this->leftOffsetImage;
       $lt = "<img src='$pts[0]' width='$pts[1]' height='$pts[2]' alt='$pts[3]' border='0' hspace='6'>";
       $llt = "<img src='$pts[0]' width='$pts[1]' height='$pts[2]' alt='$pts[3]' border='0'>";
       $prev = $pts[3];
       $pts = $this->rightOffsetImage;
       $gt = "<img src='$pts[0]' width='$pts[1]' height='$pts[2]' alt='$pts[3]' border='0' hspace='6'>";
       $next = $pts[3];
       // determine starting and end points for links
       $next_to = ($current + $step > $total)?
         $total : $current + $step;
       $next_curr = $current + 1;
       // if current > 0, then there is a previous
       if( $current > 0 ) {
         $next_down = ($current - $step > 0)?
           $current - $step : 0;
       }
       // if next_to < total, then there is a next
       if( $next_to < $total ) {
         $next_up = $next_to;
       }
       // if last > 0, then make the 'start' link
       if( $next_down ) {
         $pplink = "<a href='$SCRIPT_NAME?offset=0$more_link'>$llt$llt</a>";
       }
       // if last exists, then make the 'last' link
       if( strlen($next_down) ) {
         $diff = $current - $next_down;
         $plink = "<a href='$SCRIPT_NAME?offset=$next_down$more_link'>$lt$prev $diff</a>";
       }
       // create the text
       $text = "$next_curr-$next_to of $total";
       // if next_up then create the next link
       if( $next_up ) {
         $diff = ($next_up + $step > $total)?
           ($total - $next_up) : $step;
         $nlink = "<a href='$SCRIPT_NAME?offset=$next_up$more_link'>$next $diff$gt</a>";
       }
       // return the links
       return( array($pplink,$plink,$text,$nlink) );
     }
   }
   
   /*
   **  ERROR REPORTING
   */      
   
   function printErrors( $errs = '' ) {
      // prints an array of errors
      // in red, as a formatted list
      if( is_array($errs) && count($errs) ) {
        print "<span class='error'><b>Errors Detected</b><ul>\n";
        foreach($errs as $e)
        print "<li class='error'>".$this->ffv($e)."</li>\n";
        print "</ul></span>";
      }
   }
   
   function print_errors( $errs = '' ) {
      // alias to printErrors()
      
      return($this->printErrors($errs));
   }
   
   
   /*
   **  DEBUGGING
   */

   /**
    *  This creates some debugging output to
    *  display errors and messages
    *
    *  @param string $title is the name of the method/page calling addDebug
    *  @param string $msg is the text to display for the debug message
    *  @param integer $lvl 1-error, 2-warning, 3-notice
    */
   function addDebug( $title, $msg, $lvl = 3 ) {
     if( $lvl <= $this->debug )
       $this->debugMessages[] = (is_array($msg))?
     array($title,$msg,$lvl) :
     array($title,$this->ffv($msg),$lvl);
   }

   /**
    * returns debug information for a given method
    *
    * @param string $class name of the class (not currently used)
    * @param string $method name of the method
    * @return array indexed, contains debug messages, source, and level
    */
   function returnDebug( $class, $method ) {
     $vals = array();
     foreach($this->debugMessages as $d) {
       if( $d[0] == $class ) {
	 $vals[] = $d;
       }
     }
     return $vals;
   }
   
   /**
    * Prints the debug output collected by addDebug()
    */
   function printDebugMessages() { 
     if( is_array($this->debugMessages) ) {
       $styles = array("","error","warning","note");
       if( is_array($this->debugMessages) ) {   
         foreach($this->debugMessages as $v) {
           $n = $v[2];
           $style = $styles[$n];
           print "<li class='$style'>$v[0]: \"";
           if( is_array($v[1]) ) {
             Zen::printArray($v[1]);
           }
           else {
             print $v[1];
           }
           print "\"";
         }
       }      
     }
   }
   
   /**
    * Prints the debug output collected by addDebug() in javascript code
    *
    * <p>This will be printed in a javascript friendly format, with each
    * line commented.
    */
   function printJsFriendlyDebug() {  
     if( is_array($this->debugMessages) ) {
       $styles = array("","error","warning","note");
       print "// --------MESSAGES--------\n";
       print "// To disable this output, set \$Debug_Mode in header.php to 0.\n";
       if( is_array($this->debugMessages) ) {   
         foreach($this->debugMessages as $v) {
           $n = $v[2];
           $style = $styles[$n];
           print "//   [$style] - $v[0]: ";
           if( is_array($v[1]) ) {
             print "\n/** (array output)\n";
             print_r($v[1]);
             print "**/\n";
           }
           else {
             print '"';
             print $v[1];
             print '"'."\n";
           }
         }
       }
       print "// ------MESSAGES------\n";
     }
   }

  /**
   * STATIC: Prints an array out as formatted text (debug utility)
   *
   * @param array $vals can be key/value, multi-level, etc
   * @param string $title printed as title of array
   * @return boolean true if the object was valid and printed
   */
  function printArray( $vals, $title = null ) {
    if( $title ) { print "<p><b>$title</b><div style='font-size:11px'>\n"; }
    if( !is_array($vals) ) { print "<p style='color:red'>-not_array-</p>"; }
    print "<pre>\n";
    print_r($vals);
    print "</pre>\n";
    if( $title ) { print "</div></p>\n"; }
    return true;
  }
  
  /**
   * Determine if string contains a given substring
   *
   * @param string $pattern the text to search for
   * @param string $text the string to be searched
   * @return boolean
   */
   function inString( $pattern, $text ) {
     return strlen(strpos($text, $pattern));
   }
   
   /**
    * Translate prepared strings using the translate class
    *
    * @param string $string a string containing ? chars
    * @param array $vals the vals to replace ? chars with
    * @return string the translated string
    */
   function ptrans( $string, $vals ) {
     //return $this->_translator->ptrans($string,$vals);    
     return $this->trans($string, $vals);
   }
   
   /**
    * Translate strings using the translate class
    *
    * This function will call an instance of the translate class, if one doesn't exist
    * @param string $string the string to translate
    * @param array $vals the vals to replace any ? chars with
    * @return string the translated text
    */
   function trans( $string, $vals = '' ) {
     //if (!is_a($this->_translator, 'Translator')) {
     //   $this->_translator = new Translator;
     //   $this->_translator->bindZen($init['zen']);
     //   $this->_translator->bindDomain($init['domain'], $init['path']);
     //   $this->_translator->textDomain($init['domain']);
     //   $this->_translator->setLocale($init['locale']);
     //   return true;
     // }
     //return $this->_translator->trans($string);
     return tr($string, $vals);
   }

   /**
    * Returns a boolean indicating that euro dates are enabled
    */
   function euroDateEnabled() {
     return $this->euroEnabled;
   }

   function popupDateFormat() {
     if( $this->euroDateEnabled() ) {
       return "dd/mm/yyyy";
     }
     else {
       return "mm/dd/yyyy";
     }
   }
   
  /**
   * Merges two arrays into a single array.  Does not throw a warning if one
   * of the arrays is null.  If the arrays are indexed, values from the second
   * array will overwrite the first if the keys are equal.
   *
   * @param array $arr1
   * @param array $arr2
   * @return array an empty array if both values are null or empty
   */
   function mergeArrays($arr1, $arr2) {
     if( is_array($arr1) && is_array($arr2) ) { return $arr1 + $arr2; }
     else if( is_array($arr1) ) { return $arr1; }
     else if( is_array($arr2) ) { return $arr2; }
     else { return array(); }
   }
   
   /**
    * Converts file names to an absolute path name using / characters.
    */
    function cleanPath( $path ) {
      return str_replace('\\', '/', realpath($path) );
    }
    
   /**
    * Adds a variable to a url appropriately
    *
    * @static
    */
   function addToUrl( $url, $key, $val ) {
     $key = urlencode($key);
     $val = urlencode($val);
     $tf = strpos($url, '?') > 0;
     return $url . ($tf? "&$key=$val" : "?$key=$val");
   }
   
   /**
    * Return a value for use in debugging.  This will handle arrays, objects,
    * numbers, and strings intelligently, printing out a representative
    * value for them.
    *
    * @static
    * @param mixed $val the value to print
    * @param boolean $dump_contents if true, dumps all values of arrays or objects
    * @param boolean $format include line breaks
    * @return string
    */
   function dval( $val, $format = true, $dump_contents = true ) {
     $indent = func_num_args() > 3? func_get_arg(3) : 0;
     $char = "   ";
     $tabs = $indent? str_repeat($char,$indent) : "";
     if( is_object($val) ) {
       $txt = "Object(".get_class($val).")";
       if( $dump_contents ) {
         $txt .= $format? " {\n" : " {";
         $i=0;
         foreach( get_object_vars($val) as $k=>$v ) {
           if( $format ) { $txt .= $tabs.$char; }
           $txt .= $k."=>".Zen::dval($v,$dump_contents,$format,$indent+1)
              .($i++ < count($val)-1? ', ' : '');
           if( $format ) { $txt .= "\n"; }
         }
         $txt .= $format? "$tabs}\n" : "}";
       }
       return $txt;
     }
     else if( is_array($val) ) {
       $txt = "Array";
       if( $dump_contents ) {
         $txt .= $format? " [\n" : " [";
         foreach($val as $k=>$v) {
           if( $format ) { $txt .= $tabs.$char; }
           $txt .= "{$k}=>";
           $txt .= Zen::dval($v,$dump_contents,$format,$indent+1);
           $txt .= $i++ < count($val)-1? ($format? ",\n" : ",") : ($format? "\n":'');
         }
         $txt .= $format? "$tabs]\n" : "]";
       }
       return $txt;
     }
     else if( is_bool($val) ) {
       $txt = $val? 'true' : 'false';
     }
     else if( is_null($val) ) {
       return 'null';
     }
     else if( preg_match('/[^0-9]/', $val) ) {
       return "'".Zen::ffv($val)."'";
     }
     else {
       return $val;
     }
   }
   
   /**
    * Print a value for use in debugging.  This will handle arrays, objects,
    * numbers, and strings intelligently, printing out a representative
    * value for them.
    *
    * @static
    * @param mixed $val the value to print
    * @param boolean $format include line breaks
    * @param boolean $dump_contents if true, dumps all values of arrays or objects
    */
   function dprint( $val, $format = true, $dump_contents = true ) {
     print Zen::dval( $val, $dump_contents );
   }
   
   /**
    * Print a value as in Zen::dprint(), but set it up to display in html
    */
   function dprintf( $val, $dump_contents = true ) {
     print "<pre>".Zen::dval($val, $dump_contents, true)."</pre>";
   }
   
   /*
   **  SYSTEM METHODS
   */
   
   
   function zen() {
     $this->zenDate();
   }
   
   /*
   **  VARIABLES
   */ 
   
   var $html_allowed;
   var $debugMessages;
   var $defaultHighlight;
   var $listDir;
   var $_ucwords;
   var $_lcwords;
   //var $_translator;
   
} 
  
?>