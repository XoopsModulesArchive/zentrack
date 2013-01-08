<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }


  /*
  **  ZENGRAPH - REPORT GENERATING TOOL
  **
  **  Author: Michael "Kato" Richardson
  **
  **  Purpose, create various charts and graphs
  **  from user provided data
  **
  */
  if( !function_exists("hypot") ) {
    function hypot($x, $y) {
      return sqrt($x*$x + $y*$y);
    }
  }

class zenGraph extends Zen {

  /*
  **  USER METHODS
  */

  function drawGraph() {
    // When finished inputting the layers
    // and system settings, call this function
    // to produce a graphical image
    
    if( $this->debug > 0 ) {
      error_reporting(E_ALL ^ E_NOTICE);
      ini_set("display_errors", false);
    }

    // initialize the image
    if( $this->trueColorEnabled ) {
      $this->img = ImageCreateTrueColor( $this->imageWidth, $this->imageHeight );
      ImageAlphaBlending( $this->img, TRUE );
    } else {
      $this->img = imageCreate( $this->imageWidth, $this->imageHeight );
    }
    if( !$this->img ) {
      $this->addDebug("zenGraph", "imageCreate() failed", 1, TRUE);
    }
    $col = $this->getColor( $this->colorBackground );
    imagefill( $this->img, 1, 1, $col );
    $this->addDebug("zenGraph($settings)",
		    "<ul>\n"
		    ."imageType: ".$this->imageType."<br>\n"
		    ."imageHeight: ".$this->imageHeight."<br>\n"
		    ."imageWidth: ".$this->imageWidth."<br>\n"
		    ."trueColorEnabled: ".$this->trueColorEnabled."<br>\n"
		    ."ttfEnabled: ".$this->ttfEnabled."<br>\n"
		    ."bgcolor: "
		    .((is_array($this->colorBackground))?
		      join(",",$this->colorBackground):$this->colorBackground)."<br>\n"
		    ."</ul>\n"
		    ,2);
    
    // check the image type and insure that
    // it is supported on this server    

    // perform calculations
    $this->calculateParameters();

    // draw framework
    $this->drawFramework();

    // chart data for each layer
    for( $i=0; $i<count($this->layers); $i++ ) {
      $this->nextLayer();
    }

    // draw tic lengths
      $this->drawTicMarks();

    // draw data table?

    // draw legend?
    if( $this->showLegend > 0 ) {
      $this->drawLegend();
    }

    // draw titles and headings
    $this->drawHeadings();
    
    // render
    $this->renderImage();
  }

  function createHtmlTable() {
    // When finished inputting the layers
    // and system settings, call this function
    // to produce an HTML table from the data
    
    // perform calculations (number of rows and columns)
    
    // determine headings for columns
    
    // print title and header rows
    
    // chart data
    
    // output results
    
  }

  /*
  **  USER UTILITIES
  */

  function addColorScheme( $name, $values ) {
    // creates a new color scheme
    // based on the colors provided
    // which can then be referred to
    // in custom settings
    if( !is_array($values) ) {
      $vals = $this->getColorScheme($values);
    }
    $this->colorSchemes["$name"] = $vals;
  }

  function addDataTable() {
    // creates a data table beneath the image
    // rendered
    
    $this->showDataTable = 1;
    // determine constraints (margins, borders, text size, abbreviation)
    
    // determine dataTableWidth and dataTableHeight
    
  }

  function addLegend( $params = '', $data = '' ) {
    // creates a legend on the graph
    // if no parameters are specified
    // it will use the defaults defined by
    // the config file
    // more than one graph may be provided, but only
    // one location on the graph may be defined
    // by using $this->graphLocation
    // see config file for choices
    // any legends which are not to appear in this same
    // spot must use float parameters: Float => array( x, y )
    // where x,y are the starting coordinates of the legend
    // if $data is present, it will be used as
    // the contents of the legend... this consists
    // of arrays containing:
    //      "Label"  =>  'text to show' // the text of the label
    //      "PointShape" => 'type'       // optional (shape of bullet.. see points)
    //      "PointSize" => 'size'       // optional (size of bullet.. see points)
    // If a bullet is not wanted (to make a subheading or just text)
    // then set the PointShape to "0" ('' will not work, must be 0)

    // error checking
    if( !is_array($this->layers) || !is_array($this->layers[0]["data"]) ) {
      $this->addDebug("addLegend", "Layers and Data must exist before adding a legend", 1);
      $this->showLegend = 0;
      return;
    }
    
    // check defaults
    if( !$this->legendBackgroundColor )
      $this->legendBackgroundColor = $this->colorBackground;
    if( !$this->legendForegroundColor )
      $this->legendForegroundColor = $this->colorForeground;
    if( !$this->legendBorderColor )
      $this->legendBorderColor = $this->colorForeground;
    if( !$this->legendFontFace )
      $this->legendFontFace = $this->ttfDefault;

    // set the flag
    $this->showLegend = 1;

    // initialize legend data
    if( !is_array($this->legendData) ) {
      $this->legendData = array();
    }

    if( $params["Location"] ) {
      $this->legendLocation = $params["Location"];
      unset($params["Location"]);
    }

    // get a list of properties...
    // if they aren't set in $params
    // then add them from the defaults
    $settings = array( "Title",
		       "Float",
		       "Columns",
		       "Rows",
		       "Transparency",
		       "FontSize",
		       "FontFace",
		       "FontAngle",
		       "PointShape",
		       "PointSize",
		       "Width",
		       "BackgroundColor",
		       "ForegroundColor",
		       "BorderThickness",
		       "BorderColor" );
    foreach($settings as $s) {
      if( !$params["$s"] ) {
	$n = "legend$s";
	$params["$s"] = $this->$n;
      }
    }

    if( !$params["Float"] ) {
      // set up a quick true/false checks for each orientation
      $arr = array("top","bottom","middle","left","right","center","horizontal");
      foreach($arr as $a) {
	$n = "tf_$a";
	$$n = strlen(strpos($this->legendLocation,$a));
      }
    }
    
    // calculate the data params
    $lbl_count = 0;
    $sub_count = 0;
    $lbl_max_width = 0;
    $sub_max_width = 0;
    $sub_max_len = 0;
    $lbl_max_len = 0;
    $prev_num = 0;
    $ps = 0;
    if( !is_array($data) ) {
      $data = array();
      $ps = $params["PointSize"];
      // create data and get ready for calculations
      for($i=0; $i<count($this->layers);$i++) {
	// name the layer
	if( count($this->layers) > 1 ) {
	  $ln = ($this->layers[$i]["settings"]["name"] != "")?
	    $this->layers[$i]["settings"]["name"] : "Level $i";
	  $data[] = array("Label"=>$ln,"PointShape"=>0,"PointSize"=>0);
	}
	// here we set properties for calculations
	$sub_count++;
	$tmplen = $this->strLength($ln,$params["FontSize"],$params["FontFace"]);
	if( $tmplen > $sub_max_len ) {
	  $sub_max_width = $ln;
	  $sub_max_len = $tmplen;
	}
	for($j=0;$j<count($this->layers[$i]["config"]);$j++) {
	  $l = $this->layers[$i]["config"]["$j"];
	  if( $l["name"] == "dummy-row" || $l["type"] == "dummy-row" )
	    continue;
	  // here we calculate this label's params
	  $vals = array();
	  // here we get the colors for this set
	  $vals["Color"] = is_array($l["color"])? 
	    $l["color"] : $this->getColorScheme($l["color"],1);
	  // here we set the label of the entry
	  if( strlen($l["name"]) ) {
	    $vals["Label"] = $l["name"];
	  } else if( strlen($l["type"]) ) {
	    $vals["Label"] = $l["type"];
	  } else {
	    $vals["Label"] = $this->graphType;
	  }
	  $data[] = $vals;
	  // set params for calculations
	  $lbl_count++;
	  $tmplen = $this->strLength($vals["Label"],$params["FontSize"],$params["FontFace"]);
	  if( $tmplen > $lbl_max_len ) {
	    $lbl_max_len = $tmplen;
	    $lbl_max_width = $vals["Label"];
	  }
	}
      }
    } else if( !$params["Width"] || !$params["Height"] || $tf_horizontal ){
      // find out what we have for length/height measurements
      // with our manually entered data set
      // so that we can do the calculations
      for($i=0; $i<count($data); $i++) {
	if( !strlen($data[$i]["PointShape"]) ) {
	  $data[$i]["PointShape"] = $params["PointShape"];
	}
	if( !strlen($data[$i]["PointSize"]) ) {
	  $data[$i]["PointSize"] = $params["PointSize"];
	}
	if( !$data[$i]["FontFace"] ) {
	  $data[$i]["FontFace"] = $params["FontFace"];
	}
	if( $data[$i]["PointShape"] == 0 || $data[$i]["PointSize"] == 0 ) {
	  // add a non-bulleted label
	  $sub_count++;
	  $tmplen = $this->strLength($data[$i]["Label"],$data[$i]["FontSize"],$data[$i]["FontFace"]);
	  if( $tmplen > $sub_max_len ) {
	    $sub_max_width = $ln;
	    $sub_max_len = $tmplen;
	  }
	} else {
	  // check out biggest point size param
	  if( $data[$i]["PointSize"] && $data[$i]["PointSize"] > $ps ) {
	    $ps = $data[$i]["PointSize"];
	  }
	  // add a bulleted label
	  $lbl_count++;
	  $tmplen = $this->strLength($data[$i]["Label"],$data[$i]["FontSize"],$data[$i]["FontFace"]);
	  if( $tmplen > $lbl_max_len ) {
	    $lbl_max_width = $ln;
	    $lbl_max_len = $tmplen;
	  }
	}
      }
    }
    // make sure we have height and width
    // dynamically generate if required
    if( !$params["Width"] || !$params["Height"] || ($tf_horizontal && !$tf_middle) ) {
      // get a height for each row based on height of text
      list($xspan,$yspan,$l,$h,$xo,$yo) = $this->TextParams($lbl_max_width,
							    $params["FontSize"],
							    $params["FontAngle"],
							    $params["FontFace"]);
      $cyo = ($yo >= $ps)? $yo : $ps;
      list($sub_xs,$sub_ys,$sub_l,$sub_h,$sub_xo,$sub_yo) = 
	$this->TextParams($sub_max_width,
			  $params["FontSize"],
			  $params["FontAngle"],
			  $params["FontFace"]);
      list($ttl_xs,$ttl_ys,$ttl_l,
	   $ttl_h,$ttl_xo,$ttl_yo) = $this->TextParams($params["Title"],
						       $params["FontSize"],
						       $params["FontAngle"],
						       $params["FontFace"]);
      $row_height = ($cyo > $sub_yo)? $cyo+$this->space : $sub_yo+$this->space;
      $col_width = ($sub_xs+$this->margin > ($this->space*3+$xspan+$ps))?
	$sub_xs + $this->margin :
	$this->space * 3 + $xspan + $ps;
      $max_width = $this->imageWidth - $this->margin*2 - $params["BorderThickness"]*2;
    }
    // set the height
    if( !$params["Height"] ) {
      // multiply data rows by their width, subhead rows by their width, and
      // add one spacer to start off the first element
      // the height equals:
      //    yspan of one label - label_offset
      //    + number of labels * label_offset+space
      //    + number of subheads * sub_offset+space
      //    + title height (and spacing if title exists)
      //    + borderThickness * 2
      $params["Height"] = $yspan - $yo;
      $params["Height"] += ($cyo+$this->space)*$lbl_count 
	+ ($this->space+$sub_yo)*$sub_count + $this->space;
      // add space for the title
      if( $params["Title"] != "" ) {
	$params["Height"] += $ttl_ys + $this->margin + $params["BorderThickness"];
      }    
      // add space for borders
      $params["Height"] += $params["BorderThickness"]*2;
    }
    if( $tf_horizontal && !$tf_middle ) {
      // set height and width if using tf_horizontal
      $params["Columns"] = ($col_width>0)? floor( $max_width/$col_width ) : 1;
      $params["Rows"] = ($params["Columns"]>0)?
	ceil(count($data)/$params["Columns"]) : 1;
      $params["Width"] = ($params["Rows"] > 1)? 
	$max_width+$params["BorderThickness"]*2 : 
	$col_width * count($data) + $params["BorderThickness"]*2;
      $params["Height"] = $params["Rows"] * $row_height;
    } else if( !$params["Width"] ) {
      // set the width, if not set
      $params["Width"] = $col_width * $params["Columns"];
      // make sure we don't exceed the max width
      while($params["Width"] > $max_width && $params["Columns"]>1 ) {
	$params["Columns"]--;
	$params["Width"] = $col_width*$params["Columns"];
      }
      // expand for title as needed
      if( $params["Title"] != "" && $ttl_xs+$this->margin > $params["Width"] ) {
	$params["Width"] = $ttl_xs + $this->margin;
      }
      // figure the number of rows
      $params["Rows"] = ($params["Columns"]>0)? 
	ceil(count($data)/$params["Columns"]) : 1;
      // add on the thickness of the borders
      $params["Width"] += $params["BorderThickness"]*2;
    }
    else if( !$params["Columns"] ) {
      // if we have a width, and no number of columns, then
      // see how many columns will fit and make it so
      $params["Columns"] = ($col_width>0)? 
	floor($params["Width"]/$col_width) : 1;
      $params["Rows"] = ($params["Columns"]>0)? 
	ceil(count($data)/$params["Columns"]) : 1;
    } 
    // safety net
    if( $params["Columns"] < 1 )
      $params["Columns"] = 1;
    if( $params["Rows"] < 1 )
      $params["Rows"] = 1;

    if( !$params["Float"] ) {
      // set some calc params
      $xo = 0;
      $yo = 0;
      // determine legendStartX & legendStartY
      // considerations/calculations:
      //   legendLocation - effects how we stack these
      //   legendTW - effects start X, changes
      //   legendTH - effects start Y, changes
      // determin marginOffsets - how we adjust everything else
      if( $tf_top && $tf_left ) {
	// stacked on top of eachother down left
	$this->legendStartX = $this->margin;
	$this->legendStartY = $this->margin;
	if( $this->legendTH > 0 )
	  $this->legendTH += $this->space;
	$this->legendTH += $params["Height"];
	if( $params["Width"] > $this->legendTW ) $this->legendTW = $params["Width"];
	if( $tf_horizontal ) {
	  // push everything down
	  $this->marginOffsets["top"] = $this->legendTH + $this->space;
	}
	else {
	  // push everything right
	  $this->marginOffsets["left"] = $this->legendTW + $this->space;
	}
      } else if( $tf_top && $tf_center ) {
	// stack them across the top (centered)
	$this->legendStartY = $this->margin;
	if( $tf_horizontal ) {
	  // we take the biggest width
	  // and sum the heights
	  if( $this->legendTH > 0 )
	    $this->legendTH += $this->space;
	  $this->legendTH += $params["Height"];
	  if( $params["Width"] > $this->legendTW ) 
	    $this->legendTW = $params["Width"];
	} else {
	  // we take the biggest height
	  // and sum the widths	 
	  if( $this->legendTW > 0 )
	    $this->legendTW += $this->space;
	  $this->legendTW += $params["Width"];
	  if( $params["Height"] > $this->legendTH )
	    $this->legendTH = $params["Height"];
	}
	$this->legendStartX = $this->imageWidth/2 - $this->legendTW/2;
	$this->marginOffsets["top"] = $this->legendTH + $this->space;
      } else if( $tf_middle && $tf_left ) {
	// stack them down the left (centered)
	$this->legendStartX = $this->margin;
	// add padding	
	if( $this->legendTH > 0 )
	  $this->legendTH += $this->space;
	// total height
	$this->legendTH += $params["Height"];
	// check total width
	if( $params["Width"] > $this->legendTW )
	  $this->legendTW = $params["Width"];
	// create offsets
	$this->marginOffsets["left"] = $this->legendTW + $this->space;
	$this->legendStartY = $this->imageHeight/2 - $this->legendTH/2;
	// find start point by sub. height from total height
      } else if( $tf_middle && $tf_right ) {
	// stack them down the right (centered)
	// add padding	
	if( $this->legendTH > 0 )
	  $this->legendTH += $this->space;
	// total height
	$this->legendTH += $params["Height"];
	// check total width
	if( $params["Width"] > $this->legendTW )
	  $this->legendTW = $params["Width"];
	// get x coords by subtracting width from right margin
	$this->legendStartX = $this->imageWidth - $this->margin - $this->legendTW;
	// create offsets
	$this->marginOffsets["right"] = $this->legendTW + $this->space;
	$this->legendStartY = $this->imageHeight/2 - $this->legendTH/2;
      } else if( $tf_bottom && $tf_left ) {
	// stack them across the bottom (left)
	$this->legendStartX = $this->margin;
	if( $tf_horizontal ) {
	  if( $params["Width"] > $this->legendTW )
	    $this->legendTW = $params["Width"];
	  if( $this->legendTH > 0 )
	    $this->legendTH += $this->space;
	  $this->legendTH += $params["Height"];
	} else {
	  // check height
	  if( $params["Height"] > $this->legendTH )
	    $this->legendTH = $params["Height"];
	  // padding
	  if( $this->legendTW > 0 )
	    $this->legendTW += $this->space;
	  $this->legendTW += $params["Width"];	
	}
	$this->marginOffsets["bottom"] = $this->legendTH + $this->space;
	// start y is legend height + margin from bottom
	$this->legendStartY = $this->imageHeight - $this->margin - $this->legendTH;
      } else if( $tf_bottom && $tf_center ) {
	// stack them across the bottom (centered)
	if( $tf_horizontal ) {
	  // stack on top of eachother
	  $this->legendTH += $params["Height"];
	  if( $params["Width"] > $this->legendTW )
	    $this->legendTW = $params["Width"];
	} else {
	  // stack next to eachother
	  $this->legendTW += $params["Width"];
	  if( $params["Height"] > $this->legendTH )
	    $this->legendTH = $params["Height"];
	}
	$this->legendStartX = $this->imageWidth/2 - $this->legendTW/2;
	$this->legendStartY = $this->imageHeight - $this->margin - $this->legendTH;
	$this->marginOffsets["bottom"] = $this->legendTH + $this->space;
      } else if( $tf_bottom && $tf_right ) {
	// stack them across the bottom (right)
	if( $tf_horizontal ) {
	  if( $params["Width"] > $this->legendTW )
	    $this->legendTW = $params["Width"];
	  if( $this->legendTH > 0 )
	    $this->legendTH += $this->space;
	  $this->legendTH += $params["Height"];
	} else {
	  // check height
	  if( $params["Height"] > $this->legendTH )
	    $this->legendTH = $params["Height"];
	  // padding
	  if( $this->legendTW > 0 )
	    $this->legendTW += $this->space;
	  $this->legendTW += $params["Width"];	
	}
	$this->legendStartX = $this->imageWidth - $this->margin - $this->legendTW;
	$this->legendStartY = $this->imageHeight - $this->margin - $this->legendTH;
	$this->marginOffsets["bottom"] = $this->legendTH + $this->space;
      } else {  // default to top right
	// stack them down the right (top)
	if( $tf_top != 1 || $tf_right != 1 ) {
	  $this->legendLocation = "top-right";
	  // tell them they jacked it up
	  $this->addDebug("add_legend", 
			  "Incorrect Param specified {$this->legendLocation} .. "
			  ."see the config file for instructions or consult "
			  ."documentation.", 1);
	}
	$this->legendStartY = $this->margin;
	if( $tf_horizontal ) {
	  if( $this->legendTH > 0 )
	    $this->legendTH += $this->space;
	  if( $params["Width"] > $this->legendTW )
	    $this->legendTW = $params["Width"];
	  $this->legendTH += $params["Height"];
	  $this->marginOffsets["top"] = $this->legendTH + $this->space;
	} else {
	  if( $this->legendTW > 0 )
	    $this->legendTW += $this->space;
	  if( $params["Height"] > $this->legendTH )
	    $this->legendTH = $params["Height"];
	  $this->legendTW += $params["Width"];
	  $this->marginOffsets["right"] = $this->legendTW + $this->space;
	}
	$this->legendStartX = $this->imageWidth - $this->margin - $this->legendTW;
      }
      // check constraints
      if( $this->legendTW > $this->imageWidth ) {
	$this->addDebug("addLegend","legend width > image width! "
			."Try using 2, or custom legend data",1);
      }
      if( $this->legendTH > $this->imageHeight ) {
	$this->addDebug("addLegend","legend height > image height! "
			."Try using 2, or custom legend data",1);
      }	
    } else {
      // check bounds
      if( $params["Width"] > $this->imageWidth ) {
	$this->addDebug("addLegend","legend width > image width! "
			."Try using 2, or custom legend data",1);
      }
      if( $params["Height"] > $this->imageHeight ) {
	$this->addDebug("addLegend","legend height > image height! "
			."Try using 2, or custom legend data",1);
      }
    }
    // save our hard work
    $this->legendData[] = array("params"=>$params,"data"=>$data);    
    // debug info
    $this->addDebug("addLegend", 
		    "legend number ".count($this->legendData)."created", 2);    
  }

  function addLayer($settings = '' ) {
    // adds a new layer of charted data onto the graph
    // creating a truly 3d graph layout. 
    if( !is_array($settings) )
	$settings = array();   
    $n = (is_array($this->layers))? count($this->layers) : 0;
    $this->layers["$n"] = array("settings"=>$settings);
  }

  function addData( $data, $name = '', $type = 'line', 
		    $color = '', $others = '' ) {
    // adds a new data set to the most current layer
    // where name is the name of the data set, type is the
    // type of chart to create from the data, and color is
    // a valid hex or decimal color, a color scheme, an effect, or an
    // array of colors
    // $others is a special option for adding special params
    // (as in the case of the pie chart, which has extra vars)
    if( !is_array($this->layers) || !count($this->layers) ) {
      $this->addDebug("addData","You must create a layer before you can add data sets!",1);    
    } else {
      // find out where we are putting this data
      $n = (is_array($this->layers) && count($this->layers))? 
	   count($this->layers)-1 : 0;
      $x = (is_array($this->layers["$n"]["data"]))? 
	count($this->layers["$n"]["data"]) : 0;
      // create the data set
      $this->layers["$n"]["data"]["$x"] = $data;
      $this->layers["$n"]["config"]["$x"] = array("name"  => $name,
						  "type"  => $type,
						  "color" => $color
						  );
      // set up any extra params that exist
      // for this data set
      if( is_array($others) ) {
	foreach($others as $k=>$v) {
	  $this->layers["$n"]["config"]["$x"]["$k"] = $v;
	}
      }
      // create some dummy rows to use for calculations, such
      // as determining the max value for y axis, etc

      if( $type == "stack" ) {
	$vars = $this->layers["$n"]["data"];
	$confs = $this->layers["$n"]["config"];
	for($i=count($vars)-1; $i>=0; $i--) {
	  $t = $confs["$i"]["type"];
	  if( "$t" == "dummy-row" ) {
	    $this->layers["$n"]["data"]["$i"] = 
	      $this->totalRows( array($vars["$i"],$data) );
	  } else if( "$t" == "column" || "$t" == "stack" ) {
	    $this->addData( $this->totalRows( array($vars[$i],$data) ),
			    "dummy-row","dummy-row" );
	  }
	}
      }

    }
  }
  var $lastColumnAdded;

  /*
  **  SYSTEM METHODS
  */

  function drawFramework() {
    // creates the x and y axis lines, 3d depth of graph body,
    // tic marks, etc
    // fff

    // check to see if this gets displayed
    if( !$this->showFrame )
      return;

    // set the boundaries
    $xb  = $this->xBase;
    $xbo = $this->xBaseOffset;
    $xe  = $this->xEnd;
    $xeo = $this->xEndOffset;
    $xs  = $this->xStep;
    $yb  = $this->yBase;
    $ybo = $this->yBaseOffset;
    $ye  = $this->yEnd;
    $yeo = $this->yEndOffset;
    $ys  = $this->yStep;

    // fill in the background
    if( $this->colorGraphBackground != $this->colorBackground )
      $this->drawRectangle($xbo, $yeo, $xeo, $ybo, 
	                   $this->getColor($this->colorGraphBackground) );
    
    // draw the 3d portions
    if( $this->graphDepth ) {
      // shading
      $dk_bg = $this->getColor( $this->colorGraphBackground, 'light');
      $lt_bg = $this->getColor( $this->colorGraphBackground, 'dark' );
      // y axis 3d region
      $yPoints = array( $xb,  $ye,
			$xbo, $yeo,
			$xbo, $ybo,
			$xb,  $yb );
      // x axis 3d region
      $xPoints = array( $xb,  $yb,
			$xbo, $ybo,
			$xeo, $ybo,
			$xe,  $yb );

      imageFilledPolygon( $this->img,
			  $yPoints,
			  count($yPoints)/2,
			  $lt_bg );
      imageFilledPolygon( $this->img,
			  $xPoints,
			  count($xPoints)/2,
			  $dk_bg );
    }    

    // fill in the guidlines
    $this->drawGuidelines();

    // draw the zero axis
    $cf = $this->getColor( $this->colorGraphForeground );
    if( $this->xZero != $xb ) {
      $style = array( $cf, $cf, IMG_COLOR_TRANSPARENT, IMG_COLOR_TRANSPARENT );
      ImageSetStyle($this->img, $style);
      imageLine( $this->img, 
		 $this->xZeroOffset, 
		 $ybo, 
		 $this->xZeroOffset, 
		 $this->yZeroOffset,
		 IMG_COLOR_STYLED );
      if( $this->graphDepth ) {
	imageLine( $this->img,
		   $this->xZero,
		   $yb,
		   $this->xZeroOffset,
		   $ybo,
		   IMG_COLOR_STYLED );
      }
    }
    if( $this->yZero != $yb ) {
      $style = array( $cf, $cf, IMG_COLOR_TRANSPARENT, IMG_COLOR_TRANSPARENT );
      ImageSetStyle($this->img, $style);
      imageLine( $this->img, 
		 $xbo, 
		 $this->yZeroOffset, 
		 $xeo, 
		 $this->yZeroOffset,
		 IMG_COLOR_STYLED );
      if( $this->graphDepth ) {
	imageLine( $this->img,
		   $xb,
		   $this->yZero,
		   $xbo,
		   $this->yZeroOffset,
		   IMG_COLOR_STYLED );	
      }
    }

    // draw the frames
    if( $this->showFrame ) {
      $color = $this->getColor( $this->colorGraphForeground );
      if( $this->frameThickness > 1 ) {
	// the y axis
	$x1 = $this->xBase - 1 - $this->frameThickness;
	$x2 = $this->xBase - 1;
	$y1 = $this->yEnd;
	$y2 = $this->yBase + $this->frameThickness;
	$this->drawRectangle( $x1, $y1, $x2, $y2, $color );
			      
	// the x axis
	$x1 = $this->xBase - $this->frameThickness;
	$x2 = $this->xEnd;
	$y1 = $this->yBase + 1;
	$y2 = $this->yBase + 1 + $this->frameThickness;
	$this->drawRectangle( $x1, $y1, $x2, $y2, $color );
      } else {
	// the y axis
	imageLine( $this->img,
		   $this->xBase - 1,
		   $this->yEnd,
		   $this->xBase - 1,
		   $this->yBase + 1,
		   $color );
	// the x axis
	imageLine( $this->img,
		   $this->xBase - 1,
		   $this->yBase + 1,
		   $this->xEnd,
		   $this->yBase + 1,
		   $color );
      }
    }

    // close frame
    //
    //
    //
    //
    //
    //
    // option to draw right and top of frame 
  }

  function drawDataTable() {
    // draws a data table on the graph

  }

  function drawLegend() {
    // creates a legend on the graph

    if( $this->showLegend < 1 ) {
      $this->addDebug("drawLegend","showLegend flag is false, couldn't draw legend",2);
    }
    // set graph point size for reference
    $ops = $this->pointSize;

    $settings = array( "Title",
		       "Float",
		       "Transparency",
		       "FontSize",
		       "FontFace",
		       "FontAngle",
		       "PointShape",
		       "PointSize",
		       "Width",
		       "BorderColor",
		       "BackgroundColor",
		       "ForegroundColor",
		       "BorderThickness",
		       "BorderColor" );
    // set up quick true/false checks for each orientation
    $arr = array("top","bottom","middle","left","right","center","horizontal");
    foreach($arr as $a) {
      $n = "tf_$a";
      $$n = strlen(strpos($this->legendLocation,$a));
    }

    $xs = $this->legendStartX;
    $ys = $this->legendStartY;
    for($i=0; $i<count($this->legendData); $i++) {
      $params = $this->legendData[$i]["params"];
      $data = $this->legendData[$i]["data"];
      if( !count($data) ) {
	$this->addDebug("drawLegend","Data set for legend $i empty!! Skipped!",1);
	continue;
      } else {
	$this->addDebug("drawLegend",$params["Title"]."<ul>Rows: ".$params["Rows"]
			.",<br> Columns: ".$params["Columns"]
			.",<br> Height: ".$params["Height"]
			.",<br> Width: ".$params["Width"]
			.(($params["Float"])? 
			  ",<br> Float(".$params["Float"][0].",".$params["Float"][1]:
			  ",<br> Location: ".$params["Location"])."($xs,$ys)"
			."</ul>", 2);
      }
      if( !$params["Float"] ) {
	if( $tf_center && $tf_horizontal ) { 
	  $x1 = $this->imageWidth/2 - $params["Width"]/2;
	}
	else { $x1 = $xs; }
	$y1 = $ys;
	$x2 = $x1 + $params["Width"];
	$y2 = $y1 + $params["Height"];
      } else {
	$x1 = $params["Float"][0];
	$y1 = $params["Float"][1];
	$x2 = $x1 + $params["Width"];
	$y2 = $y1 + $params["Height"];
      }
      $x1_plain = $x1;
      $y1_plain = $y1;
      // adjust for borders
      $y1 += $params["BorderThickness"] + $this->space;
      $x1 += $params["BorderThickness"] + $this->space;
      // draw the background color
      if( $params["BackgroundColor"] ) {
	$this->drawRectangle($x1_plain,$y1_plain,
			     $x1_plain+$params["Width"],
			     $y1_plain+$params["Height"],
			     $this->getColor($params["BackgroundColor"]));
      }

      // print the title if it exists
      if( $params["Title"] != "" ) {
	list($xspan,$yspan,$len,
	     $ht,$xoff,$yoff) = $this->TextParams($params["Title"],
						  $params["FontSize"],
						  $params["FontAngle"],
						  $params["FontFace"]);
	$ttl_height = $yspan + $this->space;
	$xtc = $this->centerStringX( 
				    $x1_plain+$params["Width"]/2,
				    $params["FontSize"], 
				    $params["Title"], 
				    $params["FontAngle"], 
				    $params["FontFace"] );
	$this->drawRectangle($x1_plain,$y1_plain,
			     $x1_plain+$params["Width"],
			     $y1+$ttl_height,
			     $this->getColor($params["BackgroundColor"],"darken"));
	$this->printString($params["Title"],$xtc,$y1,
			   $params["FontSize"], 
			   $this->getColor($params["ForegroundColor"],"lighten"), 
			   $params["FontAngle"],
			   $params["FontFace"]);		    
	$y1 += $ttl_height + $this->space + $params["BorderThickness"];
      }
      // height/width params
      $col_width = ($x2-$x1)/$params["Columns"];      
      $row_height = ($y2-$y1)/$params["Rows"];

      $row = 0;
      $col = 0;
      for($j=0;$j<count($data);$j++) {
	$d = $data[$j];
	if( $col >= $params["Columns"] ) {
	  $col = 0;
	  $row++;
	}
	if( $row >= $params["Rows"] )
	  $this->addDebug("drawLegend","Max rows exceeded... this is probably a problem with the Height setting",1);
	$yc = $y1 + $row * $row_height;
	$xc = $x1 + $col * $col_width;
	if( !strlen($d["PointShape"]) ) {
	  $d["PointShape"] = $params["PointShape"];
	  if( !$d["PointSize"] )
	    $d["PointSize"] = $params["PointSize"];
	}
	// determine the color scheme for the data set
	// and plot the appropriate bullet
	if( $d["PointShape"] && $d["PointSize"] ) {
	  $this->pointSize = $d["PointSize"];
	  $xoff = $d["PointSize"]/2;
	  $yoff = $d["PointSize"]/2;
	  if( !is_array($d["Color"])
	      && preg_match("@^[a-zA-Z0-9_-]+$@", $d["Color"]) ) {
	    $d["Color"] = $this->getColorScheme($d["Color"],1);
	  }
	  if( is_array($d["Color"]) && count($d["Color"]) > 1 
	      && (is_array($d["Color"][0]) || !preg_match("@^[0-9]{1,3}$@",$d["Color"]))
	      && $d["PointShape"] == "square" ) {
	    $this->drawGradientSquare($xc+$xoff, $yc+$yoff, $d["Color"], $params["BorderColor"]);
	  } else {
	    $color = (is_array($d["Color"]) && !is_array($d["Color"][0]) 
		      && preg_match("@^[0-9]{1,3}$@",$d["Color"]) )? 
	      $this->getColor($d["Color"]) :
	      $this->getColor($d["Color"][0]);
	    $bcolor = $this->getColor($params["BorderColor"]);
	    $this->drawPoint($xc+$xoff,$yc+$yoff,$color,$d["PointShape"],$bcolor);
	  }
	  $xc += $this->space + $d["PointSize"];
        }
	// plot label
	// make sure to adjust to bottom of text from current point
	list($xspan,$yspan,$len,
	     $ht,$xoff,$yoff) = $this->TextParams($d["Label"],
						  $params["FontSize"],
						  $params["FontAngle"],
						  $params["FontFace"]);
	$this->printString($d["Label"],$xc, $yc, 
			   $params["FontSize"],
			   $this->getColor($params["ForegroundColor"]),
			   $params["FontAngle"], $params["FontFace"] );
	$this->addDebug("drawLegend","Adding element: col: $col, row: $row, "
			."Label: {$d['Label']}, "
			."PointShape: {$params['PointShape']}, x/y: $xc/$yc, "
			."Color: ".((is_array($d["Color"]))?
				    join(",",$d["Color"]):$d["Color"]),3);
	$col++;
      }
      // plotborder
      if( $params["BorderThickness"] > 0 ) {
	$this->plotBorders($x1_plain,$y1_plain,
			   $x1_plain+$params["Width"],
			   $y1_plain+$params["Height"],
			  $params["BorderThickness"],
			  $params["BorderColor"]);
	// here we draw line between title and entries, if there is a title
	if( $params["Title"] != "" ) {
	  $ytc = $y1_plain+$params["BorderThickness"]+$ttl_height+$this->space;
	  $this->drawBorder($x1_plain,
			    $ytc,
			    $x1_plain+$params["Width"],
			    $ytc,
			    $params["BorderThickness"],
			    $params["BorderColor"], 
			    "inner");
	}
      }
      if( !$params["Float"] ) {
	if( $tf_horizontal ) { $ys += $params["Height"]+$this->space; }
	else if( $tf_top && $tf_left ) { $ys += $params["Height"] + $this->space; } 
	else if( $tf_top && $tf_center ) {$xs += $params["Width"]+$this->space;}
	else if( $tf_middle ) {$ys += $params["Height"]+$this->space;}
	else if( $tf_bottom ) {$xs += $params["Width"]+$this->space;}
	else { $ys += $params["Height"]; }
      }
    }
    $this->pointSize = $ops;
  }

  function renderImage() {
    // finalizes and then
    // prints the image to stdout
    // or to a file if outputDirectory
    // is specified

    if( $type == "jpg" ) {
      $type = "jpeg";
    }
    if( $this->debug ) {
      $this->addDebug("renderImage()", "Image render skipped for debug",3);
      $this->printDebugMessages();
    } else if( $this->outputDirectory ) {
      //
      //
      // output to file
      // (how to set up $name?)
      //
      //
      $type = "image".$this->imageType;
      $type( $this->img, $this->outputDirectory."/$name" );      
    } else {
      header("Content-type:image/".$this->imageType);
      if( $type == "jpeg" ) {
	imagejpeg( $this->img, null, $this->jpegQuality );	
      } else {
	$type = "image".$this->imageType;
	$type( $this->img );
      }
    }
  }

  function renderHTML() {
    // creates an html graph and 
    // prints it to stdout, or to
    // an html file if outputDirectory
    // is specified

  }

  /*
  **  SYSTEM UTILITIES
  */
  
  function configureSettings( $settings ) {
    if( is_array($settings) ) {
      foreach($settings as $k=>$v) {
        // if( in_array($k,$this->user_settings) )
	// do
	// do
	// do: enable this later
         $this->$k = $v;
	 // else
         // $this->addDebug("configureSettings","$k is not a valid configuration setting",2);
      }
    } else if( file_exists($settings) ) {
      include("$settings");
    }
  }

  function drawXLabels() {
    // draws the labels on the x
    // graph axis

    if( is_array($this->xLabels) ) {
      $this->addDebug("drawXLabels","running",3);
      $ystart = $this->yBase + $this->space;
      $ystart += ($this->showFrame)? $this->frameThickness : 1;
      list($xdir,$ydir) = $this->dir_of($this->xLabelsAngle);
      for( $i = 0; $i <= $this->xDiv; $i++ ) {
	$txt = $this->xLabels[$i];
	if( !strlen($txt) )
	  next;
	$step = $this->xBase + $i*$this->xStep;
	// center labels as desired
	if( $this->xLabelsCentered == 0 ) {
	  $step -= $this->xStep / 2;
	} else if( $this->xLabelsCentered == 2 ) {
	  $step -= $this->xStep;
	}
	list($xspan,$yspan,$length,$height,) = 
	  $this->textParams( $txt, 
			     $this->labelSize, 
			     $this->xLabelsAngle, 
			     $this->labelFont );
	$x = $this->centerStringX($step,$this->labelSize,$txt,
				  $this->xLabelsAngle,$this->labelFont);
	$y = $ystart;
	$this->printString( $txt, 
			    $x, 
			    $y,
			    $this->labelSize,
			    $this->getColor($this->labelColor), 
			    $this->xLabelsAngle, 
			    $this->labelFont );
      }
    } else {
      $this->addDebug("drawXLabels","No labels found, skipping",2);
    }
  }

  function drawYLabels() {
    // draws the labels on the y
    // graph axis

    if( is_array($this->yLabels) ) {
      $this->addDebug("drawYLabels","running",3);
      $xstart = $this->xBase - $this->space;
      $xstart -= ($this->showFrame)? $this->frameThickness : 1;
      for( $i = 0; $i <= $this->yDiv; $i++ ) {
	$txt = $this->yLabels[$i];
	if( !strlen($txt) ) {
	  continue;
	} else {
	  list($xdir,$ydir) = $this->dir_of($this->yLabelsAngle);
	  if( preg_match("@[^0-9.]@", $txt) ) {
	    $step = $this->yBase - $i*$this->yStep;
	  } else {
	    $step = $this->yZero - $txt * $this->yScale;
	    if( !$this->checkRange($step, 'y!') ) {
	      $this->addDebug("drawYLabels", "value out of range: $txt, stopping", 2);
	      continue;
	    }
	  }
	  list($xspan,) = 
	    $this->textParams( $txt, 
			       $this->labelSize, 
			       $this->yLabelsAngle, 
			       $this->labelFont );
	  $x = $xstart - $xspan;
	  // compensate for text height
	  // if it goes above the staring point
	  // $height/2 centers it on the tic mark
	  $y = $this->centerStringY($step,$this->labelSize,$txt,
				    0,$this->labelFont);
	  $this->printString( $txt, 
			      $x, 
			      $y,
			      $this->labelSize,
			      $this->getColor($this->labelColor), 
			      $this->yLabelsAngle, 
			      $this->labelFont );
	}
      }
    } else {
      $this->addDebug("drawYLabels","No labels found, skipping",2);
    }
  }

  function drawY2Labels() {
    // draws the labels on the y
    // graph axis... right side

    if( is_array($this->y2Labels) ) {
      $this->addDebug("drawY2Labels","running",3);
      $xstart = $this->xEndOffset + $this->space;
      // do.. close frame adjustments
      //
      //
      //
      //
      for( $i = 0; $i <= $this->y2Div; $i++ ) {
	$txt = $this->y2Labels[$i];
	if( !strlen($txt) )
	  next;
	list($xdir,$ydir) = $this->dir_of($this->y2LabelsAngle);
	$step = $this->yBaseOffset - $i*$this->y2Step;
	list($xspan,$yspan,$length,$height,) = 
	  $this->textParams( $txt, 
			     $this->labelSize, 
			     $this->y2LabelsAngle, 
			     $this->labelFont );
	$x = $xstart;
	// compensate for text height
	// if it goes above the staring point
	// $height/2 centers it on the tic mark
	$y = $this->centerStringY($step,$this->labelSize,$txt,
				  0,$this->labelFont);
	$this->printString( $txt, 
			    $x, 
			    $y,
			    $this->labelSize,
			    $this->getColor($this->labelColor), 
			    $this->y2LabelsAngle, 
			    $this->labelFont );
      }
    } else {
      $this->addDebug("drawY2Labels","No labels found, skipping",3);
    }
  }

  function nextLayer() {
    // recalculate data points and
    // set custom values for the 
    // next input layer
    
    // increment the layer
    if( strlen($this->currentLayer) )
      $this->currentLayer++;
    else
      $this->currentLayer = 0;
    $num = $this->currentLayer;
    
    // reset parameters
    // $this->configureSettings( $this->defaultSettings );
    // removed because this jacks everything up
    // and isn't really necessary... an alternative
    // should this ever be needed
    // is to track which variables are changed by
    // each layer and reset them with $this->defaultSettings
    // after the layer completes.

    // apply this layers custom params
    if( $this->layers[$num]["settings"] ) {
      $this->configureSettings( $this->layers[$num]["settings"] );
    }
    $this->plotData($num);  
    //
    //
    //
    // fix the shelf shading for this layer.. then go on

    // add some depth
    $this->currentDepth -= $this->layers[$num]["settings"]["depth"];
    $this->currentOffset -= $this->layers[$num]["settings"]["depth"]/$this->offsetRatio;
  }

  /*
  **  PLOTTING METHODS
  */

  function plotData( $layer ) {
    // takes each data set for the layer and plots it on the graph
    // according to its settings and output type
    
    // loop through data sets.. extract all
    // bars and columns
    $special_types = array("bar","column","area","stack","barstack","pie");
    $this->addDebug("plotData($layer)","plotting data for $layer",2);

    $bars = array();
    $columns = array();
    $areas = array();
    $pies = array();

    $data = $this->layers[$layer]["data"];
    $config = $this->layers[$layer]["config"];

    // here we will loop through the data
    // configurations and determine
    // what types of data to graph, as well
    // as setting the colors up
    for( $i=0; $i<count($data); $i++ ) {
      // reset the colors for data to graph
      $flag = ($i == 0);
      $this->setDataColors($config[$i]["color"],$flag);
      
      if( !$config[$i]["type"] ) {
	$config[$i]["type"] = $this->graphType;
	$this->layers[$layer]["config"][$i]["type"] = $this->graphType;
      }

      // find and prepare areas
      // to be graphed
      if( $config[$i]["type"] == "dummy-row" ) {
	// this row is just used for calculations
	continue;
      }
      else if( $config[$i]["type"] == "area" ) {
	$this->addDebug("plotData", "adding area type",3);
	$areas[] = $i;
      } else if( $config[$i]["type"] == "column" ) {
	$this->addDebug("plotData", "adding column type",3);
	$columns[] = $i;
      } else if( $config[$i]["type"] == "stack" ) {
	if( !count($columns) ) {
	  $this->addDebug("plotColumns","data row $i is a 'stack' type"
			  ." without preceding 'column' type.."
			  ." it will be converted to a 'column' type",2);
	  $this->layers[$layer]["config"][$i]["type"] = "column";
	}
	$columns[] = $i;
      } else if( $config[$i]["type"] == "bar" ) {
	$this->addDebug("plotData", "adding bar type",3);
	$bars[] = $i;
      } else if( $config[$i]["type"] == "barstack" ) {
	$this->addDebug("plotData", "adding barstack type",3);
	if( !count($bars) ) {
	  $this->addDebug("plotColumns","data row $i is a 'barstack' type"
			  ." without preceding 'bar' type.."
			  ." it will be converted to a 'bar' type",2);
	  $this->layers[$layer]["config"][$i]["type"] = "bar";
	}
	$bars[] = $i;
      } else if( $config[$i]["type"] == "pie" ) {
	$this->addDebug("plotData", "adding pie type",3);
	$pies[] = $i;
      }
    }

    // plot special data sets
    if( count($areas) )
      $this->plotAreas($layer, $areas);
    if( count($columns) )
      $this->plotColumns($layer, $columns);
    if( count($bars) ) 
      $this->plotBars($layer, $bars);

    // plot all other data types
    for($i=0; $i<count($data); $i++) {
      $n = $config[$i]["type"];
      if( "$n" == "dummy-row" ) {
	// this row is just used for calculations
	continue;
      }
      if( preg_match("@^scatter-([a-zA-Z0-9]+)$@", $n, $matches) ) {
 	$n = $matches[1];
	$this->plotScatter($data[$i], $i, $n);
      }
      else if( !in_array($n,$special_types) ) {
	$name = "plot".ucfirst($n);
	if( !method_exists($this,$name) ) {
	  $this->addDebug("plotData", "Data type $n not found!", 1);
	  continue;
	}
	$this->$name($data[$i], $i);
      }
    }
    if( count($pies) ) {
      $this->plotPies($layer,$pies);
    }
  }
  
  function plotAreas( $layer, $areas ) {
    // takes a data set and makes
    // an area chart from it

    // set up the params
    $config = $this->layers[$layer]["config"];
    $num = count($areas);
    $this->addDebug("plotAreas($layer)", "number of rows to plot: $num", 2);
    if( $this->layers[$layer]["settings"]["compact"] ) {
      $step = ($this->xStep - $this->gap) / $this->layers[$layer]["settings"]["compact"];
    } else {
      $step = $this->xStep;
    }
    $depth = $this->layers[$layer]["settings"]["depth"];
    $offset = $depth / $this->offsetRatio;
    $cdepth = $this->currentDepth - $depth;
    $coffset = $this->currentOffset - $offset;
    $xzero = $this->xZero + $coffset;
    $yzero = $this->yZero - $cdepth;
    
    // loop through data
    if( $num ) {
      $data = $this->layers[$layer]["data"];
      for($i=0; $i < $num; $i++) {
	$row = $areas[$i];
	$y2tf = (isset($config[$row]["y2scale"])&&$config[$row]["y2scale"]>0);
	$points = array();
	// set up points based on values
	for($j=0; $j<$this->xMax; $j++) {	  
	  if( strlen($data[$row][$j]) ) {
	    // check to insure we are on the graph
	    if( $xzero + $step * $j <= $this->xEnd + $coffset ) {	      
	      $points[] = $this->checkRange($xzero + $step*$j, 'x', $coffset);
	      $points[] = $this->checkRange($yzero - 
		       $this->scaleY($data[$row][$j],$y2tf), 'y', $cdepth);
	    }
	  }	  
	}
	// draw the area if any points were obtained
	if( count($points) )
	  $this->drawArea( $points, $row, $depth );
      }
    }    
  }
  
  function plotBars( $layer, $bars ) {
    
  }
  
  function plotColumns( $layer, $columns ) {
    // plots all column charts
    // for the given layer
    
    $gap = (strlen($this->layers[$layer]["gap"]))? 
	$this->layers[$layer]["gap"] : $this->gap;
    $config = $this->layers[$layer]["config"];
    $compact = $this->layers[$layer]["settings"]["compact"];
    $num = count($columns);
    $this->addDebug("plotColumns($layer)", "number of rows to plot: $num", 2);
    if( $this->layers[$layer]["settings"]["compact"] ) {
      $step = ($this->xStep - $gap) / $compact;
    } else {
      $step = $this->xStep;
    }
    if( $num ) {
      $cols = 0;
      for($i=0; $i<$num; $i++) {
	if( $config["$i"]["type"] != "stack" )
	  $cols++;
      }
      $n = 0;     
      // determine starting points for graph
      $depth = $this->depth;
      $offset = $depth / $this->offsetRatio;
      $yoff = $this->currentDepth - $depth;
      $xoff = $this->currentOffset - $offset;
      $ybase = $this->yBase;
      $xbase = $this->xBase;
      $yzero = $this->yZero;
      $xzero = $this->xZero;
      $data = $this->layers[$layer]["data"];
      $barWidth = $this->calculateBarWidth($cols,$step,$gap);
      for( $j=0; $j<$this->xMax; $j++ ) {
	// we go through these by data column and then by data
	// row to get all the rows together on the graph
	$currentOffset = $xzero + $j*$step;
	$x1 = $currentOffset - $barWidth;
	$prev = 0;
	for($i=0; $i<$num; $i++) {
	  // here we are looping through the same
	  // data column in each row, and checking
	  // each to see if it is stacked, or beside
	  // the other rows
	  // determine x/y coords:
	  $row = $columns[$i];
	  $hide_top = 0;
	  if( is_array($data[$row]) && strlen($data[$row][$j]) ) {
	    $v = $data[$row][$j];
	    $y2tf = (isset($config[$row]["y2scale"]) && $config[$row]["y2scale"]>0);
	    if( $config[$row]["type"] == "column" || $i == 0 ) {
	      // move the x location right one bar..
	      // add in some space for any blank bars
	      // which were not graphed
	      $x1 += $barWidth;
	      if( $v < 0 ) {
		$y1 = $yzero;
		$y2 = $y1 - $this->scaleY($v,$y2tf);
	      } else {
		$y2 = $yzero;
		$y1 = $y2 - $this->scaleY($v,$y2tf);
	      }
	    } else {
	      // draw in the stacks on top of their
	      // respective bars
	      if( $v < 0 ) {
		$y1 = $y2;
		$y2 = $y1 - $this->scaleY($v,$y2tf);
		$hide_top = 1;
	      } else {
		$y2 = $y1;
		$y1 = $y2 - $this->scaleY($v,$y2tf);
	      }	      
	    }
	    $x2 = $x1 + $barWidth;
	    $x2 = $this->checkRange($x2,'x');
	    $y1 = $this->checkRange($y1);
	    $y2 = $this->checkRange($y2);
	    // set the color
	    $color = array($row,$j);
	    // draw the column if we are on the chart
	    $this->drawColumn($x1+$xoff,$y1-$yoff,
			      $x2+$xoff,$y2-$yoff,
			      $color,$depth,$hide_top);
	    $this->drawValue($x1+$xoff,$y1-$yoff,$v,$color);
	  } else if( $config[$row]["type"] == "column" ) {
	    $x1 += $barWidth;
	  } 
	}
      }
    }
  }
  
  function plotLine( $data, $row ) {
    // takes the values for a line
    // and draws each segment

    $layer = $this->currentLayer;
    $depth = $this->depth;
    $offset = $depth / $this->offsetRatio;

    $yoff = $this->currentDepth - $depth;
    $xoff = $this->currentOffset - $offset;

    $y2tf = (isset($this->layers[$layer]["config"][$row]["y2scale"])
	     &&$this->layers[$layer]["config"][$row]["y2scale"]>0);

    if( $this->layers[$layer]["settings"]["compact"] ) {
      $div = $this->xDiv * $this->layers[$layer]["settings"]["compact"];
      $step = $this->calculateStep( $div );
    } else {
      $div = $this->xDiv;
      $step = $this->xStep;
    }

    // loop through the data
    for($i=0; $i<count($data); $i++) {
      $j = $i+1;
      // make sure we are still on the graph
      if( $i > $div )
	break;
      // check for valid values to plot
      if( strlen($data[$i]) && strlen($data[$j]) ) {
	// determine the x,y coords for plotting
	$center = $step / 2;
	$x1 = $this->xBase + $step * $i + $center;
	if( $i == 0 )
	  $x1 -= $center;
	$y1 = $this->checkRange( $this->yZero - $this->scaleY($data[$i],$y2tf) );
	$x2 = $this->xBase + $step * $j + $center;
	$y2 = $this->checkRange( $this->yZero - $this->scaleY($data[$j],$y2tf) );
	$t1 = $this->checkRange( $x1, 'x!' );
	$t2 = $this->checkRange( $x2, 'x!' );
	if( $t1 && !$t2 ) {
	  $x2 = $this->xEnd;
	} else if( $t2 && !$t1 ) {
	  $x1 = $this->xBase;
	}
	if( $t1 || $t2 ) {
	  $this->drawLine( $x1+$xoff, $y1-$yoff, $x2+$xoff, $y2-$yoff, 
			   array($row,$i), $depth );
	  $this->drawValue($x1+$xoff,$y1-$yoff,$data[$i],array($row,$i));
	}
      }
    }
  }
  
  function plotPies( $layer, $rows ) {
    // plot all pie charts
    // which are on this layer
    // they get plotted in front of the data
    // this is a long and complex method here..
    // not a great deal of fun
    // this should probably get split up for
    // simplicity and maintenance

    // prepare data
    $config = $this->layers[$layer]["config"];
    $num = count($rows);    
    $data_sets = $this->layers[$layer]["data"];
    // loop through the elements
    foreach($rows as $r) {
      $options = $config[$r];
      $data = $data_sets[$r];     
      // don't graph anything that isn't
      if( !count($data) )
	continue;
      // set special values for pie chart
      // all these are optional
      // possibilities are:
      //   depth - depth of pie
      //   height - height of ellipse
      //   width - width of ellipse 
      //           (set same as height for a circle)
      //   gap - space between slices
      //   centerX - center of pie chart on x axis
      //   centerY - center of pie chart on y axis
      $depth = (strlen($options["depth"]))? 
	$options["depth"]:$this->depth;
      $height = (strlen($options["height"]))? 
	$options["height"] : $this->graphHeight;
      $width = (strlen($options["width"]))? 
	$options["width"] : $this->graphWidth;
      $gap = (strlen($options["gap"]))?
	$options["gap"] : $this->gap;
      $xc = (strlen($options["centerX"]))?
	$options["centerX"] : $this->graphWidth / 2 + $this->spanLeft;
      $yc = (strlen($options["centerY"]))?
	$options["centerY"] : $this->graphHeight / 2 + $this->spanTop;
      $pull = (is_array($options["pullSlice"]))?
		    $options["pullSlice"] : false;
      // here we set the offset (if used) to where the graph will
      // originate on the 360 degree plane
      $start = 0;
      if( $options["offsetStart"] ) {
	$start += $options["offsetStart"];
      }
      if( $start >= 360 )
	$start -= 360;
      $this->calculatePieSets($r,$data,$start,$width,$height,$gap,$pull);
      $set1 = $this->fetchPieSets(1);
      $set2 = $this->fetchPieSets(2);

      // here we loop through both
      // data sets, split up for quadrants
      // and print them... a little sorting
      // and some fancy footwork is required
      // to get everything running smoothly.
      // items to right of 3d axis
      if( is_array($set1) ) {
	//reset($set1);       
	while( list($key,$v1) = each($set1) ) {
	  list($k,$v2) = each($set1);	
	  if( $v1["pull"] ) {
	    $x = $xc + $v1["pull"][0];
	    $y = $yc + $v1["pull"][1];
	  } else {
	    $x = $xc;
	    $y = $yc;
	  }
	  // todo
	  // 
	  //
	  // add drawValue() 
	  // somehow
	  $this->drawSlice( $x, $y, 
			    $width, $height, 
			    $v1["angle"], $v2["angle"], 
			    $v1["color"], $depth,
			    $v1["chop"], $v2["chop"] );
	}
      }
      // items to left of 3d axis
      if( is_array($set2) ) {
	//reset($set2);
	while( list($key,$v1) = each($set2) ) {
	  list($k,$v2) = each($set2);
	  if( $v1["pull"] ) {
	    $x = $xc + $v1["pull"][0];
	    $y = $yc + $v1["pull"][1];
	  } else {
	    $x = $xc;
	    $y = $yc;
	  }
	  // todo
	  // 
	  //
	  // add drawValue() 
	  // somehow
	  $this->drawSlice( $x, $y, 
			    $width, $height, 
			    $v2["angle"], $v1["angle"], 
			    $v2["color"], $depth,
			    $v2["chop"],  $v1["chop"] );
	}
      }
    }
  }

  function calculatePieSets($r,$data,$current,$width,$height,$gap = 0,$pulls=false) {
    // loop through values and plot slices

    // initialize
    //$sets = array();
    // set a total
    // we do this special to remove
    // the negative values... which cause trouble
    // since this is a pie... and negative/zero values
    // have no representation
    $total = 0;
    for($i=0; $i<count($data); $i++) {
      if( $data[$i] > 0 )
	$total += $data[$i];
    }

    // don't divide by zero
    // don't plot things that aren't
    if( $total <= 0 ) {
      $this->addDebug("calculatePieSets($r,$data,$current,$width,$height,$gap)", "returning blank data set",2);
      return $sets;
    }
    // make a scale
    $scale = 360 / $total;
    // loop through data vals
    for($i=0; $i<count($data); $i++) {
      if( $data[$i] > 0 ) {
	// get color
	$color = array($r,$i);
	// set starting point for slice
	$start = $current;
	// add a gap
	if( $gap > 0 )
	  $start += $gap / 2;
	// scale the value
	$current += ( $data[$i] * $scale );	
	$current %= 360;
	$end = $current;
	// add a gap, assuming it doesn't change the order of things
	if( ($end > $start && $end - $gap/2 > $start) 
	    || ($end < $start && $end - $gap/2 < $start) )
	  $end -= $gap/2;
	// set a proportional value for measuring
	// and for working
	// $start %= 360;
	// $end %= 360;
	// check for accidently loosing 360 values	
	if( $end == $start && $data[$i] > 0 )
	  $end += 360;

	if( $pulls && (
	      (is_array($pulls[0])&&in_array(($i+1),$pulls[0]))
	      || (!is_array($pulls[0]) && intval($pulls[0]) == ($i+1)) )
	    ) {
	  $this->addDebug("calculatePieSets", "pull detected: $i",2);
	  $pull = $this->getSlicePullAdjustments($width,$height,
						 $start,$end,
						 $pulls[1],$pulls[2]);
	} else {
	  $pull = false;
	}
	$wgh = ($width >= $height);

	/*
	** Here we will run through some complex hoops to sort and 
	** arrange the values according to their axis orientation
	**
	** POSSIBILITY 1 - width >= height
	**
	*/
	if( $wgh ) {
	  // quadrants I & II go to [0]
	  // quadrants III & IV go to [1]

	  // case 1: start >=270||<90 and end >=270||<90 and end >= start
	  // simple slice
	  // start[1], end[1]
	  if( ($start >= 270 || $start < 90) && ($end >= 270 || $end < 90) && ($end >= $start || $end < 90 && $start >= 270) ) {
	    $this->addSlice(1, $start, $end, $color, $wgh, FALSE, FALSE,$pull);
	  }
	  // case 2: start >=270||<90 and end >=270||<90 and end < start
	  // 3/4 slice
	  // start[1], 89[1], 90[2], 269[2], 270[1], end[1]
	  else if( ($start >= 270 || $start < 90) && ($end >= 270 || $end < 90) && $end < $start ) {
	    $this->addSlice(1, $start, 90/**/, $color, $wgh, FALSE, TRUE,$pull);
	    $this->addSlice(2, 90, 270/**/, $color, $wgh, TRUE, TRUE,$pull);
	    $this->addSlice(1, 270, $end, $color, $wgh, TRUE, FALSE,$pull);
	  }
	  // case 3: start >=270||<90 and end >=90&&<270
	  // 1/2 slice
	  // start[1], 89[1], 90[2], end[2]
	  else if( ($start >= 270 || $start < 90) && ($end >= 90 && $end < 270) ) {
	    $this->addSlice(1, $start, 90/**/, $color, $wgh, FALSE, TRUE,$pull);
	    $this->addSlice(2, 90, $end, $color, $wgh, TRUE, FALSE,$pull);
	  }
	  // case 4: start <270&&>=90 and end <270&&>=90 and end >= start
	  // simple slice
	  // start[2], end[2]
	  else if( ($start < 270 && $start >= 90) && ($end < 270 && $end >= 90) && $end >= $start ) {
	    $this->addSlice(2, $start, $end, $color, $wgh, FALSE, FALSE,$pull);
	  }
	  // case 5: start <270&&>=90 and end <270&&>=90 and end < start
	  // 3/4 slice
	  // start[2], 269[2], 270[1], 89[1], 90[2], end[2]
	  else if( ($start < 270 && $start >= 90) && ($end < 270 && $end >= 90) && $end < $start ) {
	    $this->addSlice(2, $start, 270/**/, $color, $wgh, FALSE, TRUE,$pull);
	    $this->addSlice(1, 270, 90/**/, $color, $wgh, TRUE, TRUE,$pull);
	    $this->addSlice(2, 90, $end, $color, $wgh, TRUE, FALSE,$pull);
	  }
	  // case 6: start <270&&>=90 and end >=270||<90
	  // 1/2 slice
	  // start[2], 269[2], 270[1], end[1]
	  else if( ($start < 270 && $start >= 90) && ($end >= 270 || $end < 90) ) {
	    $this->addSlice(2, $start, 270/**/, $color, $wgh, FALSE, TRUE,$pull);
	    $this->addSlice(1, 270, $end, $color, $wgh, TRUE, FALSE,$pull);
	  }
	  // create an error message to let us know our code
	  // is stupid
	  else {
	    $this->addDebug("calculatePieSets", "COULDN'T MAKE A SLICE!! $start/$end,$current",1);
	  }
	}       
	/*
	**
	** POSSIBILITY 2 - height > width
	**
	*/
	else {
	  // quadrants II & III go to [0]
	  // quadrants I & IV go to [1]

	  // case 1: start >= 180 and end >= 180 and end >= start
	  // simple slice
	  // start[1], end[1]
	  if( $start >= 180 && $end >= 180 && $end >= $start ) {
	    $this->addSlice(1, $start, $end, $color, $wgh, FALSE, FALSE,$pull);
	  }       
	  // case 2: start >= 180 and end >= 180 and end < start
	  // 3/4 slice
	  // start[1], 359[1], 0[2], 179[2], 180[1], end[1]
	  else if( $start >= 180 && $end >= 180 && $end < $start ) {
	    $this->addSlice(1, $start, 360/**/, $color, $wgh, FALSE, TRUE,$pull);
	    $this->addSlice(2, 0, 180/**/, $color, $wgh, TRUE, TRUE,$pull);
	    $this->addSlice(1, 180, $end, $color, $wgh, TRUE, FALSE,$pull);
	  }
	  // case 3: start >= 180 and end < 180
	  // 1/2 slice
	  // start[1], 359[1], 0[2], end[2]
	  else if( $start >= 180 && $end < 180 ) {
	    $this->addSlice(1, $start, 360/**/, $color, $wgh, FALSE, TRUE,$pull);
	    $this->addSlice(2, 0, $end, $color, $wgh, TRUE, FALSE,$pull);
	  }
	  // case 4: start < 180 and end < 180 and end >= start
	  // simple slice
	  // start[2], end[2]
	  else if( $start < 180 && $end < 180 && $end >= $start ) {
	    $this->addSlice(2, $start, $end, $color, $wgh, FALSE, FALSE,$pull);
	  } 
	  // case 5: start < 180 and end < 180 and end < start
	  // 3/4 slice
	  // start[2], 179[2], 180[1], 359[1], 0[2], end[2]
	  else if( $start < 180 && $end < 180 && $end < $start ) {
	    $this->addSlice(2, $start, 180/**/, $color, $wgh, FALSE, TRUE,$pull);
	    $this->addSlice(1, 180, 360/**/, $color, $wgh, TRUE, TRUE,$pull);
	    $this->addSlice(2, 0, $end, $color, $wgh, TRUE, FALSE,$pull);
	  }
	  // case 6: start < 180 and end > 180
	  // 1/2 slice
	  // start[2], 179[2], 180[1], end[1]
	  else if( $start < 180 && $end > 180 ) {
	    $this->addSlice(2, $start, 180/**/, $color, $wgh, FALSE, TRUE,$pull);
	    $this->addSlice(1, 180, $end, $color, $wgh, TRUE, FALSE,$pull);
	  }
	}
      }
    }

    // sort the data sets so that they graph correctly
    if( is_array($this->pieSets[2]) ) {
      krsort($this->pieSets[2]);    
    }
    // don't sort set1 if it starts at 270 and ends at 90 (of course)
    // test this with $wgh
    if( !$wgh && is_array($this->pieSets[1]) ) {
      ksort($this->pieSets[1]);
    }
  }

  function getSlicePullAdjustments( $w, $h, $s, $e, $x, $y ) {
    // creates adjustments for pulling a slice
    // from the pie for isolation
    $ratio = $h/$w;
    if( $e < $s )
      $e += 360;
    $angle = ($s + abs($e-$s)/2)%360;
    list($xr,$yr) = $this->ellipse_point(0,0,$x,$x*$ratio,$angle);
    return( array($xr,($yr-$y)) );
  }

  function addSlice($set, $start, $end, $color, $wgh, $cs = false, $ce = false, $pull = false ) {    
    // internal use only
    // adds data from calculatePieSets() to set arrays
    // for use by plotPies()
    // $set is the set to add to based on orientation
    // $start and $end are start/end angles of new slice
    // $wgh is boolean identifying whether width of graph
    // is greater than height
    // use 1 or 2 for the set

    $this->addDebug("addSlice($set,$start,$end,$color,$wgh,$cs,$ce,$pull)", "adding new slice",3);

    // initialize arrays if not done
    if( !is_array($this->pieSets[1]) )
      $this->pieSets[1] = array();
    if( !is_array($this->pieSets[2]) )
      $this->pieSets[2] = array();    
    // do slices where width >= height
    if( $wgh && ($start >= 270 || $start < 90) ) {
      // if we are in the 270-90 region, we will
      // recreate the array and stick everything
      // into it still in order
      $vals = $this->fetchPieSets($set);
      $this->pieSets[$set] = array();
      $flag = 0;
      foreach($vals as $k=>$v) {
	if( !$flag && ( 
	    ($start >= 270 && ($start < $v["angle"] || $v["angle"] < 90)) 
	    || 
	    ($start < 90 && $v["angle"] < 90 && $start < $v["angle"])
	    ) ) {
	  $this->pieSets[$set]["$start"] = array("angle"=>$start,
						 "color"=>$color,
						 "chop" =>$cs,
						 "pull" =>$pull);  
	  $this->pieSets[$set]["$end"] = array("angle"=>$end,
					       "color"=>$color,
					       "chop" =>$ce,
					       "pull" =>$pull);  
	  $flag = 1;
	}
	$this->pieSets[$set]["$k"] = $v;
      }
      if( !$flag ) {
	  $this->pieSets[$set]["$start"] = array("angle"=>$start,
						 "color"=>$color,
						 "chop" =>$cs,
						 "pull" =>$pull);  
	  $this->pieSets[$set]["$end"] = array("angle"=>$end,
					       "color"=>$color,
					       "chop" =>$ce,
					       "pull" =>$pull);  
	  $flag = 1;
      }	
    } else {
      $this->pieSets[$set]["$start"] = array("angle" => $start,
					     "color" => $color,
					     "chop"  => $cs,
					     "pull"  => $pull);    
      $this->pieSets[$set]["$end"] = array("angle"  => $end,
					   "color"  => $color,
					   "chop"   => $ce,
					   "pull"   => $pull);
    }
  }

  function fetchPieSets($set) {
    // internal use only
    // returns pie set data
    // use 1 or 2
    return $this->pieSets[$set];
  }
  var $pieSets = array();
  
  function plotScatter( $data, $row, $type = '' ) {
    // creates a scatter on chart
    $layer = $this->currentLayer;
    $depth = $this->depth;
    $offset = $depth / $this->offsetRatio;
    $yoff = $this->currentDepth - $depth;
    $xoff = $this->currentOffset - $offset;
    if( $this->layers[$layer]["settings"]["compact"] ) {
      $div = $this->xDiv * $this->layers[$layer]["settings"]["compact"];
      $step = $this->calculateStep( $div );
    } else {
      $div = $this->xDiv;
      $step = $this->xStep;
    }
    $config = $this->layers[$layer]["config"];
    $y2tf = (isset($config[$row]["y2scale"])&&$config[$row]["y2scale"]>0);
    $num = count($data);
    $this->addDebug("plotScatter($data,$row)", "plotting a scatter array", 2);
    for( $i=0; $i<$num; $i++ ) {
      if( strlen($data[$i]) ) {
	$x = $i * $step + $this->xZero + $xoff;
	$y = $this->yZero - $this->scaleY( $data[$i],$y2tf ) - $yoff;
	$col = $this->getDataColor( $row, $i );
	if( $this->checkRange($x,'x!') && $this->checkRange($y,'y!',$depth) ) {
	  $this->drawPoint($x, $y, $col, $type);
	  $this->drawValue($x,$y,$data[$i],array($row,$i));
	}
      }
    }
  }

  /*
  **  DRAWING METHODS
  */

  function border2D( $x1, $y1, $x2, $y2, $thickness, $color ) {
    // draws a border line, but not in 3d
    // creates a line on the graph
    $col = $this->getColor($color);
    $dt = $this->lineThickness;
    $this->lineThickness = $thickness;
    $this->drawLine( $x1, $y1, $x2, $y2, $col, 0 );
    $this->lineThickness = $dt;
    $this->addDebug("border2D($x1,$y1,$x2,$y2,$thickness,$color)","processed",3);    
  }

  function border3D( $x1, $y1, $x2, $y2, $thickness, $color, $loc ) {
    // determines lighting via the slope of the line, 
    // and produces the border line accordingly

    // check bounds
    if( $x1 > $x2 ) {
      $tmp = $x1;
      $x1 = $x2;
      $x2 = $tmp;
    }
    if( $y1 > $y2 ) {
      $tmp = $y1;
      $y1 = $y2;
      $y2 = $tmp;
    }
 
    // set the color
    $col = $this->getColor($color);
    // determine the light/dark widths
    $t = $thickness / 2;
    // determine how to offset the angles
    $o = $t/2;

    // tf for horizontal or vertical
    $tf = ($x2-$x1 > $y2 - $y1);

    // here we check the lengths, and we shorten them to the middle
    // if we are using $loc="inner", so that they don't overlap the outer
    // borders
    if( $loc == "inner" ) {
      // we don't do anything with y on horizontal lines
      // or with x on vertical lines
      // on lines that are at an angle... we just see which way is longer
      // we don't do anything with distances less than $thickness
      // because this would result in a zero length
      // we don't check anything coming in as "top","bottom","left",or"right"
      // because we assume these are oriented vertical, or horizonatal by name
      if( !$tf ) {
	// vertical line
	if( $x1 < $x2-$thickness ) { $x1 += $t; $x2 -= $t; }
      }
      else {
	// horizontal line
	if( $y1 < $y2-$thickness ) { $y1 += $t; $y2 -= $t; }
      }
    }

    // initialize data elements
    $lpts = array();
    $dpts = array();
    // here we determine how to offset the dark and light elements
    // and make the x,y coords accordingly
    if( !$tf ) {
      // shade based on top/bottom      
      $darkcol = $this->getColor($color,$this->shd(2,1));
      // these are here in both instances because eventually
      // I hope to see the shd function more dynamic... so that
      // the light source can move around... at which point
      // it will matter which way we are oriented (thus the dupliation)
      $lightcol = $this->shd(1,2);
    } else {
      // shade based on left/right
      $darkcol = $this->getColor($color,$this->shd(2,1));
      $lightcol = $this->getColor($color,$this->shd(1,2));
    }
    $darkcol = $this->getColor($color,"dark");
    $lightcol = $this->getColor($color,"light");
    // determine xy coords
    // right now this is kind of simplistic logic
    // it should be updated to be more intuitive of 
    // angles... but it will do the trick
    $center = array($x2,$y2,$x1,$y1); // center of line
    switch( $loc ) {
    case "inner":  // beveled on both sides	
      $lpts = (!$tf)? 
	array_merge(array($x1-$t,$y1+$t,$x2-$t,$y2-$t),$center):   // vertical(x constant)
	array_merge(array($x1+$t,$y1-$t,$x2-$t,$y2-$t),$center);   // horizontal(y constant)
      $dpts = (!$tf)?
	array_merge(array($x1+$t,$y1+$t,$x2+$t,$y2-$t),$center):   // vertical(x constant)
	array_merge(array($x1+$t,$y1+$t,$x2-$t,$y2+$t),$center);   // horizontal(y constant)
      break;
    case "top":    // beveled on lower edge
      $lpts = array_merge(array($x1-$t,$y1-$t,$x2+$t,$y2-$t),$center);
      $dpts = array_merge(array($x1+$t,$y1+$t,$x2-$t,$y2+$t),$center);
      break;
    case "bottom": // beveled on upper edge
      $lpts = array_merge(array($x1+$t,$y1-$t,$x2-$t,$y2-$t),$center);
      $dpts = array_merge(array($x1-$t,$y1+$t,$x2+$t,$y2+$t),$center);
      break;
    case "left":  // beveled on right edge
      $lpts = array_merge(array($x1-$t,$y1-$t,$x2-$t,$y2+$t),$center);
      $dpts = array_merge(array($x1+$t,$y1+$t,$x2+$t,$y2-$t),$center);	
      break;
    case "right": // beveled on left edge
      $lpts = array_merge(array($x1-$t,$y1+$t,$x2-$t,$y2-$t),$center);
      $dpts = array_merge(array($x1+$t,$y1-$t,$x2+$t,$y2+$t),$center);	
      break;
    default:      // not beveled
      $lpts = (!$tf)?
	array_merge(array($x1-$t,$y1,$x2-$t,$y2),$center) : // vertical (x constant)
	array_merge(array($x1,$y1-$t,$x2,$y2-$t),$center);  // horizontal (y constant)
      $dpts = (!$tf)?
	array_merge(array($x1+$t,$y1,$x2+$t,$y2),$center) : // vertical (x constant)
	array_merge(array($x1,$y1+$t,$x2,$y2+$t),$center);  // horizontal (y constant)
    }
  
    // draw light side
    imageFilledPolygon( $this->img, $lpts, count($lpts)/2, $lightcol );
    // draw dark side
    imageFilledPolygon( $this->img, $dpts, count($dpts)/2, $darkcol );
    // debug info
    $this->addDebug("border3D($x1,$y1,$x2,$y2,$thickness,$color)","processed",3);        
  }

  function drawBorder( $x1, $y1, $x2, $y2, $thickness, $color, $loc ) {
    // draws individual bars for borders of tables and legends
    // $loc trims the line if it is an inner bar, or edge
    // applicable choices are: top, bottom, left, right or inner
    // i.e. "top" would bevel this as a top edge (to fit on top of left/right components)
    if( $this->graphDepth > 0 && $thickness > 1 ) {
      $this->border3D($x1, $y1, $x2, $y2, $thickness, $color, $loc);
    } else {
      $this->border2D($x1,$y1,$x2,$y2,$thickness,$color);
    }
  }

  function plotBorders( $x1, $y1, $x2, $y2, $thickness, $color ) {
    // draws a beveled (if thickness > 1) box at the coordinates given
    $this->drawBorder($x1,$y1,$x2,$y1,$thickness,$color,"top");
    $this->drawBorder($x1,$y2,$x2,$y2,$thickness,$color,"bottom");
    $this->drawBorder($x1,$y1,$x1,$y2,$thickness,$color,"left");
    $this->drawBorder($x2,$y1,$x2,$y2,$thickness,$color,"right");
  }

  function drawArea( $points, $row, $depth = 0 ) {
    // create an area fill
    
    // set the color
    $color = $this->getDataColor($row,0);

    // add the base points to the polygon
    $ye = $points[ count($points)-1 ];
    $xe = $points[ count($points)-2 ];
    $ys = $points[1];
    $xs = $points[0];
    
    $cdepth = $this->currentDepth - $depth;
    $coffset = $this->currentOffset - $offset;
    $yzero = $this->yZero - $cdepth;
    $xzero = $this->xZero - $coffset;
    
    if( $ye != $yzero ) {
      $points[] = $xe;
      $points[] = $yzero;
    }
    $points[] = $xs;
    $points[] = $yzero;
    if( $ys != $yzero ) {
      $points[] = $xs;
      $points[] = $ys;
    }

    if( $depth ) {
      for($i=0; $i<count($points)-2; $i+=2) {
	$this->shadeLine( $points[$i], $points[$i+1], $points[$i+2], $points[$i+3], 
			  array($row,0), $depth );
      }
    }

    // create filled polygon shape
    imageFilledPolygon( $this->img, $points, count($points)/2, $color );
    
  } 

  function drawColumn( $x1, $y1, $x2, $y2, $color, $depth = 0, $hide_top = '' ) {
    // creates a vertical column on the graph
    if( $depth ) {
      $this->shadeColumn($x1,$y1,$x2,$y2,$color,$depth,$hide_top);
    }
    $color = $this->getDataColor($color[0],$color[1]);
    //
    //  setup to draw borders if desired
    //
    //
    //
    //
    $this->drawRectangle( $x1,$y1,$x2,$y2,$color );
    $this->addDebug("drawColumn($x1,$y1,$x2,$y2,$color,$depth,$hide_top)","completed",3);
  }

  function drawBar( $x1, $y1, $x2, $y2, $color, $depth = 0 ) {
    // creates a horizontal bar on the graph

  }

  function drawLine( $x1, $y1, $x2, $y2, $color, $depth = 0 ) {
    // creates a line on the graph
    if( is_array($color) ) {
      $col = $this->getDataColor($color[0],$color[1]);
    } else {
      $col = $this->getColor($color);
    }
    if( $this->lineThickness > 1 ) {
      $t = $this->lineThickness / 2;
      if( $depth ) {
	$this->shadeLine($x1,$y1-$t,$x2,$y2-$t,$color,$depth);
      }
      $points = array(
		      $x1, $y1 - $t,
		      $x1, $y1 + $t,
		      $x2, $y2 + $t,
		      $x2, $y2 - $t );
      imageFilledPolygon( $this->img, $points, count($points)/2, $col );
    } else {
      if( $depth ) {
	$this->shadeLine($x1,$y1,$x2,$y2,$color,$depth);
      }
      imageLine( $this->img, $x1, $y1, $x2, $y2, $col );
    }
    $this->addDebug("drawLine($x1,$y1,$x2,$y2,$color,$depth)","completed",2);
  }

  function drawGuidelines() {
    // creates guidelines on the graph
    // based on config params
    // the types are outlined in the config file
    // an optional ! added to the end of any type
    // (i.e. "line!") will prevent drawing into
    // the 3d portion

    if( preg_match("@[!]@",$this->showYGuides) ) {
      $yno = 1;
      $this->showYGuides = preg_replace("@[!]@", "", $this->showYGuides);
    }
    if( preg_match("@[!]@",$this->showXGuides) ) {
      $xno = 1;
      $this->showXGuides = preg_replace("@[!]@", "", $this->showXGuides);
    }

    // check for scaled guides (color is an array)
    $yes = (is_array($this->colorYGuidelines)
	    && is_array($this->colorYGuidelines[0]));
    $xes = (is_array($this->colorXGuidelines)
	    && is_array($this->colorXGuidelines[0]));

    // prepare colors
    if( !$yes )
      $yColor = $this->getColor( $this->colorYGuidelines );
    if( !$xes )
      $xColor = $this->getColor( $this->colorXGuidelines );
    if( $this->graphDepth ) {
      if( $this->showYGuides && !$yes && !$yno )
	$yColorDark = $this->getColor( $this->colorYGuidelines, 
				       $this->shd(1,2,1,1) );
      if( $this->showXGuides && !$xes && !$xno )
	$xColorLight = $this->getColor( $this->colorXGuidelines, 
					$this->shd(1,1,1,2) );
      $ydiff = $this->yBase - $this->yBaseOffset;
      $xdiff = $this->xBaseOffset - $this->xBase;
    }
    $ys = $this->yStep;
    $xs = $this->xStep;

    // check for invalid types
    if( !$this->graphDepth ) {
      if( $this->showYGuides == "shelf" )
	$this->showYGuides = "line";
      if( $this->showXGuides == "shelf" )
	$this->showXGuides = "line";
    }

    if( $this->showXGuides && !$xno )
      $this->drawLayerGuides();
    
    $adj = ($this->frameThickness > 1)? $this->frameThickness/2 : 0;

    // do y axis
    $skip = 0;
    if( $this->showYGuides == "shelf" ) {
      $j = 0;
      for( $i = $this->yEndOffset + $ys;
	   $i < $this->yBaseOffset;
	   $i+= $ys ) {
	if( $yes ) {
	  if(is_array($this->colorYGuidelines[$j])) {
	    $skip = 0;
	    $c = $this->colorYGuidelines[$j];
	    $yColor = $this->getColor($c);
	  } else {
	    $skip = 1;
	  }
	  $j++;
	}
	if( !$skip ) {
	  $points = array( $this->xBase,        $i + $ydiff,
			   $this->xBaseOffset,  $i,
			   $this->xEndOffset,   $i,
			   $this->xEnd,         $i + $ydiff );
	  imageFilledPolygon( $this->img, $points, count($points)/2, $yColor );
	}
      }
    } else if( $this->showYGuides == "bar" ) {
      // set up the step
      $yadd = ($yes)? $ys : $ys * 2;
      $j = 0;
      for( $i = $this->yBaseOffset;
	   floor($i) > $this->yEndOffset;
	   $i -= $yadd ) {
	// set the color
	if( $yes ) {
	  if (is_array($this->colorYGuidelines[$j])) {
	    $skip = 0;
	    $c = $this->colorYGuidelines[$j];
	    $yColorDark = $this->getColor($c,$this->shd(1,2));
	    $yColor = $this->getColor($c);
	  } else {
	    $skip = 1;
	  }
	    $j++;
	}
	if( !$skip ) {
	  $this->drawRectangle( $this->xBaseOffset, 
				$i-$ys, 
				$this->xEndOffset, 
				$i,
				$yColor );
	  if( $this->graphDepth && !$yno ) {
	    $points = array( $this->xBase,       $i-$ys+$ydiff,
			     $this->xBaseOffset, $i-$ys,
			     $this->xBaseOffset, $i,
			     $this->xBase,       $i+$ydiff );
	    imageFilledPolygon( $this->img, $points, count($points)/2,$yColorDark);
	  }
	}
      }
    } else if( $this->showYGuides == "line" ) {
      $j = 0;
      for( $i = $this->yEndOffset + $ys; 
	   $i < $this->yBaseOffset;
	   $i+= $ys ) {
	if( $yes ) {
	  if (is_array($this->colorYGuidelines[$j])) {
	    $c = $this->colorYGuidelines[$j];
	    $skip = 0;	    
	    $yColorDark = $this->getColor($c,$this->shd(1,2));
	    $yColor = $this->getColor($c);
	  } else {
	    $skip = 1;
	  }
	  $j++;
	}
	if( !$skip ) {
	  $this->drawRectangle( $this->xBaseOffset, 
				$i - $adj, 
				$this->xEndOffset, 
				$i + $adj,
				$yColor );
	  if( $this->graphDepth && !$yno ) {
	    $points = array(
			    $this->xBase,
			    $i + $ydiff - $adj,
			    $this->xBase,
			    $i + $ydiff + $adj,
			    $this->xBaseOffset,
			    $i + $adj,
			    $this->xBaseOffset,
			    $i - $adj
			    );
	    imageFilledPolygon( $this->img,
				$points,
				count($points)/2,
				$yColorDark );
	  }
	}
      }
    }

    // do x axis
    $skip = 0;
    if( $this->showXGuides == "shelf" ) {
      $j = 0;
      for( $i = $this->xBaseOffset + $xs;
	   $i < $this->xEndOffset;
	   $i+= $xs ) {
	$points = array( $i - $xdiff,  $this->yEnd,
			 $i,           $this->yEndOffset,
			 $i,           $this->yBaseOffset,
			 $i - $xdiff,  $this->yBase );
	if( $xes ) {
	  if (is_array($this->colorXGuidelines[$j])) {
	    $c = $this->colorXGuidelines[$j];
	    $xColor = $this->getColor($c);
	    $skip = 0;
	  } else {
	    $skip = 1;
	  }
	  $j++;
	}
	if( !$skip )
	  imageFilledPolygon( $this->img, $points, count($points)/2, $xColor );
      }
    } else if( $this->showXGuides == "bar" ) {
      $j = 0;
      for( $i = $this->xBaseOffset; 
	   $i < $this->xEndOffset; 
	   $i+= $xs*2 ) {
	if( $xes ) {
	  if (is_array($this->colorXGuidelines[$j])) {
	    $c = $this->colorXGuidelines[$j];
	    $skip = 0;
	    $xColorLight = $this->getColor($c,$this->shd(2,1));
	    $xColor = $this->getColor($c);
	  } else {
	    $skip = 1;
	  }	    
	  $j++;
	}
	if( !$skip ) {
	  $this->drawRectangle(	$i, 
				$this->yEndOffset, 
				$i+$xs, 
				$this->yBaseOffset,
				$xColor );
	  if( $this->graphDepth && !$xno ) {
	    $points = array( $i,              $this->yBaseOffset,
			     $i+$xs,          $this->yBaseOffset,
			     $i-$xdiff+$xs,   $this->yBase,
			     $i-$xdiff,       $this->yBase );			   
	    imageFilledPolygon( $this->img, $points, count($points)/2, $xColorLight );
	  }
	}    
      }  
      $this->drawLayerGuides();
    } else if( $this->showXGuides == "line" ) {
      $j = 0;
      for( $i = $this->xBaseOffset; 
	   $i <= $this->xEndOffset; 
	   $i+= $xs ) {
	if( $xes ) {
	  if(is_array($this->colorXGuidelines[$j])) {
	    $c = $this->colorXGuidelines[$j];
	    $skip = 0;
	    $xColorLight = $this->getColor($c,$this->shd(2,1));
	    $xColor = $this->getColor($c);
	  } else {
	    $skip = 1;
	  }
	  $j++;
	}
	if( !$skip ) {
	  $this->drawRectangle( $i - $adj, 
				$this->yEndOffset, 
				$i + $adj, 
				$this->yBaseOffset,
				$xColor );
	  if( $this->graphDepth && !$xno ) {
	    $points = array(
			    $i - $xdiff - $adj,
			    $this->yBase,
			    $i - $xdiff + $adj,
			    $this->yBase,
			    $i + $adj,
			    $this->yBaseOffset,
			    $i - $adj,
			    $this->yBaseOffset
			    );			  
	    imageFilledPolygon( $this->img,
				$points,
				count($points)/2,
				$xColorLight );
	  }
	}
      }
    }

  }

  function drawHeadings() {
    // draws all headings, titles and labels

    // draw labels
    $this->drawXLabels();
    $this->drawYLabels();
    $this->drawY2Labels();

    // draw y heading
    if( strlen($this->yHeading) ) {
      // set x,y coordinates
      $y = $this->centerStringY( $this->graphHeight/2+$this->spanTop,
			       $this->headingSize,
			       $this->yHeading,
			       $this->yHeadingAngle,
			       $this->headingFont );
      $y_head_y = $y;
      $x = $this->margin;
      // print it
      $this->printString( $this->yHeading, $x, $y,
			  $this->headingSize,
			  $this->getColor($this->headingColor),
			  $this->yHeadingAngle,
			  $this->headingFont );
    }
    // draw y subheading
    if( strlen($this->ySubHeading) > 0 ) {
      $x = $this->margin;
      // here we do some complex thinking to come up with
      // the x,y coords relative to the angle of the text
      if( $this->yHeadingAngle == 270 || $this->yHeadingAngle == 90 
	  || !strlen($this->yHeading) ) {
	$y = $this->centerStringY( $this->graphHeight/2+$this->spanTop,
				   $this->subHeadingSize,
				   $this->ySubHeading,
				   $this->yHeadingAngle,
				   $this->subHeadingFont );
	$tf = TRUE;
      } else {
	$y = $y_head_y;
	$this->textStart($x,$y,$this->yHeading,$this->headingSize,
			 $this->yHeadingAngle,$this->headingFont, FALSE);
	$tf = FALSE;
      }
      // offset the subheading according to the
      // size and angle of the heading text
      if( strlen($this->yHeading) > 0 ) {
	$params = $this->textParams( $this->yHeading, $this->headingSize,
				     $this->yHeadingAngle, $this->headingFont );
	if( $params[4] || $params[5] ) {
	  $spaces = $this->angledSpace($this->space,$this->yHeadingAngle);
	  if( $params[4] )
	    $x += $spaces[0];
	  if( $params[5] )
	    $y += ($this->yHeadingAngle <= 270)? $spaces[1] : -($spaces[1]);
	}
	$x += $params[4];       
	$y += ($this->yHeadingAngle <= 270)? $params[5] : -($params[5]);
      }
      $this->printString( $this->ySubHeading, $x, $y,
			  $this->subHeadingSize,
			  $this->getColor($this->subHeadingColor),
			  $this->yHeadingAngle,
			  $this->subHeadingFont, TRUE, $tf );
    }
    $x_head_y = $this->yBase + $this->space;
    if( is_array($this->xLabels) ) {
      $x_head_y += $this->getStringHeight($this->findLongestString($this->xLabels),
					  $this->labelSize,
					  $this->xLabelsAngle,
					  $this->labelFont);
      $x_head_y += $this->space;
    }

    // draw x heading
    if( $this->xHeading ) {
      $x = $this->centerStringX( $this->graphWidth/2+$this->spanLeft,
				 $this->headingSize,
				 $this->xHeading,
				 $this->xHeadingAngle,
				 $this->headingFont );
      $x_head_x = $x;
      $y = $x_head_y;
      $this->printString( $this->xHeading, $x, $y,
			  $this->headingSize,
			  $this->getColor($this->headingColor),
			  $this->xHeadingAngle,
			  $this->headingFont );
    }
    // draw x subheading
    if( $this->xSubHeading ) {
      // here we do some complex thinking to determine
      // what happens to the x,y coords based
      // on the angle of the text
      $y = $x_head_y;
      if( $this->xHeadingAngle == 0 || $this->xHeadingAngle == 180 || 
	  !strlen($this->xHeading) ) {
	$x = $this->centerStringX( $this->graphWidth/2+$this->spanLeft,
				   $this->subHeadingSize,
				   $this->xSubHeading,
				   $this->xHeadingAngle,
				   $this->subHeadingFont );
	$tf = TRUE;
      } else {
	$x = $x_head_x;
	$this->textStart($x,$y,$this->xHeading,$this->headingSize,
			 $this->xHeadingAngle,$this->headingFont,FALSE,TRUE);
	$tf = FALSE;	
	// here we do a couple of complex calculations to 
	// determine if we need to adjust the location of the 
	// subtitle to put it directly under the title
	$xHeadingHeight = $this->getStringHeight( $this->xHeading,
						  $this->headingSize,
						  $this->xHeadingAngle,
						  $this->headingFont);
	$xSubHeadingHeight = $this->getStringHeight( $this->xSubHeading,
						     $this->subHeadingSize,
						     $this->xHeadingAngle,
						     $this->subHeadingFont);
	if( $xSubHeadingHeight > $xHeadingHeight ) {
	  $y += $xSubHeadingHeight - $xHeadingHeight;
	  $x -= $this->triangle_opposite(90 - $this->xHeadingAngle%90,
					 ($xSubHeadingHeight - $xHeadingHeight));
	}
      }
      if( strlen($this->xHeading) ) {
	$params = $this->textParams( $this->xHeading, $this->headingSize,
				     $this->xHeadingAngle, $this->headingFont );
	if( $params[4] || $params[5] ) {
	  $spaces = $this->angledSpace($this->space,$this->xHeadingAngle);
	  if( $params[4] )
	    $x += $spaces[0];
	  if( $params[5] )
	    $y += ($this->xHeadingAngle <= 270)? $spaces[1] : -$spaces[1];
	}
	$y += $params[5];
	$x += ($this->xHeadingAngle <= 270)? $params[4] : -$params[4];
      }
      $this->printString( $this->xSubHeading, $x, $y,
			  $this->subHeadingSize,
			  $this->getColor($this->subHeadingColor),
			  $this->xHeadingAngle,
			  $this->subHeadingFont, TRUE, $tf );
      //
      //
      //
      //
      //
      //
      //
      // do
      // needs a new calculation here!
      // must account for fact that this won't necessarily be the correct
      // amount anymore... considering the fact that we have all different
      // possible outcomes between the length of heading and subheading and
      // their respective distances from xBase!
      $x_head_y = $y + $this->getStringHeight( $this->xSubHeading,
					       $this->subHeadingSize,
					       $this->xHeadingAngle,
					       $this->subHeadingFont );      
    }

    // draw layer names
    if( is_array($this->layerNames) ) {
      $d = 0;
      for($i=0; $i<count($this->layerNames); $i++) {
	if( strlen($this->layerNames[$i]) 
	    && $this->layers[$i]["settings"]["depth"] >= $this->labelSize ) {
	  $d += ceil($this->layers[$i]["settings"]["depth"]/2);
	  $b = ($d)? $d / $this->offsetRatio : 0;
	  $x = $this->xEndOffset + $this->space - $b;
	  $y = $this->centerStringY(
				    $this->yBaseOffset + $d,
				    $this->labelSize,
				    0,
				    $this->labelFont );
	  $this->printString( $this->layerNames[$i],$x,$y,
			      $this->labelSize,
			      $this->getColor($this->labelColor),
			      $this->layerLabelAngle,
			      $this->labelFont );
	  floor($d += $this->layers[$i]["settings"]["depth"]/2);
	}
      }
    }

    // draw graph title
    if( $this->graphTitle ) {
      $x = $this->centerStringX( $this->imageWidth/2, 
				 $this->titleSize, 
				 $this->graphTitle,
				 0, 
				 $this->titleFont );
      $y = $this->margin;
      $this->printString( $this->graphTitle, 
			  $x, 
			  $y, 
			  $this->titleSize, 
			  $this->getColor($this->titleColor), 
			  0, $this->titleFont );
    }
    // draw graph subtitle
    if( $this->graphSubtitle ) {
      if( $this->graphTitle ) {
	$y = $this->margin + $this->space 
	     + $this->getStringHeight( $this->graphTitle,
				       $this->titleSize,
				       0,
				       $this->titleFont );
      } else {
	$y = $this->margin;
      }
      $x = $this->centerStringX( $this->imageWidth/2, 
			       $this->subHeadingSize, 
			       $this->graphSubtitle,
			       0, 
			       $this->subHeadingFont );      
      $this->printString( $this->graphSubtitle,
			  $x,
			  $y,
			  $this->subHeadingSize,
			  $this->getColor( $this->titleColor ),
			  0, $this->subHeadingFont );
    }
    
  }

  function drawLayerGuides() {
    // draws the segments for layers
    // in the 3d section
    // called from drawguidelines()
    if( ($this->showXGuides || $this->showYGuides) && count($this->layers) > 1
	&& $this->graphDepth ) {
      $d = 0;
      $color = $this->getColor( $this->colorGraphBackground );
      for($i=0; $i<count($this->layers); $i++) {
	$d += $this->layers[$i]["settings"]["depth"];
	$y = $this->yBaseOffset + $d;
	$x1 = $this->xBaseOffset - $d/$this->offsetRatio;
	$x2 = $this->xEndOffset - $d/$this->offsetRatio;
	imageLine( $this->img,$x1,$y,$x2,$y,$color);		   
      }
    }
  }


  function drawPoint( $x, $y, $color, $type = '', $border = '' ) {
    // draws a point on a graph

    if( !$type )
      $type = $this->pointShape;
    if( $type && $this->pointSize > 0 ) {
      switch( strtolower(substr($type, 0, 3)) ) {
      case "squ":
        $this->drawSquare($x, $y, $color, 1 );
        break;
      case "tri":
        $this->drawTriangle($x, $y, $color, 1);
        break;
      case "box":
	$this->drawSquare($x,$y,$color,0);
	break;
      case "cir":
        $this->drawCircle($x, $y, $color);
        break;
      case "dia":
	$this->drawDiamond($x, $y, $color, 1);
        break;
      case "str":
        $this->drawStrike($x, $y, $color);
        break;
      case "plu":
        $this->drawPlus($x, $y, $color);
        break;
      case "das":
        $this->drawDash($x, $y, $color);
        break;
      case "bar":
        $this->drawBarPoint($x, $y, $color);
        break;
      default:
        $this->drawCircle($x, $y, $color, 1);
      }
      if( $border ) {
	switch( strtolower(substr($type, 0, 3)) ) {
	case "squ":
	  $this->drawSquare($x, $y, $border, 0 );
	  break;
	case "tri":
	  $this->drawTriangle($x, $y, $border, 0);
	  break;
	case "dia":
	  $this->drawDiamond($x, $y, $border, 0);
	  break;
	case "box":
	case "cir":
	case "str":
	case "plu":
	case "das":
	case "bar":
	  break;
	default:
	  $this->drawCircle($x, $y, $color, 0);
	}
      }
    }
  }

  function drawRectangle( $x1, $y1, $x2, $y2, $col, $filled = TRUE ) {
    // draws a rectangle, ensuring that the proper
    // x,y coords are used (in case we are drawing it
    // upside down or some other funky way
    if( $x1 > $x2 ) {
      $tmp = $x1;
      $x1 = $x2;
      $x2 = $tmp;
    }
    if( $y1 > $y2 ) {
      $tmp = $y1;
      $y1 = $y2;
      $y2 = $tmp;
    }
    $fxn = ($filled === TRUE)? "imagefilledrectangle" : "imagerectangle";
    return $fxn($this->img,$x1,$y1,$x2,$y2,$col);
  }

  function drawSlice( $xc, $yc, $w, $h,
		      $s, $e, $color, $depth = 0,
		      $chopS = FALSE, $chopE = FALSE ) {
    // creates a pie slice on the graph
    // 3d effect
    $this->shadeSlice($xc,$yc,$w,$h,$s,$e,$color,$depth,$chopS,$chopE);
    // create the slice
    $col = $this->getDataColor($color[0],$color[1]);
    $this->addDebug("drawSlice($xc,$yc,$w,$h,$s,$e,"
		    .(is_array($color)?join("/",$color):"n/a")
		    .",$depth,$chopS,$chopE)","drawing arc",2);
    imageFilledArc( $this->img,$xc,$yc,$w,$h,$s,$e,$col,IMG_ARC_PIE );    
  }

  function drawTicMarks() {
    // draw the tic marks
    // on the graph
    $xb  = $this->xBase;
    $xbo = $this->xBaseOffset;
    $xe  = $this->xEnd;
    $xeo = $this->xEndOffset;
    $xs  = $this->xStep;
    $yb  = $this->yBase;
    $ybo = $this->yBaseOffset;
    $ye  = $this->yEnd;
    $yeo = $this->yEndOffset;
    $ys  = $this->yStep;

    if( $this->ticLength && $this->showFrame ) {      
      $tl = ($this->ticLength == "full")? $this->graphWidth : $this->ticLength;
      for( $i=$yb-$ys; $i>= $this->yEnd; $i -= $ys ) {	
	imageLine( $this->img,
		   $xb,
		   $i,
		   $xb + $tl,
		   $i,
		   $cf );
      }
      $tl = ($this->ticLength == "full")? $this->graphHeight : $this->ticLength;
      for( $i=$xb+$xs; $i<= $this->xEnd; $i+= $xs ) {
        imageLine( $this->img,
                   $i,
                   $yb,
                   $i,
                   $yb - $tl,
                   $cf );
      }
    }
  }
  
  function drawValue( $x, $y, $value, $color, $horizontal=0 ) {
    // draws a data value on the graph at
    // the specified point
    // the color passed here is the non-allocated
    // color for this data element, if $this->valueFontColor
    // exists, it will override the color passed here
    $xv = $x;
    $yv = $y;
    if( $this->showValueOnGraph < 1 ) {
      return;
    }
    $valueFormatted = $this->formatData($value);

    // make determinations about where to put it
    list($xspan,$yspan,$lenght,$height,$xo,$yo) = 
      $this->textParams(
			$valueFormatted,
			$this->valueFontSize,
			$this->valueFontAngle,
			$this->font
			);
    if( $value < 0 ) {
      // less than zero, put it on zero axis
      if( $horizontal ) {
	$x = $this->xZero + $this->space + $this->depth;
      } 
      else {
	$y = $this->yZeroOffset - $yspan - $this->space - $this->depth;
      }
    }
    else {
      // greater than zero, put it on the top of the element
      if( $horizontal ) {
	$x = $xv - $this->space - $xspan;
      }
      else {
	$y = $yv + $this->space;
      }
    }
    // allocate the color
    $col = ($this->valueFontColor != null)?
      $this->getColor($this->valueFontColor) : $this->getColor($color);
    if( $this->valueFontColor == null || $col == $this->getColor($color) ) {
      if( $horizontal ) {
	$x += $this->space + $this->depth;
      }
      else {
	$y = $yv - ($this->space + $yspan + $this->depth);
      }
    }
    if( $y > $this->yBaseOffset )
      $y = $this->yBaseOffset - ($this->space + $yspan);
    // graph it already
    $this->printString( $valueFormatted, $x, $y, $this->valueFontSize,
			$col, $this->valueFontAngle, $this->font );   
    $this->addDebug("drawValue",
		    "x: $x, y: $y, formatted: "
		    ."$valueFormatted, original: $value", 3);
  }  

  function shadeBar( $x1, $y1, $x2, $y2, $color, $depth ) {
    // creates the 3d effect to appear behind a bar

  }

  function shadeColumn( $x1, $y1, $x2, $y2, $color, $depth, $hide_top = "" ) {
    // creates the 3d effect to appear behind a column
    if( $depth ) {
      $offset = $depth / $this->offsetRatio;
      if( !$hide_top ) {
	$topc = $this->getDataColor($color[0],$color[1],$this->shd(1,1,1,2));
	// draw the top of the column
	$points = array($x1,
			$y1,
			$x1+$offset,
			$y1-$depth,
			$x2+$offset,
			$y1-$depth,
			$x2,
			$y1);
	imageFilledPolygon( $this->img,
			    $points,
			    count($points)/2,
			    $topc );
      }
      $sidec = $this->getDataColor($color[0],$color[1],$this->shd(1,2,1,1));
      $points = array($x2,
		      $y1,
		      $x2+$offset,
		      $y1-$depth,
		      $x2+$offset,
		      $y2-$depth,
		      $x2,$y2);
      imageFilledPolygon( $this->img,
			  $points,
			  count($points)/2,
			  $sidec );
    }
  }
  
  function shadeLine( $x1, $y1, $x2, $y2, $color, $depth ) {
    // creates the 3d effect to appear behind
    // a line
    if( $depth ) {
      $offset = $depth / $this->offsetRatio;
      $col = $this->getDataColor($color[0],$color[1],$this->shd($y1,$y2,$x1,$x2));   
      $points = array(
		      $x1, $y1,
		      $x1+$offset, $y1-$offset,
		      $x2+$offset, $y2-$offset,
		      $x2, $y2
		      );
      imageFilledPolygon( $this->img, $points, count($points)/2, $col );
    }
  }

  function shadeSlice( $xc, $yc, $w, $h, $s, $e, $color, $depth = 0,
		       $chopS = FALSE, $chopE = FALSE ) {
    // creates the 3d effect to appear behind
    // a pie slice
    if( $depth <= 0 || $h == $w ) {
      return;
    }
    list($xs,$ys) = $this->ellipse_point($xc, $yc, $w, $h, $s);
    list($xe,$ye) = $this->ellipse_point($xc, $yc, $w, $h, $e);    
    // determine orientation of 3d effect
    if( $h > $w ) {
      // oriented to the right
      $col = $this->getDataColor($color[0],$color[1],
				 $this->shd(1,1,1,2));
      // set up the points for the two sides of the slice      
      $points1 = array(
		       $xc, $yc,
		       $xs, $ys,
		       $xs + $depth, $ys,
		       $xc + $depth, $yc );
      $points2 = array(
		       $xc, $yc,
		       $xe, $ye,
		       $xe + $depth, $ye,
		       $xc + $depth, $yc );
    } else {
      // oriented down
      $col = $this->getDataColor($color[0],$color[1],
				 $this->shd(1,2,1,1));
      $points1 = array(
		       $xc, $yc,
		       $xs, $ys,
		       $xs, $ys + $depth,
		       $xc, $yc + $depth );
      $points2 = array(
		       $xc, $yc,
		       $xe, $ye,
		       $xe, $ye + $depth,
		       $xc, $yc + $depth );
    }
    // draw the start side of slice
    if( !$chopS ) {
      imageFilledPolygon( $this->img,
			  $points1,
			  count($points1)/2,
			  $col );
    }
    if( $h > $w ) {
      // draw the arced portion horizontally
      for($i=$xc+$depth; $i>=$xc; $i--) {
	imagearc($this->img, $i, $yc, $w, $h, $s, $e, $col );
      }
    } else if( $h <= $w ) {
      // draw the arced portion vertically
      for($i=$yc+$depth; $i>=$yc; $i--) {
	imagearc($this->img, $xc, $i, $w, $h, $s, $e, $col );
      }
    }
    // draw the end side of slice
    if( !$chopE ) {
      imageFilledPolygon( $this->img,
			  $points2,
			  count($points2)/2,
			  $col );    
    }
  }

  /*
  **  TEXT METHODS
  */

  function centerString( $x, $y, $size, $text = '', $angle = 0, $font = '' ) {
    // determines what x/y coords to use to center the text
    // on the designated spot, both vertically and horizontally
    $xcoord = $this->centerStringX($x,$size,$text,$angle,$font);
    $ycoord = $this->centerStringY($y,$size,$text,$angle,$font);
    return array($xcoord,$ycoord);
  }
  
  function centerStringX( $x, $size, $text = '', $angle = 0, $font = '' ) {
    // determines what x coordinate to use to center the text
    // on the designated spot, horizontally
    if( strlen($text) ) {
      list($xspan,) = $this->textParams($text,$size,$angle,$font);
      $xcoord = $x - $xspan / 2;
      return $xcoord;
    } else {
      return $x;
    }
  }
  
  function centerStringY( $y, $size, $text = '', $angle = 0, $font = '' ) {
    // determines what y coordinate to use to center the text
    // on the designated spot, vertically
    if( strlen($text) ) {
      list($xspan,$yspan,) = $this->textParams($text,$size,$angle,$font);
      $ycoord = $y - $yspan / 2;
      $this->addDebug("centerStringY('$y','$size','$text','$angle','$font')",
		      "new y: $ycoord/".$this->dir_of($angle,'y'),3);
      return $ycoord;
    } else {
      $this->addDebug("centerStringY('$y','$size','$text','$angle','$font')",
		      "no text, y coord unchanged",2);
      return $y;
    }
  }

  function findLongestString( $vals = '', $flag = 0 ) {
    // takes an array and returns the longest
    // string from the arrays
    // if $flag is set, then it performs
    // formatData on them first (to add commas,etc)
    
    if( is_array($vals) ) {
      foreach($vals as $v) {
        if( is_array($v) )
          $num = $this->findLongestString($v,$flag);
        else
          $num = $v;
        if( strlen($num) > strlen($max) )
          $max = $num;
      }
      return $max;
    }
  }
  
  function formatData( $value = '', $flag = 0 ) {
    // formats data for (flag=0) display or for
    // (flag=1) use in functions
    
    if( strlen($value) ) {
      $value = preg_replace("[^0-9.-]", "", $value);
      if( !$flag && $this->dataFormat ) {
        preg_match("@^([A-Za-z]),([0-9])@$", $this->dataFormat,$matches);    
        $rnd = (strlen($matches[2]))? $matches[2] : 0;
        switch(strtoupper($matches[1])) {
          case "T":
            $value = numberFormat( $value/10, $rnd );
            break;
          case "H":
            $value = numberFormat( $value/100, $rnd );
            break;
          case "K":
            $value = numberFormat( $value/1000, $rnd );
            break;
          case "M":
            $value = numberFormat( $value/1000000, $rnd );
            break;
          case "B":
            $value = numberFormat( $value/1000000000, $rnd );
            break;
          case "A":
            $value = numberFormat( $value, $rnd );
        }
      }
      return $value;
    }
  }

  function angledSpace( $space, $angle ) {
    // returns x/y adjustments to create angled spacing effects
    if( $angle == 0 ) {
      $y = $space;
      $x = 0;
    } else if( $angle == 90 ) {
      $x = $space;
      $y = 0;
    } else if( $angle == 180 ) {
      $y = $space;
      $x = 0;
    } else if( $angle == 270 ) {
      $x = $space;
      $y = 0;
    } else {
      $a = $angle;
      while($a > 90) {
	$a -= 90;
      }
      $x = $this->triangle_adjacent($a,'',$space);
      $y = $this->triangle_opposite($a,'',$space);
    }
    $this->addDebug("angledSpace($space,$angle)","returning $x,$y",3);
    return array($x,$y);
  }

  function strHeight( $text = '', $size, $font = '' ) {
    // returns the height of letters in a string
    if( strlen($text) ) {
      list($xspan,$yspan,$l,$h) = $this->textParams($text,$size,0,$font);
      return $h;
    }
    return 0;
  }

  function strLength( $text = '', $size, $font = '' ) {
    // returns the width of letters in a string
    if( strlen($text) ) {
      list($xspan,$yspan,$l,$h) = $this->textParams($text,$size,0,$font);
      return $l;
    }
    return 0;
  }
  
  function getStringHeight( $text = '', $size, $angle = 0, $font = '' ) {
    // returns the height of a string of text on the y axis
    if( strlen($text) ) {
      list($x,$y,) = $this->textParams($text,$size,$angle,$font);
      return $y;
    }
    return 0;
  }

  function getStringWidth( $text = '', $size, $angle = 0, $font = '' ) {
    // returns width of a string of text on the x axis
    if( strlen($text) ) {
      list($x,) = $this->textParams($text,$size,$angle,$font);
      return $x;
    }
    return 0;
  }

  function textStart( &$x_val, &$y_val, $text = '', $size, $angle, 
		      $font = '', $adjust_x = TRUE, $adjust_y = TRUE ) {
    // provides adjustments to x,y coords for text
    // by calculating the text direction and length relative to 0
    // thus, by providing the x,y coords to start the text at assuming
    // 0 angle, this will compensate the text starting point print in
    // the same design space

    // save time if it's already 0, or we aren't allowing use of various angles
    if( !$this->ttfEnabled )
      return;
    if( !$adjust_x && !$adjust_y )
      return;
    // $box = array(0-$blx,1-$bly,2-$brx,3-$bry,4-$trx,5-$try,6-$tlx,7-$tly)
    $box = imagettfbbox( $size, $angle, $this->libDir."/fonts/$font", $text);
    // preset the adjustments
    $x = 0;
    $y = 0;
    for($i=2; $i<8; $i+=2) {
      $j = $i+1;
      if( $box[$i] < $x )
	$x = $box[$i];
      if( $box[$j] < $y )
	$y = $box[$j];
    }
    if( $adjust_x )
      $x_val -= $x;
    if( $adjust_y )
      $y_val -= $y;
    $this->addDebug("textStart('$text',$size,$angle,'$font')","adjusting $x,$y".
		    (is_array($box)? "/".join(",",$box):""),3);
  }
  
  function textParams( $text = '', $size, $angle = 0, $font = '' ) {
    // determines the width and height of the given string of text
    // returns them in an array( x, y, length, height, xoffset, yoffset )
    // where x and y are the x/y distances spanned (compensated for
    // angles) and length/height are actual pixel length/height of text
    // and xoffset/yoffset are the actual distances that a row of text would
    // need to be offset to appear on the next line beneath this one

    if( strlen($text) ) {
      if( $this->ttfEnabled ) {
        // set font to default if needed
        if( $font == "" )
          $font = $this->ttfDefault;
        // get the span of text from top to bottom, left to right
	$box = imagettfbbox( $size, $angle, $this->libDir."/fonts/$font", $text);
	list($x3,$y3,$x4,$y4,$x2,$y2,$x1,$y1) = $box;
	$this->addDebug("textParams('$text','$size','$angle',"
			.$this->libDir."/fonts/$font')",
			"bounding box: ".
			(is_array($box)? "/".join(",",$box):""),3);
        // find out the farthest left and right distances of the text
        for( $i=1; $i<5; $i++ ) {
          $x = "x$i";
          $y = "y$i";
          // compare our left positions
          if( $$x < $left || !strlen($left) )
            $left = $$x;
          // compare our right positions
          if( $$x > $right || !strlen($right) )
            $right = $$x;
          // compare our top positions
          if( $$y < $top || !strlen($top) )
            $top = $$y;
          // compare our bottom positions
          if( $$y > $bottom || !strlen($bottom) )
            $bottom = $$y;
        }
        // determine our coords
        $xspan = abs($right - $left);
        $yspan = abs($bottom - $top);
	list($xdir,$ydir) = $this->dir_of($angle);
	if( $ydir == 0 ) {
	  $length = abs($box[0] - $box[2]);
	} else if( $xdir == 0 ) {
	  $length = abs($box[1] - $box[3]);
	} else {
	  $length = hypot( abs($box[3]-$box[7]), abs($box[2]-$box[0]) );
	}
	if( $xdir == 0 ) {
	  $height = abs($box[2] - $box[0]);
	} else if( $ydir == 0 ) {
	  $height = abs($box[7] - $box[1]);
	} else {
	  $height = hypot( abs($box[6]-$box[0]), abs($box[7]-$box[1]) );
	}
	$xoffset = abs($box[0] - $box[6]);
	$yoffset = abs($box[1] - $box[7]);
      } else {
        $height = imagefontheight( $size );
        $length = imagefontwidth( $size ) * strlen($text);
        if( $angle > 0 ) {
          $xspan = $length;
          $yspan = $height;
	  $xoffset = 0;
	  $yoffset = $height;
        } else {
          $xspan = $height;
          $yspan = $length;
	  $xoffset = $height;
	  $yoffset = 0;
        }
      }
      return array($xspan,$yspan,$length,$height,$xoffset,$yoffset);
    }
    else {
      return array();
    }
  }

  function printString( $text = '', $x, $y, $size, 
			$color = '', $angle = 0, $font = '', 
			$adjust_x = TRUE, $adjust_y = TRUE ) {
    // print a string of text
    if( !$color )
      $color = $this->colorForeground;
    if( $this->ttfEnabled ) {
      return $this->ttfPrintString( $text, $x, $y, $size, $color, $angle, $font,
				    $adjust_x, $adjust_y );
    } else {
      if( $angle )
	return imageStringUp( $this->img, $size, $x, $y, $text, $color );
      else
	return imageString( $this->img, $size, $x, $y, $text, $color );
    }
  }

  function printBox( $text = '', $x, $y, $size, $color = '', $angle = 0, $font = '' ) {
    // print a box of text with word wrapping
    // returns x,y coordinates displaying size of the box
    if( !$color )
      $color = $this->colorForeground;
    if( $this->ttfEnabled ) {
      return $this->ttfPrintBox( $text, $x, $y, $size, $color, $angle, $font );      
    } else {
      // make it happen!
      //
      //
      //
      //
      // return the distance moved from $x,$y (size of box)
    }
  }

  function ttfPrintString( $text = '', $x, $y, $size, $color = '', $angle = 0, $font = '', $adjust_x = TRUE, $adjust_y = TRUE ) {
    // this function is called automatically through printString
    // if ttf is installed, then print a text
    // box using the installed font
    // $angle is a degree angle from 3 o'clock position
    if( !$font )
      $font = $this->ttfDefault;
    $fontfile = $this->libDir."/fonts/$font";
    if( file_exists($fontfile) ) {
      // compensate for text angles
      $this->textStart($x,$y,$text,$size,$angle,$font,$adjust_x, $adjust_y);
      $this->addDebug("ttfPrintString(".$this->img
		      .",$size,$angle,$x,$y,$color,$fontfile,$text)",$text,3);
      if( !$color ) { $color = $this->colorForeground; }
      imageTtfText( $this->img, $size, $angle, $x, $y, $color, $fontfile, $text );
    } else {
      $this->addDebug("ttfPrintString","fontfile: $fontfile not found, text skipped!",1);
    }
  }

  function ttfPrintBox( $text = '', $x, $y, $size, $angle = 0, $font = '' ) {
    // this function is called automatically through printBox
    // if ttf is installed, then print a text
    // box using the installed font
    // $angle is a degree angle from 3 o'clock position

    if( !$font )
      $font = $this->ttfDefault;
    $font = $this->libDir."/fonts/$font";
    // make it happen!
    //
    //
    //
    // return distance moved $x,$y (size of box)
  }

  /*
  **  SYSTEM CALCULATIONS
  */ 

  function averageData( $data ) {
    // takes a single list of data
    // and returns the average
    if( count($data) ) {
      for($i=0; $i<count($data); $i++) {
        $ttl += $data[$i];
      }
      return $ttl / count($data);
    } else {
      $this->addDebug("averageData", "zero length array passed, ignored", 2);
    }
  }

  function averageRows( $data ) {
    // combine all rows into 1 average
    // set and return those values
    if( count($data) ) {
      $res = $this->totalRows($data);
      for( $j=0; $j<count($res); $j++ ) {
      $res[$j] /= count($data);
      }
      return $res;
    } else {
      $this->addDebug("averageData", "zero length array passed, ignored", 2);
    }
  }

  function calculateBarWidth( $num, $step = '', $gap = '' ) {
    // determines the width of each bar
    // based on the number of data rows
    // the gap setting, and the step value
    // $rows is an array of data rows (and settings)
    // or an integer indicating how many bars are to
    // be shown together.

    if( !strlen($gap) ) 
      $gap = $this->gap;
    
    if( !$num )
      $num = 1;
    if( !$step )
      $step = $this->xStep - $gap;
    return( $step/$num );
  }
  
  function calculateParameters() {
    // determines any parameters which
    // have not been set by the user
    // ppp

    // total some layer values
    // graphDepth
    $this->graphDepth = 0;
    for($i=0; $i<count($this->layers); $i++) {
      $this->graphDepth += $this->layers[$i]["settings"]["depth"];
      if( count($this->layers) > 1 && $this->layers[$i]["settings"]["name"] )
	$this->layerNames[$i] = $this->layers[$i]["settings"]["name"];
      else if( count($this->layers) > 1 )
	$this->layerNames[$i] = "";
    }
    // graphOffset
    if( $this->graphDepth ) { 
      $this->graphOffset = ceil($this->graphDepth/$this->offsetRatio); 
    }
    else { $this->graphOffset = 0; }
    $this->currentDepth = $this->graphDepth;
    $this->currentOffset = $this->graphOffset;


    // determine ySubHeading if set to "auto"
    if( $this->ySubHeading == "auto" ) {
      if( $this->dataFormat ) {
        list($m,$n) = explode(",",$this->dataFormat);
        switch(strtoupper($m)) {
          case "B":
            $this->ySubHeading = "(in billions)";
            break;
          case "M":
            $this->ySubHeading = "(in millions)";
            break;
          case "K":
            $this->ySubHeading = "(x 1,000)";
            break;
          case "H":
            $this->ySubHeading = "(x 100)";
            break;
          case "T":
            $this->ySubtitle = "(x 10)";
            break;
          default:
            $this->ySubHeading = "";
            break;
        }
      } else {
         $this->ySubHeading = "";
      }
      $this->addDebug("calculateParameters", 
		      "ySubHeading auto: ".$this->ySubHeading,3);
    }

    // xMax
    if( !strlen($this->xMax) ) { $this->xMax = $this->getMaxCount($this->layers); }

    // xDiv
    if( !$this->xDiv ) { 
	$this->xDiv = (is_array($this->xLabels) && count($this->xLabels))?
	  count($this->xLabels) - 1 :
	  $this->xMax;
    }
    
    // xMin
    if( !strlen($this->xMin) ) { $this->xMin = 0; }
    
    // insure a non-zero graph range
    if( $this->xMax - $this->xMin == 0 ) { $this->xMax += 1; }
      
    // xNum
    if( !$this->xNum ) { $this->xNum = $this->xMax; }

    // xRange
    $this->xRange = abs($this->xMax - $this->xMin);

    // yMax
    if( !strlen($this->yMax) ) 
      { $this->yMax = ceil($this->findMaximum($this->layers)/10)*10; }

    // yMin
    if( !strlen($this->yMin) ) { 
      $this->yMin = $this->findMinimum( $this->layers );
      if( $this->yMin < 0 )
	$yMin = 0;
    }

    // check for zero range
    if( $this->yMax - $this->yMin == 0 ) { $this->yMax += 1; }
      
    // yRange
    $this->yRange = abs($this->yMax - $this->yMin);
      
    // yLabels
    if( !is_array($this->yLabels) ) {
      if( strlen(floor($this->yMax)) > 3 ) {
	$rnd = 0;
      } else if( strlen($this->yMax) > 1 
		 && strlen(floor($this->yMax)) <= 0 ) {
	$rnd = strlen($this->yMax) - 1;
      } else {
	$rnd = 1;
      }
      if( $this->yDiv )
        $n = $this->yDiv;
      else if( $this->imageHeight > 200  )
        $n = 10;
      else
        $n = 5;
      for( $i=0; $i<= $n; $i++ ) {
	if( $i == $n ) {
	  $num = $this->yMax;
	} else if( $i == 0 ) {
	  $num = $this->yMin;
	} else {
	  $num = $this->yRange / $n * $i + $this->yMin;
	}
	$num = round($num,$rnd);
	if( intval($num) == $num ) {
	  $num = intval($num);
	}
	$this->yLabels[] = $num;
      }        
      $this->addDebug("calculateParameters","Y labels auto calculated: "
		      .join(",",$this->yLabels),3);
    }

    // yDiv
    if( !$this->yDiv ) { 
      $this->yDiv = (is_array($this->yLabels) && count($this->yLabels) )? 
	count($this->yLabels)-1 : 
	$this->yMax;
    }

    // gap
    if( $this->gap < 0 ) { $this->gap = 0; }

    // margin and space
    if( $this->margin <= 0 ) { $this->margin = 1; }
    if( $this->space <= 0 ) { $this->space = ceil($this->margin / 2); }

    // determine label width and height
    $yl_width = $this->getStringWidth(
            $this->findLongestString( $this->yLabels ),
            $this->labelSize,
            $this->yLabelsAngle,
            $this->labelFont );
    if( $yl_width ) { $yl_width += $this->space; }
    $xl_height = $this->getStringHeight(
            $this->findLongestString( $this->xLabels ),
            $this->labelSize,
            $this->xLabelsAngle,
            $this->labelFont );
    if( $xl_height ) { $xl_height += $this->space; }
      
    // span left
    $this->spanLeft = $this->margin + $yl_width;
    if( $this->yHeading && $this->ySubHeading ) {
      $vals = $this->textParams(
				$this->yHeading,
				$this->headingSize,
				$this->yHeadingAngle,
				$this->headingFont);
      $spaces = $this->angledSpace($this->space,$this->yHeadingAngle);
      $h1 = $this->space + $this->getStringWidth(
				  $this->yHeading, 
				  $this->headingSize, 
				  $this->yHeadingAngle, 
				  $this->headingFont );
      $h2 = $spaces[0] + $vals[4] + 
	    $this->getStringWidth(
				  $this->ySubHeading,
				  $this->subHeadingSize,
				  $this->yHeadingAngle,
				  $this->headingFont );  
      $this->spanLeft += ($h2 > $h1)? $h2 : $h1;
      $this->spanLeft += $this->space;
    } else if( $this->yHeading ) {
      $this->spanLeft += $this->getStringWidth(
	     $this->yHeading, $this->headingSize, 
	     $this->yHeadingAngle, $this->headingFont ) + $this->space;
    } else if( $this->ySubHeading ) {
      $this->spanLeft += $this->getStringWidth(
		$this->ySubHeading, $this->subHeadingSize, 
		$this->yHeadingAngle, $this->subHeadingFont ) + $this->space;      
    }
    if( $this->showFrame )
      $this->spanLeft += $this->frameThickness;
    if( isset($this->marginOffsets["left"]) )
      $this->spanLeft += $this->marginOffsets["left"] + $this->space;

    // span right
    if( $this->graphWidth ) {
      $this->spanRight = $this->imageWidth - $this->spanLeft - $this->graphWidth;
    } else {
      // make margin and room for 3d effect
      $this->spanRight = $this->margin + $this->graphOffset;
      // make room for y2 labels
      if( $this->y2Labels ) {
          $y2l_width = $this->getStringWidth(
                  $this->findLongestString( $this->y2Labels ),
                  $this->labelSize,
                  $this->y2LabelsAngle,
                  $this->labelFont );
          if( $y2l_width ) { $y2l_width += $this->space; }
          $this->spanRight += $y2l_width + $this->frameThickness;
      }
      // make room for layer names
      if( is_array($this->layerNames) ) {
	$w = $this->getStringWidth(
			$this->findLongestString($this->layerNames),
			$this->labelSize,
			$this->layerLabelAngle,
			$this->labelFont );
	$this->spanRight += $w;
     }
      // make room for legend
      if( isset($this->marginOffsets["right"]) )
        $this->spanRight += $this->marginOffsets["right"]+$this->space;
    }
    
    // spanTop
    $this->spanTop = $this->margin + $this->graphDepth;
    if( $this->graphTitle ) {
      $ht = $this->getStringHeight($this->graphTitle,
				   $this->titleSize,
				   0,
				   $this->titleFont
				   ) + $this->margin;
      $this->addDebug("configureParameters", "graphTitleHeight figured at $ht",3);
      $this->spanTop += $ht;
    }
    if( $this->graphSubtitle ) {
      $ht = $this->getStringHeight($this->graphSubtitle,
				   $this->subHeadingSize,
				   0,
				   $this->subHeadingFont ) + $this->space;
      $this->addDebug("configureParameters","graphSubtitleHeight figured at $ht",3);
      $this->spanTop += $ht;
    }
    if( isset($this->marginOffsets["top"]) )
      $this->spanTop += $this->space + $this->marginOffsets["top"];

    // spanBottom
    $this->spanBottom = $this->margin + $xl_height;
    if( $this->showFrame )
      $this->spanBottom += $this->frameThickness;
    $xh = 0;
    if( strlen($this->xHeading) && strlen($this->xSubHeading) ) {
      $vals = $this->textParams(
				$this->xHeading,
				$this->headingSize,
				$this->xHeadingAngle,
				$this->headingFont);
      $spaces = $this->angledSpace($this->space,$this->xHeadingAngle);
      $y1 = $this->space + $this->getStringHeight( $this->xHeading,
						   $this->headingSize,
						   $this->xHeadingAngle,
						   $this->headingFont );      
      $y2 = $spaces[0] + $vals[5] + $this->getStringHeight( $this->xSubHeading,
						   $this->subHeadingSize,
						   $this->xHeadingAngle,
						   $this->subHeadingFont );
      $xh = ($y2 > $y1)? $y2 : $y1;
      $xh += $this->space;
    } else if( strlen($this->xHeading) ) {
      $xh = $this->space + $this->getStringHeight( $this->xHeading,
						   $this->headingSize,
						   $this->xHeadingAngle,
						   $this->headingFont );
    } else if( strlen($this->xSubHeading) ) {
      $xh = $this->space + $this->getStringHeight( $this->xSubHeading,
						   $this->subHeadingSize,
						   $this->xHeadingAngle,
						   $this->subHeadingFont );
    }
    $this->spanBottom += $xh;
    if( $this->showDataTable )
      $this->spanBottom += $this->space + $this->dataTableHeight;
    if( $this->marginOffsets["bottom"] )
      $this->spanBottom += $this->space + $this->marginOffsets["bottom"];
    if( $this->showFrame ) {
      $this->spanBottom += $this->frameThickness;
    }

    // xBase
    $this->xBase = $this->spanLeft + 1;

    // xEnd
    $this->xEnd = $this->imageWidth - $this->spanRight - 1;

    // yEnd
    $this->yEnd = $this->spanTop + 1;

    // yBase
    $this->yBase = $this->imageHeight - $this->spanBottom - 1;
        
    // graphHeight
    $this->graphHeight = $this->yBase - $this->yEnd;
      
    // graphWidth
    $this->graphWidth = $this->xEnd - $this->xBase;
        
    // xScale
    $this->xScale =  $this->graphWidth / $this->xRange;
    
    // xStep
    $this->xStep = $this->calculateStep($this->xDiv);
    
    // xZero
    $this->xZero = ($this->xMin < 0)? 
      $this->xBase - $this->xMin * $this->xScale : $this->xBase;
         
    // yNum
    $this->yNum = $this->graphHeight;
     
    // yStep
    $this->yStep = $this->calculateStep( $this->yDiv, 'y' );
      
    // yScale
    $this->yScale = $this->graphHeight / $this->yRange;

    // y2params
    if( is_array($this->y2Labels) ) {
      $y2min = $this->y2Labels[0];
      $n = count($this->y2Labels)-1;
      $y2max = $this->y2Labels[$n];
      $this->y2Range = abs($y2max - $y2min);
      if( $this->y2Range > 0 )
	$this->y2Scale = $this->graphHeight / $this->y2Range;
      else
	$this->y2Scale = 0;
    }

    // yZero
    $this->yZero = ($this->yMin < 0)?
      $this->yBase + $this->yMin * $this->yScale : $this->yBase;

    // y2Div and y2Step
    if( is_array($this->y2Labels) ) {
      if( !$this->y2Div ) {
	$this->y2Div = count($this->y2Labels)-1;
      }
      $this->y2Step = $this->graphHeight / $this->y2Div;
    }
    
    // offset params
    $this->xBaseOffset = $this->xBase + $this->graphOffset;
    $this->xEndOffset  = $this->xEnd + $this->graphOffset;
    $this->xZeroOffset = $this->xZero + $this->graphOffset;
    $this->yBaseOffset = $this->yBase - $this->graphDepth;
    $this->yEndOffset  = $this->yEnd - $this->graphDepth;
    $this->yZeroOffset = $this->yZero - $this->graphDepth;

    $this->addDebug("calculateParameters",
		    "<ul>"
		    ."gap: "        .$this->gap         ."<br>\n"
		    ."graphDepth: " .$this->graphDepth  ."<br>\n"
		    ."graphHeight: ".$this->graphHeight ."<br>\n"
		    ."graphOffset: ".$this->graphOffset ."<br>\n"
		    ."graphWidth: " .$this->graphWidth  ."<br>\n"
		    ."margin: "     .$this->margin      ."<br>\n"
		    ."space: "      .$this->space       ."<br>\n"
		    ."spanLeft: "   .$this->spanLeft    ."<br>\n"
		    ."spanRight: "  .$this->spanRight   ."<br>\n"
		    ."spanTop: "    .$this->spanTop     ."<br>\n"
		    ."spanBottom: " .$this->spanBottom  ."<br>\n"
		    ."xBase: "      .$this->xBase       ."<br>\n"		    
		    ."xBaseOffset: ".$this->xBaseOffset ."<br>\n"
		    ."xDiv: "       .$this->xDiv        ."<br>\n"
		    ."xEnd: "       .$this->xEnd        ."<br>\n"
		    ."xEndOffset: " .$this->xEndOffset  ."<br>\n"
		    ."xMax: "       .$this->xMax        ."<br>\n"
		    ."xMin: "       .$this->xMin        ."<br>\n"
		    ."xNum: "       .$this->xNum        ."<br>\n"
		    ."xRange: "     .$this->xRange      ."<br>\n"
		    ."xScale: "     .$this->xScale      ."<br>\n"
		    ."xStep: "      .$this->xStep       ."<br>\n"
		    ."xZero: "      .$this->xZero       ."<br>\n"
		    ."xZeroOffset: ".$this->xZeroOffset ."<br>\n"
		    ."yBaseOffset: ".$this->yBaseOffset ."<br>\n"
		    ."yBase: "      .$this->yBase       ."<br>\n"		    
		    ."yDiv: "       .$this->yDiv        ."<br>\n"
		    ."yEnd: "       .$this->yEnd        ."<br>\n"
		    ."yEndOffset: " .$this->yEndOffset  ."<br>\n"
		    ."yMax: "       .$this->yMax        ."<br>\n"
		    ."yMin: "       .$this->yMin        ."<br>\n"
		    ."yNum: "       .$this->yNum        ."<br>\n"
		    ."yRange: "     .$this->yRange      ."<br>\n"
		    ."yScale: "     .$this->yScale      ."<br>\n"
		    ."yStep: "      .$this->yStep       ."<br>\n"
		    ."yZero: "      .$this->yZero       ."<br>\n"
		    ."yZeroOffset: ".$this->yZeroOffset ."<br>\n"
		    .((is_array($this->y2Labels))?
		     "y2Scale: "    .$this->y2Scale     ."<br>\n"
		    ."y2Div: "      .$this->y2Div       ."<br>\n"
		    ."y2Range: "    .$this->y2Range     ."<br>\n"
		    ."y2Step: "     .$this->y2Step      ."<br>\n"
		      : "")
		    ."</ul>",
		    3);
  }

  function calculateStep( $div, $xy = 'x' ) {
    // calculate the numeric step of the graph
    // for the given number of divisions
    if( $xy == 'x' ) {
      return $this->graphWidth / $div;
    } else {
      return $this->graphHeight / $div;
    }
  }

  function checkRange( $val, $xy = 'y', $offset = 0 ) {
    // checks a value on it's appropriate axis
    // to insure that it isn't over/under the allowed
    // (fits on the chart)
    $tf = preg_match("@\!@", $xy);
    if( $tf ) {
      $xy = preg_replace("@[^xy]@", "", $xy);
    }
    if( $xy == "y" ) {
      $start = $this->yEnd - $offset/2;
      $end = $this->yBase - $offset/2;
    } else if( $xy == "x" ) {
      $start = $this->xBase + $offset;
      $end = $this->xEnd + $offset;
    }
    if( $tf ) {
      if( $val < $start )
	return false;
      else if( $val > $end )
	return false;
      else
	return true;
    }
    if( $val < $start )
      return $start;
    else if( $val > $end )
      return $end;
    else
      return $val;
  }

  function ellipse_point( $xc, $yc, $w, $h, $angle ) {
    // returns x,y coords of elipse point
    $x = $w/2 * cos(2*M_PI - $angle*M_PI/180) + $xc;
    $y = $yc - $h/2 * sin(2*M_PI - $angle*M_PI/180);
    $this->addDebug("ellipse_point($xc,$yc,$w,$h,$angle)","returning $x,$y",3);
    return array($x,$y);
  }

  function findMaximum( $data, $flag = 0, 
			$recursing = FALSE ) {
    // returns the maximum value 
    // from the given array
    // can also be a complex array
    // flag = 1: these are values
    // otherwise, assumed to be the
    // layers array
    if( $flag ) {
      for($i=0; $i<count($data); $i++) {
	if( !isset($max) || (isset($data[$i]) && $data[$i] > $max) ) {
	  $max = $data[$i];
	}
      }
    } else {
      for($i=0; $i<count($data); $i++) {
	for($j=0; $j<count($data[$i]["data"]); $j++) {
	  $num = $this->findMaximum($data[$i]["data"][$j],1,TRUE);
	  if( !isset($max) || (isset($num) && $num > $max) )
	    $max = $num;
	}
      }
    }
    if( !$recursing )
      $this->addDebug("findMaximum($data,$flag)", "returning max: $max", 3);
    return $max;
  }

  function findMinimum( $data, $flag = 0,
			$recursing = FALSE ) {
    // returns the minimum value 
    // from the given array
    // can also be a complex array
    // flag = 1: these are values
    // otherwise, assumed to be the
    // layers array
    if( $flag ) {
      for($i=0; $i<count($data); $i++) {
	if( !isset($min) || (isset($data[$i]) && $data[$i] < $min) ) {
	  $min = $data[$i];
	}
      }
    } else {
      for($i=0; $i<count($data); $i++) {
	for($j=0; $j<count($data[$i]["data"]); $j++) {
	  $num = $this->findMinimum($data[$i]["data"][$j],1);
	  if( !isset($min) || (isset($num) && $num < $min) )
	    $min = $num;
	}
      }
    }
    if( !$recursing )
      $this->addDebug("findMinimum($data,$flag)", "returning min: $min", 3);
    return $min;
  }
  
  function getMaxCount( $data, $flag = 0 ) {
    // cycle through an array, find the data
    // sets, and determine the longest data
    // set, return that count
    $max = 0;
    if( $flag ) {
      foreach($data as $k=>$v) {
	if( count($v) > $max ) {
	  $max = count($v);
	}
      }
    } else {
      foreach($data as $k=>$v) {
	$count = 0;
	if( $k === "data" ) {
	  $count = $this->getMaxCount($v , 1);
	} else if( "$k" != "settings" && "$k" != "config" && is_array($v) ) {
	  $count = $this->getMaxCount($v, 0);
	}
	if( $count > $max )
	  $max = $count;
      }
    }
    $this->addDebug("getMaxCount($data,$flag)", "returning count $max", 3);    
    return $max;
  }

  function dir_of( $angle, $xy = '' ) {
    // determines whether an angle
    // points left or right/up or down
    // returns x,y array containing:
    //  -1 left/down
    //   0 on axis
    //   1 right/up
    // if $xy is set to "x" or "y", then
    // only that value will be returned,
    // rather than an array
    while( $angle > 360 )
      $angle -= 360;
    while( $angle < 0 )
      $angle += 360;
    if( $angle > 90 && $angle < 270 )
      $x = -1;
    else if( $angle == 90 || $angle == 270 )
      $x = 0;
    else
      $x = 1;
    if( $angle > 180 )
      $y = -1;
    else if( $angle == 180 || $angle == 0 )
      $y = 0;
    else
      $y = 1;
    $this->addDebug("dir_of($angle)","$x/$y",3);
    if( $xy == "x" )
      return $x;
    else if( $xy == "y" )
      return $y;
    else
      return array($x,$y);
  }

  function scaleX( $value ) {
    // creates an x axis value based
    // on data value and xScale
    $this->addDebug("scaleX($value)/".$this->xScale,$value*$this->xScale,3);
    return $value * $this->xScale;
  }

  function scaleY( $value, $y2tf = false ) {
    // creates an y axis value based on
    // data value and yScale
    // and relative to $base
    $newval = ($y2tf && $this->y2Scale > 0)? 
      $this->y2Scale*$value : $this->yScale*$value;
    $this->addDebug("scaleY","y2tf:$y2tf, value:$value/$newval",3);
    return $newval;
  }

  function totalRows( $data ) {
    // combine all rows into 1 
    // totalling their values
    if( count($data) ) {
      for( $i=0; $i<count($data); $i++ ) {
        for($j=0; $j<count($data[$i]); $j++) {
	  if( !isset($res[$j]) )
	    $res[$j] = 0;
          $res[$j] += $data[$i][$j];
        }
      }
      return $res;
    } else {
      $this->addDebug("totalRows", "zero length array passed, ignored", 2);
    }
  }

  function triangle_side( $l1 = '', $l2 = '', $hypot = '' ) {
    // hyp^2 = l1^2 + l2^2
    if( $l1 && $l2 ) {
      return sqrt($l1*$l1 + $l2*$l2);
    } else if( $l1 || $l2 && $hypot ) {
      $x = ($l1)? $l1 : $l2;
      return sqrt( $hypot*$hypot - $x*$x );
    }
  }

  function triangle_adjacent( $angle, $opposite = '', $hypotenuse = '' ) {
    // adjacent = hypotenuse * cos
    // adjacent = opposite / tangent
    $a = deg2rad($angle);
    if( $opposite )
      return $opposite / tan($a);
    else if( $hypotenuse )
      return $hypotenuse * cos($a);
  }

  function triangle_opposite( $angle, $adjacent = '', $hypotenuse = '' ) {
    // opposite = tangent * adjacent
    // opposite = sin * hypotenuse
    $a = deg2rad($angle);
    if( $adjacent )
      return tan($a) * $adjacent;
    else if( $hypotenuse )
      return sin($a) * $hypotenuse;
  }

  function triangle_hypotenuse( $angle, $adjecent = '', $opposite = '' ) {
    // hypotenuse = adjacent / cos
    // hypotenuse = opposite / sin
    $a = deg2rad($angle);
    if( $adjacent )
      return $adjacent / cos($a);
    else if( $opposite )
      return $opposite / sin($a);
  }

  /*
  **  COLOR METHODS
  */

  function allocateColor( $val = '' ) {
    // creates a color for use
    // the first one created must be
    // the background color
    
    if( $val && !is_array($val) && !preg_match("@^[0-9]x[0-9]{2}[a-fA-F0-9]{6}$@",$val) ) {
      $val = $this->colorVals["$val"];
      if( !$val )
	$val = $this->colorForeground;
    } else if( !is_array($val) &&  preg_match("@^[0-9]x[0-9]{2}[a-fA-F0-9]{6}$@",$val) ) {
      return $val;
    }
    
    if( is_array($val) && count($val)==4 && $this->trueColorEnabled) {
      return imagecolorresolvealpha($this->img,$val[0],$val[1],$val[2],$val[3]);
    } else if( is_array($val) ) {
      return imagecolorallocate($this->img,$val[0],$val[1],$val[2]);      
    } else {
      $this->addDebug("allocateColor","Color [$val] could not be allocated!",1);
    }
  }

  function getColorVal( $color ) {
    // returns a preset color loaded from the current scheme
    if( isset($this->colorVals["$color"]) ) {
      return $this->colorVals["$color"];
    } else {
      $this->addDebug("getColorVal","color $color wasn't found in the currently loaded scheme, maybe you forgot to load a color scheme?",1);
    }
  }
  
  function getColor( $color, $mode = '', $override_transparency = '' ) {
    // returns the allocated index of the color to be
    // used... will create if not allocated
    // insure that this is a color to be used...
    // and that we don't need to set some special brush
    // $mode can be 'dark' or 'light' to create
    // 3d shading
    // $override_transparency will cause the transparency of this color
    // to be changed to whatever is specified. (use 0 to disable transparency)     
    if( !is_array($color) && preg_match("@^[a-zA-Z_0-9]+$@", $color) ) {
      $color = $this->getColorVal($color);
    } else if( !is_array($color) && preg_match("@^#([0-9a-fA-F]{6})(-[0-9a-fA-F]{2})?@", $color, $matches) ) {
      $color = $this->hex2dec($matches[1]);
      if( $matches[2] && $this->trueColorEnabled )
	$color[] = hexdec($matches[2]);
    }

    if( is_array($color) ) {
      if( $mode == "dark" ) {
	$color = $this->darken($color);
      } else if( $mode == "light" ) {
	$color = $this->lighten($color);
      }
      // overrride transparency functionality
      if( strlen($override_transparency) ) {
	$color[3] = $override_transparency;
      }

      // this is a normal color value, so
      // just check to see if it is allocated
      if( count($color) == 4 && $this->trueColorEnabled ) {
        $res = imageColorExactAlpha( $this->img, $color[0], $color[1], $color[2], $color[3] );
      } else {
        $res = imageColorExact( $this->img, $color[0], $color[1], $color[2] );
      }
    } else if( preg_match("@:@",$color) ) {
      // this is a special case, so
      // do something with it
      list($method,$val) = explode(":",$color);
      switch($method) {
        case "image":
          // do something
          // set $res
          break;
        case "style":
          // do something
          // set $res
          break;
      }
      //
      //
      //
      // also: look at how to darken/lighten these
      // 
      // also: look at how to use transparency (and override_transparency)
      //
      // also: look at how to specify default color
      //       in case this doesn't work
      //
    }
    // todo: should find something here to fix transparency with
    // override_transparency if we are using a straight hex
    // the color instead of an array 
    if( !strlen($res) ) {
      return $this->allocateColor( $color );
    } else {
      return $res;
    }
  }

  function darken( $val ) {
    // darkens a color by
    // a specified intensity
    $adj = 0 + floor($this->lightIntensity/2);
    $amt = ( $val[0] <= $adj && $val[1] <= $adj && $val[2] <= $adj )?
      $this->lightIntensity/2 : 0-$this->lightIntensity;
    for($i=0; $i<3; $i++) {
      $val[$i] += $amt;
      if( $val[$i] < 0 )
        $val[$i] = 0;
    }
    return $val;
  }

  function hex2dec( $color ) {
    // input is a hex value
    // returns r,g,b values
    $color = preg_replace("/[^0-9a-fA-F]/", "", $color);
    $r = hexdec(substr($color, 0, 2));
    $g = hexdec(substr($color, 2, 2));
    $b = hexdec(substr($color, 4, 2));
    return array($r, $g, $b);
  }

  function lighten( $val ) {
    // lightens a color by a 
    // specified intensity
    $adj = 255 - floor($this->lightIntensity/2);
    $amt = ( $val[0] >= $adj && $val[1] >= $adj && $val[2] >= adj )?
      0-$this->lightIntensity/2 : $this->lightIntensity;
     for($i=0; $i<3; $i++) {
       $val[$i] += $amt;
      if( $val[$i] > 255 )
        $val[$i] = 255;
    }
    return $val;
  }

  function getColorScheme( $name = 'default', $flag = '' ) {
    // returns a set of colors from a custom 
    // scheme file and stores them in a cache
    // for use by custom settings calls
    // setting flag returns just values... not an indexed array
    // this function removes anything equal to the graphBackground color

    // check for a transparency override
    // and make all colors transparent as
    // possible (if found)
    if( $name ) {
      $transparency = 0;
      $nm = $name;
      if( preg_match("@-([0-9]+)$@", $nm, $matches) ) {
	$nm = preg_replace("@-[0-9]+$@", "", $nm);
	$transparency = $matches[1];
      }
    }
    if( !$nm || !file_exists($this->libDir."/colors/$nm") ) {
      $this->addDebug("getColorScheme($name,$flag)",
		      "File, $nm, not found, returning default",1);
      $nm = "default";
    }
    // see if this scheme was loaded previously
    if( !$this->schemes["$name"] ) {
      $this->addDebug("getColorScheme($nm,$flag)","loading scheme into memory",3);
      $vals = file($this->libDir."/colors/$nm");
      $vars = array();
      $bgcd = (is_array($this->colorGraphBackground))? 
	$this->colorGraphBackground : $this->hex2dec($this->colorGraphBackground);
      $bgch = strtoupper("#".dechex($bgcd[0]).dechex($bgcd[1]).dechex($bgcd[2]));
      foreach($vals as $v) {
	// remove comments
	if( strlen(trim($v)) && !preg_match("@^#@", trim($v)) ) {
	  // check for syntax and process
	  if( preg_match("@=@",trim($v)) ) {
	    list($key,$val) = explode("=",trim($v));
	    $key = trim($key);
	    $val = trim($val);
	    $val = preg_replace("@(\n|\r)@", "", $val);
	    // make array for normal entries
	    if( preg_match("@,@",$val) ) {
	      $val = split(" *, *",trim($val));
	      // add the transparency
	      if( $transparency )
		$val[3] = $transparency;
	    } 
	    $valh = (is_array($val))? 
	      strtoupper("#".dechex($val[0]).dechex($val[1]).dechex($val[2]))
	      : $val;
	    if( $valh == $bgch ) {
	      $this->addDebug("getColorScheme",((is_array($val))?join(",",$val):$val)
			      ." skipped... same as graph background",3);
	    } else if( $flag || !$key ) {
	      $vars[] = $val;
	    } else {
	      $vars["$key"] = $val;
	    }
	  } else {
	    $this->addDebug("getColorScheme($name,$flag)",
			    "color file syntax error: $v is not a valid color",1);
	  }
        }
      }
      $this->schemes["$name"] = $vars;
    }
    return $this->schemes["$name"];
  }

  function getDataColor( $row, $col, $shade = '' ) {
    // retrieves a specific data color
    // for use.. from the dataColors array
    $old_row = $row;
    $old_col = $col;
    if( is_array($this->dataColors) ) {
      if( $row >= count($this->dataColors) && count($this->dataColors) > 0 )
	$row = $row % count($this->dataColors);
      if( count($this->dataColors[$row]) > 0 
	  && $col >= count($this->dataColors[$row]) )
	$col = $col % count($this->dataColors[$row]);
      $this->addDebug("getDataColor($old_row,$old_col,$shade)","returning $row,$col",3);
      if( is_array($this->dataColors[$row]) && $this->dataColors[$row][$col] ) {
	// color is established, so return it
	return $this->getColor($this->dataColors[$row][$col], $shade);
      }
    }
    // no colors match, so send the default
    $this->addDebug("getDataColor($old_row,$old_col,$shade)", "returning default!",2);
    return $this->getColor($this->colorGraphForeground, $shade);
  }

  function setDataColors( $colors = '', $flag = 0 ) {
    // prepares the array $this->dataColors with
    // a list of values according to the input
    // input can be an array of values, or the name
    // of a color scheme in the library
    if( $flag )
      unset($this->dataColors);
    if( is_array($colors) ) {
      $this->dataColors[] = $colors;
    } else if( strlen($colors) ) {
      $this->dataColors[] = $this->getColorScheme( $colors, 1 );
    } else {
      $this->dataColors[] = "";
    }
  }
  
  function setColorScheme( $scheme ) {
    // sets the current color scheme to the values
    // contained in the lib/colors file specified
    $this->colorVals = $this->getColorScheme($scheme);
  }

  function shd( $y1, $y2, $x1 = '', $x2 = '' ) {
    // determines whether the line should be drawn shaded
    // darker,lighter,or as is based on slope
    // or by all 4, y1,y2,x1,x2
    $s = 0;
    if( $y1 < $y2 )
      $s = -1;
    //if( $y2 > $y1 )
    else
      $s = 1;
    switch($s) {
    case -1:
      $m = "dark";
      break;
    case 1:
      $m = "light";
      break;
    default:
      $m = "";
    }
    return $m;
  }

  /*
  **  POINT TYPES
  */

  function drawTriangle( $x, $y, $color, $filled = '' ) {
    $y1 = $y - $this->pointSize / 2;
    $y2 = $y + $this->pointSize / 2;
    $x1 = $x - $this->pointSize / 2;
    $x2 = $x + $this->pointSize / 2;
    $c[] = $x;
    $c[] = $y1;
    $c[] = $x1;
    $c[] = $y2;
    $c[] = $x2;
    $c[] = $y2;
    
    if( $filled ) {
      ImageFilledPolygon( $this->img,
        $c,
        count($c)/2,
        $color );
    } else {
      ImagePolygon( $this->img,
        $c,
        count($c)/2,
        $color );     
    }
  }

  function drawSquare( $x, $y, $color, $filled = '' ) {
    $sz = $this->pointSize / 2;
    $x1 = $x - $sz;
    $x2 = $x + $sz;
    $y1 = $y - $sz;
    $y2 = $y + $sz;
    if( $filled ) {
      $this->drawRectangle( $x1, $y1, $x2, $y2, $color );
    } else {
      $this->drawRectangle( $x1, $y1, $x2, $y2, $color, FALSE );     
    }
  }

  function drawGradientSquare( $x, $y, $colors, $bordercolor ) {
    // draws a square bullet with a gradient fill
    // colors should be sent raw... they will be indexed here!
    $sz = $this->pointSize/2;
    // boundaries
    $x1 = $x - $sz;
    $x2 = $x + $sz;
    $y1 = $y - $sz;
    $y2 = $y - $sz;
    // set interval
    $step = ($x2 - $x1 + 1) / count($colors);
    // loop through x values
    $i=0;
    for($xc = $x1; $xc <= $x2; $xc+=$step) {
      $this->drawRectangle( $xc, $y1, $xc+$step, $y2, $this->getColor($colors[$i]) );
      $i++;
    }
    // border the bullet
    $this->drawSquare($x,$y,$this->getColor($bordercolor));
  }
  
  function drawCircle( $x, $y, $color, $filled = 0 ) {
    $rad = $this->pointSize;
    if( $filled ) {
      ImageFilledArc( $this->img,
		      $x,    //xcenter
		      $y,    //ycenter
		      $rad,  //width
		      $rad,  //height
		      0,
		      360,
		      $color,
		      IMG_ARC_PIE );
    } else {
      ImageArc( $this->img,
		$x,    //xcenter
		$y,    //ycenter
		$rad,  //width
		$rad,  //height
		0,
		360,
		$color );
    }
  }
  
  function drawDiamond( $x, $y, $color, $filled = '' ) {
    $y1 = $y - $this->pointSize / 2;
    $y2 = $y + $this->pointSize / 2;
    $x1 = $x - $this->pointSize / 2;
    $x2 = $x + $this->pointSize / 2;
    $c[] = $x;
    $c[] = $y1;
    $c[] = $x1;
    $c[] = $y;
    $c[] = $x;
    $c[] = $y2;
    $c[] = $x2;
    $c[] = $y;    
    if( $filled ) {
      ImageFilledPolygon( $this->img,
        $c,
        count($c)/2,
        $color );
    } else {
      ImagePolygon( $this->img,
        $c,
        count($c)/2,
        $color );     
    }
  }
  
  function drawStrike( $x, $y, $color, $filled = '' ) {
    $s = $this->pointSize / 2;
    $x1 = $x - $s;
    $x2 = $x + $s;
    $y1 = $y - $s;
    $y2 = $y + $s;
    ImageLine( $this->img, $x1, $y1, $x2, $y2, $color );
    ImageLine( $this->img, $x2, $y1, $x1, $y2, $color );
  }
  
  function drawPlus( $x, $y, $color, $filled = '' ) {
    $s = $this->pointSize / 2;
    $x1 = $x - $s;
    $x2 = $x + $s;
    $y1 = $y - $s;
    $y2 = $y + $s;
    ImageLine( $this->img, $x1, $y, $x2, $y, $color );
    ImageLine( $this->img, $x, $y1, $x, $y2, $color );   
  }
  
  function drawBarPoint( $x, $y, $color, $filled = '' ) {
    $s = $this->pointSize / 2;
    $y1 = $y - $s;
    $y2 = $y + $s;
    ImageLine( $this->img, $x, $y1, $x, $y2, $color );
  }
  
  function drawDash( $x, $y, $color, $filled = '' ) {
    $s = $this->pointSize / 2;
    $x1 = $x - $s;
    $x2 = $x + $s;
    ImageLine( $this->img, $x1, $y, $x2, $y, $color );
  }
  
  /*
  **  INVOKE
  */
  
  function zenGraph( $settings ) {
    // invoke the options and configure
    // some settings.. $settings can be
    // the full path to a configuration file
    // or it can be an array of settings to
    // be configured

    $this->configureSettings( $settings );
    $this->defaultSettings = $settings;

    // courtesy check for user error
    if( $this->valueFontSize < 1 )
      $this->valueFontSize = 1;

    $this->addDebug("zenGraph($settings)","INVOKED!",3);    
  }

  /*
  **  VARIABLE SETTINGS
  */
  
  var $debug;             // current debug level
  var $libDir;            // directory of the zenGraph library
  var $img;               // the image handle
  var $outputDirectory;   // if this is specified, then zenGraph
                          // will output a file... otherwise, it
                          // sends the output to stdout
                          
  var $currentLayer;      // the current layer being processed
  var $currentDepth = 0;  // the depth of our current layer
  var $currentOffset = 0; // the offset of the current layer
  var $user_settings;     // array of settings that can be altered by
                          // the user

  var $schemes;           // schemes loaded into memory
                                                   
  var $showDataTable = 0; // set to 1 if addDataTable() is used
  var $tableData;         // array set for tables

  //
  // PAGE SETTINGS
  //

  // page attributes
  var $imageType;
  var $trueColorEnabled;  // 0 or 1, uses alpha blending... requires 
                          // GD 2.0.1 or greater and php 4.0.6 or greater
                          // disable this if no transparent layers will be used
                          // because it uses unneccessary system overhead
  var $imageHeight;
  var $imageWidth;
  var $colors;            // the colors allocated by the image
  var $layers;            // the array of layers to be created
  var $layerNames;        // the names of the layers
  var $defaultSettings;   // the original settings input by user
  var $transparency;      // affects the transparency of the graph (can be changed on each layer)
                          // only used if trueColorEnabled = 1
  
  var $graphHeight;       // height of the charted portion
  var $graphWidth;        // width of the charted portion
  var $graphDepth;        // depth of the charted portion (total of all layer depths)
  var $graphOffset;       // the 3d offset caused by graphDepth
  var $graphType;         // type of graph (line,bar,column,pie,area,scatter)
  
  var $spanTop;           // space between top of image and top of graph (where title and such appear)
  var $spanBottom;        // space between bottom of graph and base of image (where data table appears)
  var $spanLeft;          // space between edge of image and left edge of graph
  var $spanRight;         // space between edge of image and right edge of graph

  var $graphFrame;        // 0 or 1, determines if frame is visible
  var $graphGuides;       // 0 or 1, determines if the guides are visible
  
  var $currentXOffset;     // the current x offset due to layer depth
  var $currentYOffset;     // the current y offset due to layer depth

  // dimensions
  var $frameThickness; // thickness for frame elements
  var $ticLength;      // tick mark length
  var $gap;             // space between bars/columns
  var $lineThickness;   // thickness of charted lines
  var $margin;          // width of margins
  var $space;           // 1/2 margin width
  var $xBase;   // the location of the base of the chart
  var $xDiv;    // the number of labelled divisions on the x axis
  var $xMax;    // the highest value on the x axis
  var $xMin;    // the lowest value on the x axis
  var $xNum;    // the number of x segments to graph
  var $xRange;  // the distance from xMin to xMax
  var $xScale;  // the length of each segment on x axis
  var $xStep;   // the number of pixels in each xDiv
  var $xZero;   // the location of the x value of zero
  var $yBase;   // the location of the left edge of the chart
  var $yDiv;    // the number of labelled divisions on the y axis
  var $y2Div;   // number of label divisions on y2 axis
  var $yMax;    // the highest value on the y axis
  var $y2Max;   // the highest value on the y2 axis
  var $yMin;    // the lowest value on the y axis
  var $yNum;    // the number of segments on the y axis
  var $yRange;  // the distance from yMin to yMax
  var $y2Range; // the distance from y2min to y2max
  var $yScale;  // the length of each segment on y axis
  var $y2Scale; // the length of each segment of y2 axis
  var $yStep;   // the number of pixels in each xDiv
  var $yZero;   // the location of the y value of zero

  // text settings
  var $dataFormat;          // the numeric format to show data
                            // T[,x],H[,x],K[,x]|M[,x]|B[,x]|A[,x]
                            // (tens,hundreds,thousands,millions,billions,actual[leave as is])
                            // where x is the number of decimals (if left off, defaults to zero)
                            // example: "K,2' would truncate to thousands, plus 2 decimals (2.02 thousand)
                            // "M" would truncate to millions, zero decimals (412 million)
                            // if blank, the system will not format number or limit decimal digits
  var $fontSize;            // size of plain text, in pixels with TTF, otherwise an integer
  var $font;                // used only with TTF, this is the font to display
  var $labelSize;           // size of label text, in pixels with TTF, otherwise an integer
  var $labelFont;           // used only with TTF, this is the font to display
  var $headingSize;         // size of x/y headings, in pixels with TTF, otherwise an integer
  var $headingFont;         // used only with TTF, this is the font to display
  var $subHeadingSize;      // size of subheading
  var $subHeadingFont;      // font for subheading
  var $titleSize;           // size of the graph title, in pixels with TTF, otherwise an integer
  var $titleFont;           // used only with TTF, this is the font to display
  
  var $ttfEnabled;          // 0 or 1, tells whether TTF support is enabled
  var $ttfDefault;          // the default TTF font to use
  
  var $graphTitle;          // graph title
  var $graphSubtitle;       // graph subtitle
  var $xHeading;            // title of x axis
  var $xSubHeading;         // subtitle of x axis
  var $xHeadingAngle;       // also for xSubHeading
  var $yHeading;            // title of y axis
  var $ySubHeading;         // subtitle of y axis
  var $yHeadingAngle;       // also for ySubHeading
  var $headingColor;        // color of heading
  var $subHeadingColor;     // color of subheading
  var $xLabelsAngle;        // if using TTF, this is the angle to display the x axis labels at
  var $xLabelsCentered;     // control centering of x labels on page
  var $yLabelsAngle;        // if using TTF, this is the angle to display the y axis labels at
  var $y2LabelsAngle;       // if using TTF, this is the angle to display the y2 axis labels at  var $layerLabelAngle;     // angle of layer names

  // colors settings
  var $colorBackground;      // color of the image background
  var $colorForeground;      // color of the image forground
  var $colorScheme;          // the default color settings
  var $colorVals;            // array containing indexed lists of colors
  var $dataColors;           // colors to use for current data array
  var $colorGraphBackground; // background of charted portion
  var $colorGraphForeground; // color of text on graph portion

  // 3d elements
  var $depth;                // depth of the graph or layer
  var $offset;               // the offset value of the 3d effect
  var $lightIntensity;       // the intensity of shadows and highlights
  var $offsetRatio;          // ratio of width to height for 3d effect

  var $xBaseOffset;     // the xBase offset for depth
  var $xEndOffset;      // the xEnd offset for depth
  var $yBaseOffset;     // the yBase offset for depth
  var $yEndOffset;      // the yEnd offset for depth
  var $xZeroOffset;     // the xZero offset for depth
  var $yZeroOffset;     // the yZero offset for depth


  // graphed values
  var $showValueOnGraph;  // whether we display a value on the graph
  var $valueFontSize;     // size of plotted values
  var $valueFontAngle;    // angle of plotted values
  var $valueFontColor;    // color of plotted values

  // data table properties
  var $dataTableWidth;       // determined by system
  var $dataTableHeight;      // determined by system

  // legend system properties
  var $showLegend = 0;    // set to 1 if addLegend() is used
  var $legendData;        // array set for legends
  var $legendRows;           // number of rows in the legend (not be used in settings!)
  var $legendTW = 0;         // total width of all legends that aren't floating
  var $legendTH = 0;         // total height of all legends that aren't floating
  var $marginOffsets;        // array used in calculations for setting margins and spans

  // legend configurable properties
  var $legendColumns;        // number of columns in a legend
  var $legendWidth;          // width of the legend (defined by system)
  var $legendHeight;         // height of the legend (defined by system)
  var $legendStartX;         // x axis starting point
  var $legendStartY;         // y axis starting point
  var $legendTransparency;
  var $legendFontSize;
  var $legendFontFace;
  var $legendFontAngle;
  var $legendPointShape;
  var $legendPointSize;
  var $legendBackgroundColor;
  var $legendForegroundColor;
  var $legendBorderThickness;
  var $legendBorderColor;
  var $legendTitle;
  var $legendFloat;          // causes legend to float over image
  var $legendLocation;       // array(x,y) or a string containing the following:
                             // [inline/outside]-[top/bottom/middle]-[left/right/center]
                             // i.e. "inline-top-right" would put the legend in the 
                             //      graph body, at the top-right

  // chart settings
  var $pointShape;
  var $pointSize;

}  

?>
