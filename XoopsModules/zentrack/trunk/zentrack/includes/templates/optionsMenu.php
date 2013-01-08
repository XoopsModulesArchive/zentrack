<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<? if( $page_title == tr("Change Password") ) { ?>
  <div class='menuBox'>
    <div><?=tr("Welcome!")?></div>
    <p onclick='mClk(this)'>
    &nbsp;&nbsp;<span class='error'>
    <?
     $link = "<a href='$helpUrl/tutorial.php'>".tr('Tutorial')."</a>";
     print tr("If this is your first time logging in, please read the ?!", array($link));
    ?>
    </span></p>
  </div>
<? } ?>


  <div class='menuBox'>
    <div><?=tr("Preferences")?></div>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/misc/homebin.php'><?=$hotkeys->ll("Change Home Bin")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Set the default bin to display")?></span></p>
    <p onclick='mClk(this)'>
    <a href="<?=$rootUrl?>/misc/language.php"><?=$hotkeys->ll("Set Language")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Change the language used to view pages.")?></span></p>
  </div>