<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

/**
 * The translation function wrapper
 *
 * SPECIAL NOTE:
 *   This function will be available in the global scope and should facilitate any necessary access to
 *   a translator object. If more access is necessary this is the function that needs to be modified.
 *
 * This function manages all aspects of the translation engine. It performs three different functions.
 *
 * Initialization -
 *   To initialize the engine you need to call this function with an associative array as the first
 *   parameter. The keys for this array are
 *     zen - A reference to a zenTrack object.
 *     domain - A domain to translate from.
 *     path - The path to the domain containing the translation files
 *     locale - The locale to translate too
 *
 * String translation -
 *   To translate a simple string just calling tr() with the string to translate will do the job
 *
 * String translation with variables -
 *   To translate a string with variables that could change just call tr() with the string to translate
 *   as the first parameter. In this string use the token '?' to represent where to place variables.
 *   Then as the second argument pass an ordered array containing the values to substitute in.
 * 
 * @param $string string/array Either an initialization array or the string to translate.
 * @param $vals array A list of values to substitute back into the translated string.
 */
function tr($string, $vals = '') {
  static $translator;
  if (is_array($string)) {
    $translator = new Translator;
    $translator->bindZen($string['zen']);
    $translator->bindDomain($string['domain'], $string['path']);
    $translator->textDomain($string['domain']);
    $translator->setLocale($string['locale']);
    return true;
  }
  if( $vals ) {
    if( !is_array($vals) ) { $vals = array($vals); }
    return $translator->ptrans($string,$vals);
  }
  else {
    return $translator->trans($string);
  }
  //global $zen;
  //return $zen->trans($string,$init);
}   
 
/**
 * This class manages the translation of static strings. It uses translation
 * files that are located in directories specified in the bindDomain() function.
 * The format of these files is forthcoming.
 *
 * Usage:
 * $trans = new Translator;
 * $trans->bindDomain('messages', './locales/messages/');
 * $trans->textDomain('messages');
 * $trans->setLocale('es') //Spanish
 * $trans->trans('Hello World'); //outputs 'Hola Mundo'
 */

class Translator {
/**
 * Creates an instance of the translator class.
 */
   function Translator() {
      $this->_domainList = array();
      $this->_curDomain = '';
      $this->_locale = '';
      $this->_zenObj = null;
      $this->_translationCache = array();
   }

/**
 * Binds the zenClass object to the translator.
 *
 * @param $zenObj object The instance of zenClass to bind to.
 */
   function bindZen(&$zenObj) {
      //This is for error tracking purposes
      $this->_zenObj =& $zenObj;
   }

/**
 * Creates a new domain and binds it to a directory containing that domain's
 * translation files.
 *
 * @param $domain string The new domain to create.
 * @param $path The path containing that domain's translation files.
 * @param $path The path containing that domain's translation files.
 * @return boolean True if $path exists. False if it doesn't.
 */
   function bindDomain($domain, $path) {
      //check path
      if (is_dir($path)) {
         $this->_domainList[$domain] = $path;
         return true;
      }
      else {
         $this->_zenObj->addDebug("Translator->bindDomain", "Domain Path Doesn't Exist: '$path'\n", 1);
         return false;
      }
   }

/**
 * Sets the current locale (language).
 *
 * @param $locale string the two letter ISO abbreviation for the language.
 */
   function setLocale($locale)  {
      $this->_locale = $locale;
   }

/**
 * Sets the current domain.
 *
 * @param $domain string The domain to use.
 * @return boolean True if the domain exists. False if it does not.
 */
   function textDomain($domain) {
      //Check for domain existance
      if (array_key_exists($domain, $this->_domainList)) {
         $this->_curDomain = $domain;
         return true;
      }
      else {
         $this->_zenObj->addDebug("Translator->textDomain", "Domain Does Not Exists: '$domain'\n", 1);
         return false;
      }
   }
   
/**
 * Translates a string with parameters in it
 *
 * @param string $string the string to translate
 * @param array $vals the values to insert into the string
 *
 */
 function ptrans($string, $vals) {
   // get the translated string
   $string = $this->trans($string);
   // replace the ?'s one at a time
   foreach($vals as $v) {
      $string = preg_replace("/\?/", $v, $string, 1);   
   } 
   return $string;
 }

/**
 * Translates a string to the current locale using the current domain
 *
 * @param $string string The text to translate.
 */
   function trans($string) {
      $error = false;
      $translationFile = $this->_domainList[$this->_curDomain] . '/' . $this->_locale . '.trans';
      $compiledFile = $this->_domainList[$this->_curDomain] . '/' . $this->_locale . '.ctrans';
      
      //Check for a cached copy
      if (!array_key_exists($translationFile, $this->_translationCache)) {
         //check for file
         if (!is_file($translationFile)) {
            $this->_zenObj->addDebug("Translator->trans", "Translation File Does Not Exist: '$translationFile'\n", 1);
            $error = true;
         }
         else {
            //check for compiled file
            if ((is_file($compiledFile)) && (filemtime($compiledFile) >= filemtime($translationFile))) {
               $fh = fopen($compiledFile, 'r');
               $serializedArray = fread($fh, filesize($compiledFile));
               $transArray = unserialize($serializedArray);
            }
            else {
               $transArray = $this->_parseTranslationFile($translationFile);
               if ($transArray === false) {
                  $this->_zenObj->addDebug("Translator->trans", "Improper Translation File: '$translationFile'\n", 1);
                  $error = true;
               }
               $serializedArray = serialize($transArray);
               $fh = fopen($compiledFile, 'w');
               fwrite($fh, $serializedArray);
               fclose($fh);
            }
            //Add results to the cache
            $this->_translationCache[$translationFile] = $transArray;
         }
      }

      //Only check the translation if there are currently no errors
      if ($error == false) {
	if( !isset($this->_translationCache[$translationFile][$string]) ) {
	  // translation string doesn't exist, send an error
	  $this->_zenObj->addDebug("Translator->trans", "Translation does Not Exist: '$string'\n", 3);
	  $error = true;	  
	}
	$translatedString = $this->_translationCache[$translationFile][$string];
	if ($translatedString == '') {
	  //Translated string exists, but isn't filled out, so send a notice
	  if( $this->_locale != "english" )
	    $this->_zenObj->addDebug("Translator->trans", "Translation string was empty: '$string'\n", 3);
	  $error = true;	  
	}
      }
      
      //Do a final error check
      //If there are errors return the same string. Otherwise return the translated string
      return ($error)?($string):($translatedString);
   }
   
/**
 * Parses a translation file into an array containing the translations.
 *
 * @param $translationFile string The file to parse.
 */
   function _parseTranslationFile($translationFile) {
      //Check for an error.
      if (is_file($translationFile)) {
         $status = 'none'; //Previous command
         $currentMsgID = '';
         $currentMsgStr = '';
         $matchFilter = '/^(\w+)?\s*"(.*)"/';
         $translationArray = array();
         
         $fileLines = file($translationFile);
         foreach ($fileLines as $line) {
            $filterMatches = array();
            preg_match($matchFilter, $line, $matches);
            
            //If no command is given revert back to the last command ($status)
            if ($matches[1] == '') $matches[1] = $status;
            //determine command
            switch ($matches[1]) {
            case 'msgid':
               //Add the last msg to the array (if there was one);
               if (($status != 'msgid') && ($currentMsgID != '')) {
                  $translationArray[$currentMsgID] = $currentMsgStr;
                  $currentMsgID = '';
               }
               //If there is currently text then we need to append.
               $currentMsgID = ($currentMsgID == '')?($matches[2]):(rtrim($currentMsgID) . ' ' . $matches[2]);
               $currentMsgStr = '';
               $status = 'msgid';
               break;
            case 'msgstr':
               //Only add a message if there is a message to add
               if ($matches[2] != '') {
                  //If the last command was a msgstr then a trailing space needs to be
                  //added before appending text
                  $currentMsgStr = ($currentMsgStr == '')?($matches[2]):(rtrim($currentMsgStr) . ' ' . $matches[2]);
               }
               $status = 'msgstr';
               break;
            }
         }
         if (($currentMsgID != '')) {
            $translationArray[$currentMsgID] = $currentMsgStr;
            $currentMsgID = '';
         }
         return $translationArray;
      }
      else {
         $this->_zenObj->addDebug("Translator->_parseTranslationFile", "Translation File Does Not Exist: '$translationFile'\n", 2);
      }
   }

/**
 * Maintains file associations for domain lists.
 *
 * @var array $_domainList
 */
   var $_domainList;
   
/**
 * The current translation domain in use.
 *
 * @var string $_curDomain
 */
   var $_curDomain;
   
/**
 * The current translation locale (language) in use.
 *
 * @var string $_locale
 */
   var $_locale;
   
/**
 * The zenClass object this object is bound to. For error handling purposes.
 * This is intended to be depreciated by version 3.0.
 *
 * @var object $_zenObj
 */
   var $_zenObj;
   
/**
 * The translation cache. Any translation files that have been parsed are
 * stored here.
 *
 * @var array $_translationCache
 */
   var $_translationCache;
}


?>
