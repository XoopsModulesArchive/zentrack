<?php {if( !ZT_DEFINED ) { die("Illegal Access"); }


  /*
  **  ZENGRAPH CONFIGURATION SETTINGS
  **
  **      *********************************
  **      ***                           ***
  **      ***        WARNING!!!         ***
  **      ***                           ***
  **      ***    Do not write to this   ***
  **      ***    file.  Instead, make   ***
  **      ***    duplicate and use      ***
  **      ***    the .custom file with  ***
  **      ***    the same name instead  ***
  **      ***                           ***
  **      *********************************
  **
  **  Default settings for the graphing system.
  **
  **  See includes/lib/colors/default for detailed
  **  information about creating transparencies, tiled
  **  and textured effects, and other color options
  */

  /*
  **  TESTING AND DEBUG
  */

  // set this variable to enable debug output rather than image output:
  //   1 - major errors and comments
  //   2 - minor errors and comments
  //   3 - all errors and comments  
  $this->debug = 0;  //DO NOT SET THIS, USE www/view_image.php $graph->debug = 0;

  /*
  **  OUTPUT SETTINGS
  */
  global $zen;

  // type of image to output
  $this->imageType = "png";

  // quality of image, if jpeg type
  // integer from 0 to 100(best)
  // default is around 75
  $this->imageQuality = 100;

  // directory of the zenGraph library
  $this->libDir = $zen->libDir;

  // if this is specified, then zenGraph
  // will output a file... otherwise, it
  // sends the output to stdout
  $this->outputDirectory = "";

  // 0 or 1, uses alpha blending... requires 
  // GD 2.0.1 or greater and php 4.0.6 or greater
  // disable this if no transparent layers will be used
  // because it uses unneccessary system overhead  
  $this->trueColorEnabled = 1;  

  /*
  **  IMAGE PROPERTIES
  */

  // size of image  
  $this->imageHeight = 550;
  $this->imageWidth = 600;
                          
  // color of the image background
  $this->colorBackground = array(  0,  0,  0);

  // color of the image foreground(also the default color)
  $this->colorForeground = array(255,255,255);
  
  // color definitions to load into memory
  $this->colorScheme = "default";
  
  /*
  **  CHART SETTINGS
  */

  // the highest value on the y axis
  // if this is left blank, the system
  // will make a good attempt to create
  // a good max and label set
  $this->yMax = null;  

  // 0-127, affects the transparency of the 
  // graph (can be changed on each layer)
  // only used if trueColorEnabled = 1
  // leave undefined for solid colors
  $this->transparency = null;      
  
  // default type of graph (line,bar,column,pie,area,scatter)
  $this->graphType = "column";

  // 0 or 1, determines if frame is visible
  $this->showFrame = 1;

  // the length of tick marks next to x and y labels
  // tic length may alternately be set to "full" which
  // will cause the tic marks to display across the
  // entire graph... this is most useful if the graphForeground
  // color is transparent.
  $this->ticLength = 3;
  
  // 1 or greater, thickness for frame elements
  // this must be 2 or greater if frames/borders
  // are to have a 3d effect
  $this->frameThickness = 2;

  // 0 or greater, space between bars/columns
  $this->gap = 10;

  // 1 or greater, thickness of charted lines
  $this->lineThickness = 2;

  // background of charted portion
  $this->colorGraphBackground = array(120,120,120,0); 
  
  // color of text on graph portion (the frame and tic marks, etc)
  $this->colorGraphForeground = array(255,255,0,0); 

  // 1 or greater, width of margins
  $this->margin = 12;

  // this can be:  blank, "box"(emtpy square), "dot", "circle", "diamond", "strike", "plus", "dash", "bar", "square", "triangle"
  $this->pointShape = "diamond";
  
  // the size of the points on the graph... 6 is good
  $this->pointSize = 6;
  
  // GRIDLINES
  // the gridlines which appear behind the charted portion
  // either set to "line","bar","shelf" or undefined(null or "")
  //
  // if an optional ! is added to the end of the name ("line!") then
  // no shading will be added in the 3d portion... just on the backing

  $this->showXGuides = "shelf";
  $this->showYGuides = "line";

  // ABOUT THE "SHELF" TYPE
  // "shelf" is an experimental guideline type, and buggy in
  // most cases... it will improve as I have time to work on it
  // "shelf" is probably only useful if the color is defined as
  // transparent (otherwise it will by quite ugly), thus trueColor
  // images capabiliites (GD 2.0.1/PHP 4.0.6) must be installed
  // also, "shelf" will appear as a line, unless the graph has some
  // depth... also... the shelf effect does not work well if the
  // data is charted with transparent bars/lines/etc... it tends to get
  // quite ugly... so use solid ones... one more.... the shelf type
  // only works reliably with simple graphs... more complex data type
  // combinations and layouts really hose it up... so basically don't
  // use it until I decide to finish it - unless you are just looking
  // to see how cool it is - because it IS QUITE COOL with transparency :)

  // color of the guides on the graph
  // these can be a complex array(a different color for each segment) or
  // a simple array (one color)

  // one color set
  $this->colorXGuidelines = array(100,100,100,110);

  // one color set
  $this->colorYGuidelines   = array(180,180,100,80);

  /*
  **  TEXT SETTINGS
  */
  
  // the numeric format to show data
  // T[,x],H[,x],K[,x]|M[,x]|B[,x]|A[,x]
  // (tens,hundreds,thousands,millions,billions,actual[leave as is])
  // where x is the number of decimals (if left off, defaults to zero)
  // example: "K,2' would truncate to thousands, plus 2 decimals (2.02 thousand)
  // "M" would truncate to millions, zero decimals (412 million)
  // if blank, the system will not format number or limit decimal digits
  $this->dataFormat = "";         

  // size of plain text, in pixels with TTF, otherwise 1-5
  $this->fontSize = 8;
  
  // used only with TTF, this is the font to display
  $this->font = "arial.ttf";
  
  // size of the graph title, in pixels with TTF, otherwise 1 - 5
  $this->titleSize = 14;
  
  // used only with TTF, this is the font to display
  $this->titleFont = "arial.ttf";

  // color of the graph title
  $this->titleColor = array(255,255,255,0);
  
  // 0 or 1, tells whether TTF support is enabled
  $this->ttfEnabled = 1;
  
  // the default TTF font to use
  $this->ttfDefault = "arial.ttf";
  
  // graph title
  $this->graphTitle = "Graphical Analysis";
  
  // graph subtitle
  $this->graphSubtitle = "Of Something Unknown";

  /*
  **  HEADINGS
  */

  // title of x axis
  $this->xHeading = "";
  
  // title of y axis
  $this->yHeading = "";
  
  // size of x/y headings, in pixels with TTF, otherwise 1 - 5
  $this->headingSize = 12;
  
  // used only with TTF, this is the font to display
  $this->headingFont = "courier_bold.ttf";

  // color of headings
  $this->headingColor = array(0,0,0);
  
  // also for xSubHeading
  // if using TTF, this is the angle to display the text at
  // otherwise, this is 0 or 90
  $this->xHeadingAngle = 0;
  
  // also for ySubHeading
  // if using TTF, this is the angle to display the text at
  // otherwise, this is 0 or 90
  $this->yHeadingAngle = 90;

  /*
  **  SUBHEADINGS
  */

  // subtitle of x axis
  // blank is fine
  $this->xSubHeading = "";
  
  // subtitle of y axis
  // can be blank.. if set to "auto", then
  // the system will set this based on the
  // dataFormat option
  $this->ySubHeading = "";

  // size of x/y subheadings, in pixels with TTF, otherwise 1-5
  $this->subHeadingSize = 10;
  
  // color of x/y subheading
  $this->subHeadingColor = array(0,0,0,0);

  // font of x/y subheadings
  $this->subHeadingFont = "courier_italic.ttf";

  /*
  **  LABELS
  */

  // controls centering of x labels:
  //  0 - centered        (centered in the column)
  //  1 - left justified
  //  2 - right justified (on the tic mark)
  $this->xLabelsCentered = 2;

  // labels for the x axis
  $this->xLabels = array("", "Jan", "Feb", "Mar", "Apr", "May");

  // labels for y axis.. if these are not set
  // the program will generate something based
  // on the input data
  // if the yLabels are set, then the yDiv should also be set
  // or there will be much weeping and gnashing of teeth
  //$this->yLabels = array(0,100,200,300,400,500,600,700,800,900,1000);
  $this->yLabels;

  // the number of labelled divisions on the y axis
  // leave this as null unless setting the yLabels manually
  $this->yDiv = null;

  // size of label text, in pixels with TTF, otherwise 1 - 5
  $this->labelSize = 8;
  
  // used only with TTF, this is the font to display
  $this->labelFont = "arial.ttf";

  // color of labels
  $this->labelColor = array(255,0,0,0);
    
  // if using TTF, this is the angle to display the x axis labels at
  // otherwise, this is 0 or 90
  $this->xLabelsAngle = 45;
  
  // if using TTF, this is the angle to display the y axis labels at
  // otherwise, this is 0 or 90
  $this->yLabelsAngle = 45;

  // labels for right side of y axis (alternate labels)
  // leave blank and they will not be displayed
  // if you use these, they must be set appropriately...
  // that is... the lowest value must correspond to the lowest
  // value of the yLabels, and the hightest value must correspond
  // to the highest value of the yLabels (they do not have to have
  // the same number of elements) because they will be scaled
  // to match
  // you may use an optional parameter in the addData call as follows:
  // "y2scale"=1, which will cause a particular row of data (except pies)
  // to be scaled to the y2 axis rather than the y axis
  $this->y2Labels = null;
  
  // if using TTF, this is the angle to display the y2 axis labels at  
  // otherwise, this is 0 or 90
  $this->y2LabelsAngle = 0;

  /*
  **  PLOTTED VALUES
  */
  // 0-off 1-on, shows values on graph
  $this->showValueOnGraph = 0;  
  // size of plotted values
  $this->valueFontSize = ($this->ttfEnabled)? 
	$this->fontSize-2 : $this->fontSize-1;
  // angle of plotted values
  $this->valueFontAngle = 45;
  // this can be a color value (#hhhhhh or array(rr,gg,bb))
  // or null which will set it to the color
  // of the plotted element
  $this->valueFontColor = null;        

  /*
  **  3D EFFECTS
  */
  
  // the intensity of shadows and highlights, 20 is good
  $this->lightIntensity = 40;

  // ratio of width:height for 3d effects
  // for example: to make the ratio 2:1 enter .5, 1:2 enter 2
  $this->offsetRatio = 1.5;

  /*
  **  LEGEND
  */
  
  // {top|bottom|middle}-{left|right|center}[-horizontal]
  // i.e. "top-right" would put the legend in the top-right
  // center and middle will move elements aside and put 
  // the legend at these locations optional horizontal may be added
  // (doesn't work with middle), which shows the
  // legend in a horizontal display, instead of stacking elements... 
  // this only works with small lists or short titles!
  // you may not use middle-center... this is invalid
  // you may not use middle-{left|right|center}-horizontal... this is invalid
  // this is overridden by "Float" param or by legendFloat below
  $this->legendLocation = "top-right";

  // this sets the number of columns to be shown in a legend... note that
  // this will be overridden if you use legendLocation "...-horizontal"
  // use this as a way to specify the horizontal/vertical relationship of
  // columns and rows
  $this->legendColumns = 1;

  // Float will cause the legend to be rendered on top of the image
  // giving the appearance that it floats over the graph body
  // this should either be null (no float) or array( x,y ) where 
  // x,y are the starting coordinates.
  // you probably don't want to enable this... what you probably want
  // to do is just add "Float"=>array(x,y) params to your addLegend(settings...) call
  $this->legendFloat = null;

  // 0 - 127, the transparency of the legend
  // use only with trueColor support
  $this->legendTransparency = null;
  
  // size of the text in the legend (ttf = pixels, otherwise 1-5)
  $this->legendFontSize = "8";
  
  // use only with TTF support enabled
  $this->legendFontFace = "arial.ttf";
  
  // use only with TTF support
  $this->legendFontAngle = 0;
  
  // type of symbol to show... can be blank
  $this->legendPointShape = "Square";
  
  // size of legend bullets
  $this->legendPointSize = 6;

  // title of the legend... can be blank
  $this->legendTitle = "Legend";

  // color of the legend's background
  // if '' then will use image background color
  $this->legendBackgroundColor = '';

  // color of the legend's foreground text (title, layer names)
  // if '' then will use image foreground color
  $this->legendForegroundColor = '';

  // the size of the legend borders
  // 2 or more is good for 3D effects
  $this->legendBorderThickness = 3; 

  // color of the legend's border
  // if '' then will use colorGraphForeground
  $this->legendBorderColor = '';

  // the width of the legend.. if set to 0, will be calculated dynamically
  // this should probably be left at zero
  // unless your text to display is a fairly consistent width
  // this value is ignored if the legendLocation uses "horizontal"
  $this->legendWidth = '';

  // the height of the legend.. if set to 0, will be calculated dynamically
  // this should probably be left at zero
  // unless the number of rows to display is fairly consistent.
  // this value is ignored if the legendLocation uses "horizontal"
  $this->legendHeight = 0;
  
  
  /*
  ***********************
  **  ADVANCED OPTIONS **
  ***********************
  **  These should USUALLY BE LEFT BLANK, and determined by the system
  **  although they can be set for special affects and conditions
  */

  // the number of labelled divisions on the y2 axis
  $this->y2Div;

  // height/width of the charted portion, will be set by the system if 
  // left undefined (preferred in most cases)
  $this->graphHeight;       
  $this->graphWidth;  

  // the lowest value on the y axis
  $this->yMin;
  
  // the number of labelled divisions on the x axis
  $this->xDiv;    
  
  // the highest value on the x axis
  $this->xMax;    
  
  // the lowest value on the x axis
  $this->xMin;    

  // the angle of the layer names
  $this->layerLabelAngle = 320;

  // spacing buffer
  $this->space = ceil($this->margin / 2);
   
}?>
