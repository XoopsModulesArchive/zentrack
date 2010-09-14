<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<?php if( $page_title == tr("Change Password") ) { ?>
  <div class='menuBox'>
    <div><?php echo tr("Welcome!"); ?></div>
    <p onclick='mClk(this)'>
    &nbsp;&nbsp;<span class='error'>
    <?php
     $link = "<a href='$helpUrl/tutorial.php'>".tr('Tutorial')."</a>";
     print tr("If this is your first time logging in, please read the ?!", array($link));
    ?>
    </span></p>
  </div>
<?php } ?>


  <div class='menuBox'>
    <div><?php echo tr("Preferences"); ?></div>
    <p onclick='mClk(this)'>
    <a href='<?php echo $rootUrl?>/misc/homebin.php'><?php echo $hotkeys->ll("Change Home Bin"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Set the default bin to display"); ?></span></p>
    <p onclick='mClk(this)'>
    <a href="<?php echo $rootUrl?>/misc/language.php"><?php echo $hotkeys->ll("Set Language"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Change the language used to view pages."); ?></span></p>
  </div>