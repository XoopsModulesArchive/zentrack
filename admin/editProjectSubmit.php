<?php

  /*
  **  This looks silly, sure
  **
  **  However, it is abstracted, because in the future, the 
  **  project and ticket screens will diverge further in purpose
  **  and structure.  This way, there is a convenient
  **  place to break them away and make future edits to the 
  **  projects on an abstract level.
  **
  */

  // set the type to project
  $type = "project";
  $page_type = "project";

  include("editTicketSubmit.php");
?>