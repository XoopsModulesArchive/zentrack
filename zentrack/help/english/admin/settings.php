<?
  $b = dirname(__FILE__);
  include("$b/admin_header.php");
?>

<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr>
  <td class='cell'>
    <p>The configuration settings panel controls the behavior, look and feel, and
    overall features of the system.</p>
    
    <p>You can view the system configuration panel by going to:
    <br><?=tr('Admin')?> -&gt;
        <?=tr('Settings Administration')?> -&gt;
        <?=tr('Configuration Settings')?>
  </td>    
</tr>
<tr>
  <td class='titleCell'>Overview of Settings</td>
</tr>
<tr>
  <td class='cell'>
    <p>Most system settings are described in detail on the panel, so there is
    really no need to reinvent the wheel here (we aren't really smart enough
    for that task anyways).  Instead, we will simply review some of the more
    commonly used elements and special considerations.</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Field/Group</td>
        <td class='subTitle'>Purpose</td>
      </tr>
      <tr>
        <td class='bars'>allow_*</td>
        <td class='bars'>
          The allow field can be used to turn various system features
          on or off.
        </td>
      </tr>
      <tr>
        <td class='bars'>check_pwd_simple</td>
        <td class='bars'>
          If on, the system will require users to enter passwords which contain
          non-letter characters such as numbers or symbols and require that
          the password be greater than 6 characters in length.
        </td>
      </tr>
      <tr>
        <td class='bars'>color_*</td>
        <td class='bars'>
          These fields control the look and feel of the site.
        </td>
      </tr>
      <tr>
        <td class='bars'>date_fmt_*</td>
        <td class='bars'>
          Controls the output formatting for dates.  See also the use_euro_date
          field.
        </td>
      </tr>
      <tr>
        <td class='bars'>default_*</td>
        <td class='bars'>
          Sets default form values.  Note that the default dates can be left
          blank to make the form fields blank by default.
        </td>
      </tr>
      <tr>
        <td class='bars'>email_*</td>
        <td class='bars'>
          Control when and how emails are sent to members of the notify list.
        </td>
      </tr>
      <tr>
        <td class='bars'>language_default</td>
        <td class='bars'>
          Controls the language that is displayed by default.  Users can change
          this using the Options panel.
        </td>
      </tr>
      <tr>
        <td class='bars'>level_*</td>
        <td class='bars'>
          Controls the level of access required for a user to be allowed to
          perform a given action.
        </td>
      </tr>
      <tr>
        <td class='bars'>log_*</td>
        <td class='bars'>
          Controls whether a given feature creates an entry in the log when it
          is run.
        </td>
      </tr>
      <tr>
        <td class='bars'>edit_reason_required</td>
        <td class='bars'>
          Editing existing ticket information can be logged setting log_edit to ON.
          But if you need to require the user to explain why the edition took place
          you need to set edit_reason_required to ON too. (If log_edit is set to OFF
          then edit_reason_required is ignored).
        </td>
      </tr>
      <tr>
        <td class='bars'>paging_max_rows</td>
        <td class='bars'>
          Controls the number of rows of data displayed in searches and lists
          of tickets.
        </td>
      </tr>
      <tr>
        <td class='bars'>priority_medium</td>
        <td class='bars'>
          If this is set to zero, priority shading will be turned off (priority
          shading changes the color of tickets in a list according to their
          priority).
          
          <p>Set this to about 1/2 of the total number of priority entries for
          optimal shading.
        </td>
      </tr>
      <tr>
        <td class='bars'>system_name</td>
        <td class='bars'>
          Use this to override the name of the tracking system which is displayed
          to users.
        </td>
      </tr>
      <tr>
        <td class='bars'>time_elapsed_unit</td>
        <td class='bars'>
          Controls the unit of time used in the elapsed field for tickets.  Valid
          entries are things like: seconds, minutes, hours, days, months, etc.
        </td>
      </tr>
      <tr>
        <td class='bars'>url_view_*</td>
        <td class='bars'>
          Can be used to override the pages used to view attachments and tickets.
          This is used only by advanced administrators who wish to modify the
          system and create customized view and attachment pages.
        </td>
      </tr>
      <tr>
        <td class='bars'>use_euro_date</td>
        <td class='bars'>
          If on, dates are parsed using the European format (dd/mm/yyyy) instead
          of the U.S. format (mm/dd/yyyy).  All other date formats are unaffected.
        </td>
      </tr>
      <tr>
        <td class='bars'>varfield_tab_name</td>
        <td class='bars'>
          Sets the name of the tab which contains variable (custom) fields.
        </td>
      </tr>
      <tr>
        <td class='bars'>version</td>
        <td class='bars'>
          The currently installed version of zentrack.
        </td>
      </tr>      
    </table>
  </td>
</tr>
</table>

<? 
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
