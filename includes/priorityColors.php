<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }


function color_scale($startcol, $endcol, $pct) {
   // This function returns an HTML colour scaled on a percentile
   // scale between the two provided colours
   
   $p = ($pct < 0)? 0: (($pct > 100)? 1: $pct / 100);
   
   // Split the colours into their red, green and blue ratios
   $sr = hexdec(substr($startcol, 1, 2));
   $sg = hexdec(substr($startcol, 3, 2));
   $sb = hexdec(substr($startcol, 5, 2));
   
   $er = hexdec(substr($endcol, 1, 2));
   $eg = hexdec(substr($endcol, 3, 2));
   $eb = hexdec(substr($endcol, 5, 2));
   
   $r = $sr + (($er - $sr) * $p);
   $g = $sg + (($eg - $sg) * $p);
   $b = $sb + (($eb - $sb) * $p);

   return ('#' . str_pad(dechex($r), 2, "0", STR_PAD_LEFT) . str_pad(dechex($g), 2, "0", STR_PAD_LEFT) . str_pad(dechex($b), 2, "0", STR_PAD_LEFT));
}

function color_darken($startcol, $pct) {
   $p = $pct / 100;

   // Split the colours into their red, green and blue ratios
   $sr = hexdec(substr($startcol, 1, 2));
   $sg = hexdec(substr($startcol, 3, 2));
   $sb = hexdec(substr($startcol, 5, 2));
   
   $r = $sr - $sr * $p;
   $g = $sg - $sg * $p;
   $b = $sb - $sb * $p;
   
   return ('#' . str_pad(dechex($r), 2, "0", STR_PAD_LEFT) . str_pad(dechex($g), 2, "0", STR_PAD_LEFT) . str_pad(dechex($b), 2, "0", STR_PAD_LEFT));   
}

function priority_color($priority) {
   // This function returns an HTML colour based on the priority
   // supplied on a sliding colour scale.
   
   global $lc, $mc, $hc, $mp, $num, $lowp;
   
   $p = ($priority - $lowp) / $num * 100;
   $med = ($mp - $lowp) / $num * 100;
   
   $p = ($p < 0)? 0: (($p > 100)? 100: $p);
   
   if ($p < $med) {
      $pct = ($priority - $lowp) / $mp * 100;
      $colour = color_scale($lc, $mc, $pct);
   } elseif ($p < 100) {
      $pct = ($priority - $mp) / ($num - $mp + 1) * 100;
      $colour = color_scale($mc, $hc, $pct);
   } else {
      $colour = $hc;
   }
   
   return ($colour);
}

$lowp = 99999;
$hip = -1;

$lc = $zen->getSetting("color_priority_low");
$mc = $zen->getSetting("color_priority_med");
$hc = $zen->getSetting("color_priority_hi");
$mp = $zen->getSetting("priority_medium");

$pri_list = $zen->getPriorities(1);
foreach ($pri_list as $v) {
   if ($v["priority"] < $lowp) $lowp = $v["priority"];
   if ($v["priority"] > $hip) $hip = $v["priority"];
}
      
$num = $hip - $lowp;

unset ($previous);

foreach (array_reverse($pri_list) as $v) {
   print "  ";
//   if ($previous) print ".priority{$previous}Over, ";
//   $previous = $v["pid"];
   $col = priority_color($v["priority"]);
   print ".priority{$v['pid']} {\n";
   print "\tBackground:     $col;\n";
   if ($v["priority"] == $hip) {
     print "\tfont-weight:     Bold;\n";
   }
   print "}\n\n";
   print "  ";
//   if ($previous) print ".priority{$previous}Over, ";
//   $previous = $v["pid"];
   print ".priority{$v['pid']}Over {\n";
   print "\tBackground:     ".color_darken($col,10).";\n";
   if ($v["priority"] == $hip) {
     print "\tfont-weight:     Bold;\n";
   }
   print "}\n\n";   
}
?>
