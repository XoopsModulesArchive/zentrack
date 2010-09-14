<?php
  include_once(dirname(__FILE__)."/header.php");  
  header("Content-Type: text/css");
?>
<!--
 
  /*** PAGE PROPERTIES ***/
/*  
  IMG {
    behavior: url("<?php echo $rootUrl?>/pngbehavior.htc");
  }
*/

  BODY {
     background:       <?php echo $zen->getSetting("color_background"); ?>;
     color:            <?php echo $zen->getSetting("color_text"); ?>;
     font-family:      <?php echo $zen->getSetting("font_face"); ?>;
     font-size:        <?php echo $zen->getSetting("font_size"); ?>px;
     margin-left:      4px;
     margin-top:       4px;
  }
  
  TD {
     font-family:      <?php echo $zen->getSetting("font_face"); ?>;
     font-size:        <?php echo $zen->getSetting("font_size"); ?>px;
     align-vertical:   top;
  }
  
  LI {
     margin-top: 5px; 
  }
  
  FORM {
     display: inline;
     margin: 0px;
     padding: 0px;
  }
  
  

  /*** PAGE COMPONENTS ***/

  .page_section {
     font-size:       <?php echo $zen->getSetting("font_size_large"); ?>px;
     color:           <?php echo $zen->getSetting("color_alt_text"); ?>px;
     font-weight:     bold;     
  }

  .mainContent {
      background: <?php echo $zen->getSetting("color_bars"); ?>;
      /* padding: 5px; */
  }
  
  .padded {
    padding: 3px !important;
  }
  
  .ridge {
    border-top: 2px outset <?php echo $zen->getSetting('color_bars'); ?>;
    border-bottom: 2px outset <?php echo $zen->getSetting('color_bars'); ?>;
  }
  
  .lip {
    border-top: 2px inset <?php echo $zen->getSetting('color_bar_darker'); ?>;
  }
  
  .bottom {
    border-bottom: 1px solid <?php echo $zen->getSetting('color_bar_border'); ?>;
  }

  .gutter {
    padding-left: 5px;
  }
  
  TD.navpad {
    padding-top: 3px;
    padding-bottom: 3px;
    padding-left: 0px;
    padding-right: 0px;
  }
  
  .indent, .indented {
    padding-left: 10px;
    padding-right: 10px;
  }
  
  .boxpad {
    padding: 10px;
  }
  
  .tabpad {
    padding-top: 5px;
  }
  
  .formtable {
    background: <?php echo $zen->getSetting('color_background'); ?>;
  }
  
  .formtable TD {
    padding: 3px;
  }
  
  /*** LINK PROPERTIES ***/

  A {
     text-decoration: none;
     color:           <?php echo $zen->getSetting("color_links"); ?>;
  }

  A:hover {
     text-decoration: underline;
  }

  A.menuLink {
     color:       <?php echo $zen->getSetting("color_title_txt"); ?>; 
     font-size:   <?php echo $zen->getSetting("font_size"); ?>;
     font-weight: bold;
     font-family: <?php echo $zen->getSetting("font_face"); ?>;
  }

  A.menuLink:hover{
     text-decoration: none;
     color: <?php echo $zen->getSetting("color_title_txt"); ?>;
  }

  A.subMenuLink {     
     color:      <?php echo $zen->getSetting("color_title_txt"); ?>; 
     font-size:  <?php echo $zen->getSetting("font_size_small"); ?>;
  }

  A.subMenuLink:hover {
     text-decoration: none;
     color:           <?php echo $zen->getSetting("color_title_txt"); ?>;
     font:            <?php echo $zen->getSetting("font_size_small"); ?>;
  }

  A.rowLink {
     color:           <?php echo $zen->getSetting("color_text"); ?>;
  }

  A.rowLink:Hover {
     color:           <?php echo $zen->getSetting("color_text"); ?>;
     text-decoration: none;
  }
  
  A.tabsOn {
     color:           <?php echo $zen->getSetting("color_text"); ?>;
     text-decoration: none;     
  }

  A.tabsOn:hover {
     color:  #000099;
  }

  A.tabsOff {
     color:           <?php echo $zen->getSetting("color_title_text"); ?>;
     text-decoration: none;     
  }
 
  A.tabsOff:hover {
     color: #FFFF00;
  }

  /*** PRIORITY PROPERTIES ***/
<?php
  include("$libDir/priorityColors.php");
?>

  /*** CELL PROPERTIES ***/

  .altCell {
     color:       <?php echo $zen->getSetting("color_alt_background"); ?>;
     background:  <?php echo $zen->getSetting("color_alt_text"); ?>;
     padding: 2px;
     border:  1px solid <?php echo $zen->getSetting('color_alt_background'); ?>;
  }

  .altCellInv {
     color:       <?php echo $zen->getSetting("color_alt_text"); ?>;
     background:  <?php echo $zen->getSetting("color_alt_background"); ?>;
     padding: 2px;
  }

  .cell, .invalidCell, .content, .labelCell {
     color:       <?php echo $zen->getSetting("color_alt_text"); ?>;
     background:  <?php echo $zen->getSetting("color_background"); ?>;
     padding: 2px;     
  }
  
  .labelCell {
     font-weight: bold; 
  }
  
  .content {
     padding: 10px; 
  }
  
  .invalidCell {
    color:       <?php echo $zen->getSetting('color_hot'); ?>;
  }

  .bars, .bar, .invalidBars {
     color:       <?php echo $zen->getSetting("color_bar_text"); ?>;
     background:  <?php echo $zen->getSetting("color_bars"); ?>;
     padding: 2px;
     border: 1px solid <?php echo $zen->getSetting('color_bars'); ?>;
  }
  
  .invalidBars TD {
    color:    <?php echo $zen->getSetting('color_hot'); ?>;
    border: 1px solid <?php echo $zen->getSetting('color_hot'); ?>;
    padding: 2px;
  }
  
  .lighter {
    background: <?php echo $zen->getSetting('color_bars'); ?> !important;
  }
  
  .darker {
    background: <?php echo $zen->getSetting('color_bar_darker'); ?> !important;
  }
  
  .darkest {
    background: <?php echo $zen->getSetting('color_bar_darkest'); ?> !important;
  }

  .disabled, .disabled INPUT, .disabled BUTTON, .disabled SUBMIT, 
  .disabled SELECT, .inputDisabled {
     color:      <?php echo $zen->getSetting('color_grey'); ?> !important;
     background: <?php echo $zen->getSetting('color_bars'); ?> !important;
  }
  
  .altBars {
     color:       <?php echo $zen->getSetting("color_alt_text"); ?>;
     background:  <?php echo $zen->getSetting("color_alt_background"); ?>;
     padding: 2px;
  }

  .titleCell {
     color:          <?php echo $zen->getSetting("color_title_txt"); ?>;
     background:     <?php echo $zen->getSetting("color_title_background"); ?>;
     <?php
       if( $page_browser != "ns" ) {
     print "padding-top: 2px;";
     print "padding-bottom: 2px;";
       }
     ?>     
     padding-left:   2px;
     border:         1px solid <?php echo $zen->getSetting("color_alt_text"); ?>;
     font-weight:    Bold;
  }

  .plainCell {
     color:       <?php echo $zen->getSetting("color_text"); ?>;
     background:  <?php echo $zen->getSetting("color_background"); ?>;
  }

  .subTitle {
     color:          <?php echo $zen->getSetting("color_bar_text"); ?>;
     background:     <?php echo $zen->getSetting("color_bar_darkest"); ?>;  
     font-weight:    Bold;
     padding: 2px;
     /* border: 1px solid <?php echo $zen->getSetting('color_bar_text'); ?>; */
     border-left: 1px solid <?php echo $zen->getSetting('color_title_background'); ?>;
     border-top: 1px solid <?php echo $zen->getSetting('color_title_background'); ?>;
     border-right: 1px solid <?php echo $zen->getSetting('color_bar_text'); ?>;
     border-bottom: 1px solid <?php echo $zen->getSetting('color_bar_text'); ?>;
  }
  
  .navCell {
     color:          <?php echo $zen->getSetting("color_bar_text"); ?>;
     background:     <?php echo $zen->getSetting("color_bar_darkest"); ?>;  
     font-weight:    Bold;
     border: 1px solid <?php echo $zen->getSetting('color_bar_border'); ?>;
     padding: 3px;
  }
  
  TABLE.slimPad {
    border-spacing: 0px 3px;
  }
  
  .slimPad TD {
    padding-left: 10px;
    padding-top: 2px;
    padding-bottom: 2px;
    padding-right: 2px;
  }
  
  .headerCell, TD.headerCell {
     font-size: <?php echo $zen->getSetting('font_size_small'); ?>px;
     background: <?php echo $zen->getSetting('color_bar_darker'); ?>;
     border: 1px dotted <?php echo $zen->getSetting('color_bar_border'); ?>;
     text-align: center;
     padding-left: 3px;
     padding-right: 3px;
     padding-top: 0px;
     padding-bottom: 0px;
  }
  
  .menuCell {
     color:      <?php echo $zen->getSetting("color_title_txt"); ?>;
     background: <?php echo $zen->getSetting("color_title_background"); ?>;
  }

  .ticketCell {
     color:          <?php echo $zen->getSetting("color_alt_text"); ?>;
     background:     <?php echo $zen->getSetting("color_alt_background"); ?>;
     <?php
       if( $page_browser != "ns" ) {
     print "padding-top: 2px;";
     print "padding-bottom: 2px;";
       }
     ?>
     padding-left:   15px;
     border:         1px solid <?php echo $zen->getSetting("color_title_background"); ?>;
  }

  .smallTitleCell {
     color:          <?php echo $zen->getSetting("color_title_txt"); ?>;
     background:     <?php echo $zen->getSetting("color_title_background"); ?>;
     <?php
       if( $page_browser != "ns" ) {
     print "padding-top: 2px;";
     print "padding-bottom: 2px;";
       }
     ?>     
     padding-left:   2px;
     font-size:      <?php echo $zen->getSetting("font_size_small"); ?>px;
  }

  .outlined {
     border:         1px solid <?php echo $zen->getSetting("color_title_background"); ?>;
     background:     <?php echo $zen->getSetting("color_background"); ?>;
  }
  
  .tab {
     font-weight:    bold;
     font-size:      <?php echo $zen->getSetting("font_size"); ?>px;
     padding:   4px 10px;
     border-top: 2px outset <?php echo $zen->getSetting('color_bar_darker'); ?>;
     border-left: 2px outset <?php echo $zen->getSetting('color_bar_darker'); ?>;
     border-right: 2px outset <?php echo $zen->getSetting('color_bar_darker'); ?>;
  }
  
  .tab A { border: none; background: none; text-decoration: none; }
  .tab A:hover { border: none; background: none; text-decoration: none; }
  
  .on {
     color:          <?php echo $zen->getSetting("color_text"); ?>;
     background:     <?php echo $zen->getSetting("color_bars"); ?>;
  }

  .off {
     color:          <?php echo $zen->getSetting("color_bar_text"); ?>;
     background:     <?php echo $zen->getSetting("color_bar_darker"); ?>;
  }
  
  .off A { color: <?php echo $zen->getSetting('color_bar_text'); ?> !important; }
  .on A { color: <?php echo $zen->getSetting('color_text'); ?> !important; }
  
  A.navOn, A.navOn:Hover {
    text-decoration: none;
    color: <?php echo $zen->getSetting("color_title_text"); ?>;
    background: none;
  }
  
  A.navOff, A.navOff:Hover {
    text-decoration: none;
    color: <?php echo $zen->getSetting("color_title_text"); ?>;
    background: none;
  }

  A.leftNavLink, A.leftNavLink:Hover {
    text-decoration: none;
    color: <?php echo $zen->getSetting("color_alt_text"); ?>;
    background: none;
  }
  

  .navTab {
     font-weight:    bold;
     font-size: <?php echo $zen->getSetting('font_size'); ?>;
     padding: 5px;
     border-top: 1px outset <?php echo $zen->getSetting('color_bar_border'); ?>;
     border-left: 1px outset <?php echo $zen->getSetting('color_bar_border'); ?>;
     border-right: 1px outset <?php echo $zen->getSetting('color_bar_border'); ?>;
  }
  
  .hotKeyHelp {
    position: absolute;
    left: -300px;
    top: -300px;
    max-height: 400px;
    height: expression(this.scrollHeight > 400? "400px" : "auto");
    overflow: auto;
  }
  
  .hotKeyCell {
    background: <?php echo $zen->getSetting('color_highlight'); ?>;
    color: <?php echo $zen->getSetting('color_hot'); ?>;
    border: 1px solid <?php echo $zen->getSetting('color_title_background'); ?>;
  }
  
  .invisible {
    visibility: hidden;
  }
  
  .permhide {
    position: absolute;
    visibility: hidden;
  }
  
  .nodisplay {
    width: 0px;
    height: 0px;
    border: none;
    position: absolute;
  }
  
  .accesskeys {
   border: 0; width: 0px; height: 0px; position:absolute;
  }
  
  A.navTab { border: none; }

  .navOn {
     color:          <?php echo $zen->getSetting("color_title_text"); ?>;
     background:     <?php echo $zen->getSetting("color_title_background"); ?>;
  }

  .navOff {
     color:          <?php echo $zen->getSetting("color_title_text"); ?>;
     background:     <?php echo $zen->getSetting("color_bar_darkest"); ?>;
  }

  /*** TEXT PROPERTIES ***/
  
.heading {
  font-size:   <?php echo $zen->getSetting('font_size_large'); ?>;
  font-weight: bold;
  color:       <?php echo $zen->getSetting('color_alt_text'); ?>;
  margin: 10px;
}

.alttext {
   color:       <?php echo $zen->getSetting("color_alt_text"); ?>;
}

.bigBold {
   font-size:    <?php echo $zen->getSetting("font_size_large"); ?>px;  
   font-weight:  bold;
}

.big {
   font-size:   <?php echo $zen->getSetting("font_size_large"); ?>px;  
}

TD.bigger { font-size: 50px; }

.error {
   color:       <?php echo $zen->getSetting("color_hot"); ?>;
   font-weight: Bold;
}

.highlight {
   font-weight: bold;
   background:  <?php echo $zen->getSetting("color_highlight"); ?>;
   color:       <?php echo $zen->getSetting("color_bar_text"); ?>;
}

.mark {
   border:  1px solid <?php echo $zen->getSetting("color_highlight"); ?>;
   font-weight: bold;
}

.hot {
   font-weight: bold;
   color:       <?php echo $zen->getSetting("color_hot"); ?>;
   background:  <?php echo $zen->getSetting("color_highlight"); ?>;
}

.small {
   font-size:   <?php echo $zen->getSetting("font_size_small"); ?>px;
}

.tiny {
   font-size:   <?php echo ($zen->getSetting("font_size_small")-1); ?>px;
}

.smallGrey {
   color:       <?php echo $zen->getSetting("color_grey"); ?>;
}

.smallError {
   color:       <?php echo $zen->getSetting("color_hot"); ?>;
   font-weight: bold;
   font-size:   <?php echo $zen->getSetting("font_size_small"); ?>px;
}

.bold {
  font-weight: bold;
}

.smallBold {
   font-weight: bold;
}

.note {
   color:  <?php echo $zen->getSetting("color_grey"); ?>;
   font-size: <?php echo $zen->getSetting("font_size_small"); ?>px;
}

.warning {
   color:  <?php echo $zen->getSetting("color_text"); ?>;
   font-size: <?php echo $zen->getSetting("font_size_small"); ?>px;
}

.smallHighlight {
   color:       <?php echo $zen->getSetting("color_highlight"); ?>;
   font-weight: bold;
}

  
  /*** FORM PROPERTIES ***/


  INPUT, TEXTAREA, SELECT, .input {
     color:      <?php echo $zen->getSetting("color_bar_text"); ?>;
     background: <?php echo $zen->getSetting("color_background"); ?>;
  }

  .smallSubmit {
     color:      <?php echo $zen->getSetting("color_highlight"); ?>;
     background: <?php echo $zen->getSetting("color_alt_text"); ?>;
     font-face:  Courier;
     font-size:  <?php echo $zen->getSetting("font_size_small"); ?>px;
  }

  BUTTON, SUBMIT, .submit, .actionButton, .actionButtonDiv {
     font-face:      Courier;
     color:          <?php echo $zen->getSetting("color_alt_background"); ?>;
     background:     <?php echo $zen->getSetting("color_alt_text"); ?>;
     font-size:      <?php echo $zen->getSetting("font_size_small"); ?>px;
     padding-left:   4px;
     padding-right:  4px;
     padding-top:    2px;
     padding-bottom: 2px;
     text-align:     center;
     /** This width is overridden by renderDivButton() */
     width:          100px; 
  }
  
  .submit, SUBMIT {
    font-weight: bold;
  }
  
  .actionButtonDiv {
    border: outset 2px <?php echo $zen->getSetting("color_alt_text"); ?>;
  }
  
  .actionButtonDiv A, .actionButtonDiv A:hover, .actionButtonDiv A:visited {
    text-decoration: none;
     color:          <?php echo $zen->getSetting("color_alt_background"); ?>;
     background:     <?php echo $zen->getSetting("color_alt_text"); ?>;
     font-size:      <?php echo $zen->getSetting("font_size_small"); ?>px;
  }

  .actionButtonDiv A, .actionButtonDiv A:hover, .actionButtonDiv A:visited {
    text-decoration: none;
     color:          <?php echo $zen->getSetting("color_alt_background"); ?>;
     background:     <?php echo $zen->getSetting("color_alt_text"); ?>;
     font-size:      <?php echo $zen->getSetting("font_size_small"); ?>px;
  }
  
  .abdDown, .abdDown A, .abdDown A:hover, .abdDown A:visited {
    background: <?php echo $zen->getSetting("color_alt_background"); ?> !important;
    color: <?php echo $zen->getSetting("color_alt_text"); ?> !important;
  }
  
  .leftNavCell {
    background: <?php echo $zen->getSetting('color_bar_darker'); ?>;
    font-size:  <?php echo $zen->getSetting('font_size_small'); ?>px;
    border: 1px inset <?php echo $zen->getSetting('color_bar_border'); ?>;
  }
  
  .leftNavMenu {
    background: <?php echo $zen->getSetting('color_bars'); ?>;
    font-weight: bold;
    font-size:  <?php echo $zen->getSetting('font_size'); ?>px;
    font-size:  <?php echo $zen->getSetting('font_size'); ?>px;
    border: 1px outset <?php echo $zen->getSetting('color_bar_border'); ?>;
  }
  
  .leftNavTitle, TD.leftNavTitle {
    color: <?php echo $zen->getSetting('color_title_text'); ?>;
    font-weight: bold;
    font-size:  <?php echo $zen->getSetting('font_size'); ?>px;
    border-left: 5px solid <?php echo $zen->getSetting('color_title_background'); ?>;
    border-top: 1px solid <?php echo $zen->getSetting('color_title_background'); ?>;
    padding-top: 4px;
  }
  
  .inset {
    border: 1px inset <?php echo $zen->getSetting('color_bar_border'); ?>;
  }
  
  .outset {
    border: 1px outset <?php echo $zen->getSetting('color_bar_border'); ?>;
  }
  
  .tbar {
     color:       <?php echo $zen->getSetting("color_text"); ?>;
     background:  <?php echo $zen->getSetting("color_bar_darkest"); ?>;
     font-weight: bold;
  }
  
  .borderBox {
    border: 1px solid <?php echo $zen->getSetting('color_bar_border'); ?>;
    position: relative;
    padding: 5px;
    margin-top: 12px;
    margin-left: 0px;
    margin-right: 10px;
    margin-bottom: 5px;
  }
  
  .borderLabel {
    position: absolute;
    top: -12px;
    left: 25px;
    width: 100%;
  }
  
  .borderLabel span {
    color:      <?php echo $zen->getSetting('color_bar_border'); ?>;
    font-weight: bold;
    font-size:  <?php echo $zen->getSetting('font_size'); ?>;
    background: <?php echo $zen->getSetting('color_bars'); ?>;
    padding: 0px 5px;
  }
  
  .borderContent {
    color:      <?php echo $zen->getSetting('color_text'); ?>;
    font-size:  <?php echo $zen->getSetting('font_size'); ?>;
    background: <?php echo $zen->getSetting('color_background'); ?>;
    border:     1px solid <?php echo $zen->getSetting('color_bar_darkest'); ?>;
    padding: 5px;
    max-height: 200px;
    height: expression(this.scrollHeight > 200? "200px" : "auto");
    overflow: auto;
  }
  
  .propContent, .propLabel {
    color:      <?php echo $zen->getSetting('color_text'); ?>;
    /* font-size:  <?php echo $zen->getSetting('font_size'); ?>; */
    font-size:  <?php echo $zen->getSetting('font_size_small'); ?>;
  }
  
  .propContent {
    background: <?php echo $zen->getSetting('color_background'); ?>;
    border:     1px solid <?php echo $zen->getSetting('color_bar_darkest'); ?>;
    /* padding: 5px; */
    padding: 3px;
  }
  
  .propLabel {
    /* font-weight: bold; */
    background: <?php echo $zen->getSetting('color_bar_darkest'); ?>;
    border:     1px solid <?php echo $zen->getSetting('color_bar_darkest'); ?>;
    padding: 1px 3px;
    white-space: nowrap;
  }
  
  .propSpace {
     width: 8px;
  }
  
  .barborder {
    border-left: 1px solid <?php echo $zen->getSetting('color_bar_border'); ?>;
    border-right: 1px solid <?php echo $zen->getSetting('color_bar_border'); ?>;
  }
  
  .icon {
    border:   2px outset <?php echo $zen->getSetting('color_bar_darkest'); ?>;
    background: <?php echo $zen->getSetting('color_bar_darker'); ?>;
    color: <?php echo $zen->getSetting('color_bar_text'); ?>;
    text-align: center;
    font-size: <?php echo $zen->getSetting('font_size_small'); ?>;
    padding: 2px;
    height: 42px;
    width: 42px;
  }
  
  .iconDown {
    border: 2px inset <?php echo $zen->getSetting('color_bar_darkest'); ?>;
    background: <?php echo $zen->getSetting('color_bar_darkest'); ?>;
  }
  
  .iconOff {
    border: 1px outset <?php echo $zen->getSetting('color_bar_border'); ?>;
    filter:alpha(opacity=30);
    opacity: 0.30;
    -moz-opacity:0.30;
  }
  
  .helpBox {
    text-align: left;
    display: none;
    position: absolute;
    padding: 4px;
    border: 2px solid <?php echo $zen->getSetting('color_title_background'); ?>;
    background: <?php echo $zen->getSetting('color_alt_background'); ?>;
    color: <?php echo $zen->getSetting('color_alt_text'); ?>;
    overflow: auto;
    filter:alpha(opacity=80);
    opacity: 0.80;
    -moz-opacity:0.80;
    font-weight: bold;
  }
  
  .keySubLow, .keySubHigh {
    display:   none;
    position:  absolute;
    padding: 1px;
    border-style: solid;
    font-size: <?php echo $zen->getSetting('font_size_small')-1?>px;
    border: 1px solid <?php echo $zen->getSetting('color_title_background'); ?>;
    background: <?php echo $zen->getSetting('color_highlight'); ?>;
    color: <?php echo $zen->getSetting('color_text'); ?>;
    filter:alpha(opacity=80);
    opacity: 0.80;
    -moz-opacity:0.80;
    text-align: left;
    text-decoration: none;
    font-weight: bold;
    font-style: none;
  }
  
  .keySubLow {
    margin-left: -20px;
    margin-top: 10px;
  }
  
  .keySubHigh {
    margin-left: -20px;
    margin-top: -5px;
  }
  
  .actionFormBox {
    padding-left: 15px;
    padding-top: 15px;
  }
  
  .menuBox {
    border-top: 1px solid <?php echo $zen->getSetting('color_bar_darker');?>;
    border-left: 15px solid <?php echo $zen->getSetting('color_bar_darker');?>;
    padding-left: 5px;
    width: 600px;
    margin-top: 40px;
    margin-left: 30px;
  }
  
  .menuBox P.note, .menuBox P.note:hover {
    font-weight: bold;
    font-size:  <?php echo $zen->getSetting('font_size'); ?>;
    background: none;
  }
  
  .menuBox P.note A, .menuBox P.note A:hover {
    background: none;
    padding: 0px;
  }
  
  .menuBox P {     
    margin-top: 8px;
    margin-bottom: 5px;
    margin-left: 8px;
  }
  
  .menuBox P:hover {
    background: <?php echo $zen->getSetting('color_background');?>;
  }
  
  .menuBox A {
    width: 175px;
    background-image: url(<?php echo $imageUrl?>/16x16/arrow_grey_right.png);
    background-repeat: no-repeat;
    background-position: 0 0px;
    padding-left: 25px;
    font-weight: bold;
    behavior: url('<?php echo $rootUrl?>/menubox.htc');
  }
  
  .menuBox A:hover {
    background-image: url(<?php echo $imageUrl?>/16x16/arrow_green_right.png);
    background-repeat: no-repeat;
    background-position: 0 0px;
    behavior: url('<?php echo $rootUrl?>/menubox.htc');
  }
  
  .menuBox DIV {
    position: absolute;
    margin-left: -30px;
    margin-top:  -25px;
    font-weight: bold;
    font-size:   <?php echo $zen->getSetting('font_size_large'); ?>;
    color:       <?php echo $zen->getSetting('color_bar_border'); ?>;
  }
  
  A.pinIcon:hover {
    background: <?php echo $zen->getSetting('color_highlight'); ?>;
  }
  
  .microTable {
    font-size: <?php echo $zen->getSetting('font_size_small')-1?>px;
  }
  
  .microTable TABLE {
    border-spacing: 1px;
  }
  
  .microTable TD {
    padding: 0px;
    height: 20px;
  }
  
  .microTable INPUT, .microTable BUTTON, , .microTable SELECT, .microTable SUBMIT {
    font-size: <?php echo $zen->getSetting('font_size_small')-1?>px;
  }
  
-->