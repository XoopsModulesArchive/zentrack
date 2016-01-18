<!--

function placeFocus(newFocalPoint) {
	newFocalPoint.focus();
}

function eLink(address, domain) {
  var full = address + "@" + domain;
  document.write("<a href='mailto:"+full+"'>"+full+"</a>");
}

//
//window functions
//

function popupWindow(loadpos, theName, theWidth, theHieght ) {
	controlWindow=window.open(loadpos,theName,"toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,width="+theWidth+",height="+theHieght);
	return(false);
}

function popupWindowScrolls(loadpos, theName, theWidth, theHieght ) {
	controlWindow=window.open(loadpos,theName,"toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width="+theWidth+",height="+theHieght);
	return(false);
}

function popupWindowFull(loadpos, theName, theWidth, theHieght ) {
	controlWindow=window.open(loadpos,theName,"toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width="+theWidth+",height="+theHieght);
	return(false);
}

function popupWindowCentered(loadpos, theName, w, h, scroll) {
  var winl = (screen.width - w) / 2;
  var wint = (screen.height - h) / 2;
  winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizab\
  le'
  win = window.open(loadpos, theName, winprops)
  if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
  return(false);
}

//
//table cell functions
//

function mOvr(src,clrOver,txtOver) {
	src.style.cursor = 'pointer'; 
	src.style.backgroundColor = clrOver;
	if( txtOver != null &&  txtOver != "" ){
	  if( src.children && src.children.tags('A') && src.children.tags('A')[0] ) {
	    src.children.tags('A')[0].style.color = txtOver;
	  }
	}
}

function mOut(src,clrIn,txtIn) {
  src.style.cursor = 'default'; 
  src.style.backgroundColor = clrIn; 
  if( txtIn != null && txtIn != "" ){
    if( src.children && src.children.tags('A') && src.children.tags('A')[0] ) {
      src.children.tags('A')[0].style.color = txtIn;
    }
  }
}

function mClk(src) {
  if( src.childNodes ) {
    for( var i=0; i < src.childNodes.length; i++ ) {
      var n = src.childNodes[i];
      //alert(n+"|"+n.nodeName);//debug
      if( n.nodeName == "A" ) {
        if( n.href != '#' ) {
          window.location = n.href;
          break;
        }
        else if( n.click ) {
          //alert('clickage: '+n.click);//debug
          n.click(); 
          break;
        }
        else {
          //alert('locationage: '+n.href);//debug
          window.location = n.href;
          break;
        }
      }
    }
  }
}

function confirmSubmit(formObject, msg) {
  if( window.confirm(msg) && formObject ) {
    formObject.submit();
  }
}

function ticketClk( url, evt ) {
  var src = getEventSrc(evt);
  // don't override links
  // be careful of IE images... they report an href stupidly
  if( src && !src.src && src.href && src.href != url ) { return true; }
  // this is an image inside a link, let it run too
  var u = src && src.src && src.parentNode && src.parentNode.href? src.parentNode.href : false;
  if( u && u != url ) { return true; }
  // let user check boxes
  if( src && src.type == 'checkbox' ) { return true; }
  // nothing wrong, so go for it
  window.location = url;
  return false;
}

function mClassX( obj, classname, hand ) {
  if( hand ) { 
    obj.style.cursor = 'pointer'; 
  }
  else {
    obj.style.cursor = 'default';
  }
  
  if( !classname && obj.oldStyle ) { classname = obj.oldStyle; }
  if( obj.className ) { obj.oldStyle = obj.className; }
  
  //refToElement.className = 'newclass', or refToElement.setAttribute('class', 'newclass')
  if( obj.setAttribute ) {
    obj.setAttribute('class',classname);
  }
  obj.className = classname;
}

function makeTimeString() {
  var date = new Date();
  return date.getHours()+":"+date.getMinutes()+":"+date.getSeconds()+"-"+date.getMilliseconds();
}

/*
function mergeFunctions(fxn1, fxn2) {
  if( fxn1 ) {
    return function() {
      var fx = fxn1;
      var fy = fxn2;
      fx();
      fy();
    }
  }
  else {
    return fxn2;
  }
}
*/

function getEventSrc( evt ) {
  if( !evt || (!evt.srcElement && !evt.target) ) { evt = window.event; }
  return src = (evt && evt.srcElement)? evt.srcElement : 
      (evt && evt.target)? evt.target : false;
}

function checkMyBox(fieldName, event) {
  if( window.document.getElementById ) {
    var elem = window.document.getElementById(fieldName);
    if( elem ) {
      var src = getEventSrc(event);
      if( !src || (src.type != 'checkbox' && !src.src && !src.href) ) {
        // it's not an image (for a link) or the checkbox itself
        // checking the checkbox causes it to double-check
        // checking on hrefs is altogether bad
        elem.checked = elem.checked? false : true;
      }
      if( elem.parentNode ) { 
        elem.parentNode.parentNode.oldStyle = elem.checked? 'invalidBars' : 'bars'; 
      }    
    }
  }
}

function quickHighlight( fieldName, divToShow ) {
  var fieldObject = eval(fieldName);
  mClassX(fieldObject, 'mark');
  setTimeout("mClassX("+fieldName+")", 1000);
}

function undoHighlight( fieldObject ) {
  if( fieldObject.style ) { fieldObject.style.backgroundColor = ''; }  
}

function toggleField( fieldObj, disabledBoolean ) {
  fieldObj.disabled = disabledBoolean;
  if( !disabledBoolean ) {
    fieldObj.setAttribute('class', 'input');
    fieldObj.className = 'input';
  }
  else {       
    fieldObj.setAttribute('class', 'inputDisabled');
    fieldObj.className = 'inputDisabled';
  }       
}

/**
 * Admin Functions
 */
function addToOnload( newFxn ) {
  window.onload = mergeFunctions( newFxn, window.onload );
}

/**
 * Merges two functions
 */

function mergeFunctions( fxn1, fxn2 ) {
  return function() {
    var res = fxn1();
    if( res === false ) { return false; }
    res = fxn2();
    if( res === false ) { return false; }
    if( res === true ) { return true; }
  }
}

function openHelpBox(divObj, relativeElement, offsetY) {
  if( typeof(offsetY) == 'undefined' ) { offsetY = 25; }
  var pos = getAbsolutePos(relativeElement);
  divObj.style.left = pos.x;
  divObj.style.top = pos.y + 25;
  divObj.style.display = 'block';
  //divObj.style.position = 'absolute';
  setTimeout("closeHelpBox('"+divObj.id+"')", 3000);
}

function closeHelpBox(divObjName) {
  var divObj = window.document.getElementById(divObjName);
  if( divObj.style.display == 'block' ) {
    divObj.style.display = 'none';
  }
}

function getAbsolutePos(el) {
	var SL = 0, ST = 0;
	var is_div = /^div$/i.test(el.tagName);
	if (is_div && el.scrollLeft)
		SL = el.scrollLeft;
	if (is_div && el.scrollTop)
		ST = el.scrollTop;
	var r = { x: el.offsetLeft - SL, y: el.offsetTop - ST };
	if (el.offsetParent) {
		var tmp = this.getAbsolutePos(el.offsetParent);
		r.x += tmp.x;
		r.y += tmp.y;
	}
	return r;
};

function printWindow() {
  popupWindowScrolls(rootUrl+"/actions/print.php?id="+id,'printWindow', 700, 500);
  return false;
}

function toggleDebug( type ) {
  var debugObj = window.document.getElementById('debugContent');
  if( !debugObj || !debugObj.childNodes ) { return; }
  for(var i=0; i < debugObj.childNodes.length; i++) {
    var child = debugObj.childNodes[i];
    if( child.nodeName == 'LI' ) {
      var c = child.className? child.className : child.getAttribute? child.getAttribute('class') : null;
      child.style.display = (type == 'all' || c == type)? 'block' : 'none';
    }
  }
}

function appendUrl(k, v) {
  v = escape(v);
  var u = window.location.href;
  if( u.indexOf("?"+k+"=") > 0 ) {
    var re = new RegExp("[?]"+k+"=[^&]+");
    u = u.replace(re, "?"+k+"="+v);
  }
  else if( u.indexOf("&"+k+"=") > 0 ) {
    var re = new RegExp("&"+k+"=[^&]+");
    u = u.replace(re, "&"+k+"="+v);
  }
  else {
    u += u.indexOf("?") > 0? "&"+k+"="+v : "?"+k+"="+v;
  }
  return u;
}

function updateUrl(k, v) {
  window.location = appendUrl(k,v);
}

function submitThisForm( obj ) {
  var formNode = obj.parentNode;
  while(formNode && !formNode.submit && formNode.nodeName != "DOCUMENT") {
    //alert("formNode="+formNode+", formNode.nodeName="+formNode.nodeName);
    formNode = formNode.parentNode;
  };
  if( formNode.submit ) {
    //alert("submitting "+formNode+"["+formNode.name+":"+formNode.nodeName+"]");
    formNode.submit();
  };
}

function doNothing() { return false; }

//-->
