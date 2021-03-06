<?php
/**
 * ZenContext: a generic container for properties to be passed between objects
 *
 * This class is intended to be abstract and extended by specific instances for
 * use, such as ZenFieldMapRenderContext
 *
 * @abstract
 */
class ZenContext {
  function ZenContext($vals = null) {
    $this->_vals = is_array($vals)? $vals : array();
    $this->rand = $this->randomNumber = mt_rand(1,10000)."-".mt_rand(1,10000);
  }
  
  function set($prop, $val) {
    $this->_debug('get', "Setting $prop to ".Zen::dval($val), 3);
    $this->_vals[$prop] = $val;
  }
  
  function get($prop) {
    if( !array_key_exists($prop, $this->_vals) ) {
      $this->_debug('get', "Invalid property: $prop", 3);
      return null;
    }
    return $this->_vals[$prop];
  }
  
  function _debug( $method, $msg, $lvl ) {
    $zen = $GLOBALS['zt_zen'];
    if( $zen ) {
      $zen->addDebug("ZenContext::$method", $msg, $lvl);
    }
  }
  
  function printDebug() {
    Zen::printArray($this->_vals, 'ZenContext['.$this->rand.']');
  }
  
  var $_vals;
  var $rand;
}
?>