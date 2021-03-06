<?php if( !ZT_DEFINED ) { die("Illegal Access"); }

/**
 * Manages keyboard shortcuts for all pages.
 *
 * There are global assignments (those which are available on every page) and
 * local assignments (which are loaded using ZenHotKeys::loadSection().
 *
 * A singleton instance of this class is maintained in $hotkeys by the
 * includes/headerInc.php file.
 */
class ZenHotKeys {
  
  function ZenHotKeys( &$zen ) {
    $this->_zen =& $zen;
    $this->_keys = array();
    $this->_fxns = array();
    $this->_idx = array();
    $this->_tabs = array();
    $this->_keysRendered = array();
    $this->_tabkeys = array();
    $this->_lh = '';
    $this->_alternate = $zen->getSetting('hotkeys_alternate_hints');
    $this->_alreadyLoaded = array();
    $this->_initSections();
    $this->loadSection('globals');
  }
  
  /**
   * Generates section information (right now it is just hard coded, later we will add this to the db)
   */
  function _initSections() {
    $this->_sections = array();
    
    ////////////////////////
    // GLOBALS
    ////////////////////////
    $c = 1;
    $this->newFxn('quickFocus', 'window.document.quickIdForm.idText.focus(); quickHighlight("window.document.quickIdForm.idText","searchHelpBox");', '', true);
    $this->_sections['globals'] = array();
    $this->_sections['globals']['ALT+'.$c++] = array('Projects', "KeyEvent.createLoadUrl('{rootUrl}/projects.php')", '', true);
    $this->_sections['globals']['ALT+'.$c++] = array('Tickets', "KeyEvent.createLoadUrl('{rootUrl}/index.php')", '', true);
    if( $this->_zen->settingOn('allow_contacts') ) {
      $this->_sections['globals']['ALT+'.$c++] = array('Contacts',    "KeyEvent.createLoadUrl('{rootUrl}/contacts.php')", '', true);
    }
    $this->_sections['globals']['ALT+'.$c++] = array('Options', "KeyEvent.createLoadUrl('{rootUrl}/options.php')", '', true);  
    $this->_sections['globals']['ALT+'.$c++] = array('Help', "KeyEvent.createLoadUrl('{rootUrl}/help/index.php')", '', true);  
    $this->_sections['globals']['ALT+'.$c++] = array('Admin', "KeyEvent.createLoadUrl('{rootUrl}/admin/index.php')", '', true);  
    $this->_sections['globals']['ALT+P'] = array('New Project', "KeyEvent.createLoadUrl('{rootUrl}/newProject.php')", '', true);  
    $this->_sections['globals']['ALT+T'] = array('New Ticket',  "KeyEvent.createLoadUrl('{rootUrl}/newTicket.php')", '', true);  
    $this->_sections['globals']['ALT+C'] = array('New Contact', "KeyEvent.createLoadUrl('{rootUrl}/newContact.php')", '', true);
    $this->_sections['globals']['ALT+S'] = array('Search', "quickFocus()", 'Enter a ticket id or summary', true);
    $this->_sections['globals']['ALT+V'] = array('Advanced Search', "KeyEvent.createLoadUrl('{rootUrl}/search.php')", "Advanced ticket search", true);
    
    ////////////////////////
    // ADMIN
    ////////////////////////
    $this->_sections['admin'] = array();
    $this->_sections['admin']['ALT+N'] = array('New User', "KeyEvent.createLoadUrl('{rootUrl}/admin/addUser.php')", '', false);
    $this->_sections['admin']['ALT+U'] = array('Edit Users', "KeyEvent.createLoadUrl('{rootUrl}/admin/listUsers.php')", '', false);
    $this->_sections['admin']['ALT+E'] = array('Edit Tickets', "KeyEvent.createLoadUrl('{rootUrl}/admin/editTicket.php')", '', false);
    $this->_sections['admin']['ALT+F'] = array('Edit Field Map', "KeyEvent.createLoadUrl('{rootUrl}/admin/fieldMap.php')", '', false);
    $this->_sections['admin']['ALT+B'] = array('Bins', "KeyEvent.createLoadUrl('{rootUrl}/admin/bins.php')", '', false);
    $this->_sections['admin']['ALT+R'] = array('Priorities', "KeyEvent.createLoadUrl('{rootUrl}/admin/priorities.php')", '', false);
    $this->_sections['admin']['ALT+S'] = array('Systems', "KeyEvent.createLoadUrl('{rootUrl}/admin/systems.php')", '', false);
    $this->_sections['admin']['ALT+A'] = array('Tasks', "KeyEvent.createLoadUrl('{rootUrl}/admin/tasks.php')", '', false);
    $this->_sections['admin']['ALT+Y'] = array('Types', "KeyEvent.createLoadUrl('{rootUrl}/admin/types.php')", '', false);
    $this->_sections['admin']['ALT+G'] = array('Data Groups', "KeyEvent.createLoadUrl('{rootUrl}/admin/groups.php')", '', false);
    $this->_sections['admin']['ALT+H'] = array('Behaviors', "KeyEvent.createLoadUrl('{rootUrl}/admin/behaviors.php')", '', false);
    $this->_sections['admin']['ALT+O'] = array('Configuration', "KeyEvent.createLoadUrl('{rootUrl}/admin/config.php')", '', false);

    ////////////////////////
    // ACTIONS
    ////////////////////////
    $this->_sections['actionbar'] = array();
    $actions = $this->_zen->getActions();
    foreach($actions as $k=>$v) {
      if( $v['button'] && $v['key'] ) {
        if( $k == 'print' ) {
          $this->_sections['actionbar'][$v['key']] = array("Action: {$v['label']}", "printWindow", '', false);
          continue;
        }
        $this->_sections['actionbar'][$v['key']] = array("Action: {$v['label']}", 
          "KeyEvent.createLoadUrl('{rootUrl}/actions/$k.php?id={id}')", $v['label'], false);
      }
    }

    ////////////////////////
    // action_approve
    ////////////////////////
    $f = "window.document.formless['approveForm']";
    $this->_sections['action_approve'] = array();
    $this->_sections['action_approve']['ALT+O'] = array('Comments', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_approve']['ALT+A'] = array('Approve', "{$f}.submit()", '', false);

    ////////////////////////
    // action_assign
    ////////////////////////
    $f = "window.document.forms['assignForm']";
    $this->_sections['action_assign'] = array();
    $this->_sections['action_assign']['ALT+R'] = array('Recipient', "{$f}.elements['user_id'].focus()", '', false);
    $this->_sections['action_assign']['ALT+O'] = array('Comments or Instructions', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_assign']['ALT+A'] = array('Assign', "{$f}.submit()", '', false);

    ////////////////////////
    // action_close
    ////////////////////////
    $this->_sections['action_close'] = array();
    $this->_sections['action_close']['ALT+H'] = array('Field: hours', "window.document.forms['ticketTabForm'].elements['hours'].select()", 'Hours', false);
    $this->_sections['action_close']['ALT+O'] = array('Field: comments', "window.document.forms['ticketTabForm'].elements['comments'].select()", 'Comments', false);
    $this->_sections['action_close']['ALT+L'] = array('Close', "window.document.forms['ticketTabForm'].submit()", '', false);
    
    ////////////////////////
    // action_contacts
    ////////////////////////
    $this->_sections['action_contacts'] = array();
    $this->_sections['action_contacts']['ALT+N'] = array('Create New Contact', "window.document.forms['newContactForm'].submit()", '', false);
    $this->_sections['action_contacts']['ALT+A'] = array('Add Contact', "window.document.forms['ContactsAddForm'].submit()", '', false);
    $this->_sections['action_contacts']['ALT+D'] = array('Drop Contacts', "window.document.forms['dropContactsForm'].submit()", '', false);
    $this->_sections['action_contacts']['ALT+Y'] = array('Field: company_id', "window.document.forms['ContactsAddForm'].elements['company_id'].focus()", 'Company', false);
    $this->_sections['action_contacts']['ALT+E'] = array('Field: person_id', "window.document.forms['ContactsAddForm'].elements['person_id'].focus()", 'Person', false);
    
    ////////////////////////
    // action_notify
    ////////////////////////
    $this->_sections['action_notify'] = array();
    $f = "window.document.forms['notifyAddForm']";
    $this->_sections['action_notify']['ALT+R'] = array('Enter Registered Users', "{$f}.elements['user_accts'].select()", '', false);
    $this->_sections['action_notify']['ALT+U'] = array('Add an Unregistered User', "{$f}.elements['unreg_name'].select()", '', false);
    $this->_sections['action_notify']['ALT+O'] = array('Add a Contact', "{$f}.elements['company_id'].focus()", '', false);
    $this->_sections['action_notify']['ALT+A'] = array('Add Recipients', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_email
    ////////////////////////
    $this->_sections['action_email'] = array();
    $f = "window.document.forms['emailForm']";
    $this->newFxn('emailFormToggle', "var obj = {$f}.elements['method']; var newVal = arguments[0]; for(var i=0; i < obj.length; i++) { if( obj[i].value == newVal ) { obj[i].checked = true; break; } }");
    $this->_sections['action_email']['ALT+U'] = array('Select a User', "{$f}.elements['users_to_email[]'].focus();", "Select one or more users, use CTRL or SHIFT key for multiples", false);
    $this->_sections['action_email']['ALT+M'] = array('Manually Enter Addresses', "{$f}.elements['custom_email_addresses'].select();", "Manually enter an email address, use commas to separate multiple addresses", false);
    $this->_sections['action_email']['ALT+O'] = array('Comments or Instructions', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_email']['ALT+E'] = array('Send Email', "{$f}.submit()", '', false);
    $this->_sections['action_email']['ALT+L'] = array('send option: link', "emailFormToggle(1)", '', false);
    $this->_sections['action_email']['ALT+Y'] = array('send option: summary', "emailFormToggle(2)", '', false);
    $this->_sections['action_email']['ALT+G'] = array('send option: log', "emailFormToggle(3)", '', false);
    
    ////////////////////////
    // action_log
    ////////////////////////
    $this->_sections['action_log'] = array();
    $f = "window.document.forms['logForm']";
    $this->_sections['action_log']['ALT+Y'] = array('Select an Activity', "{$f}.elements['log_action'].focus()", '', false);
    $this->_sections['action_log']['ALT+H'] = array('Enter Hours Worked', "{$f}.elements['hours'].select()", '', false);
    $this->_sections['action_log']['ALT+O'] = array('Log Entry / Comments', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_log']['ALT+A'] = array('Save Log', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_move
    ////////////////////////
    $this->_sections['action_move'] = array();
    $f = "window.document.forms['moveForm']";
    $this->_sections['action_move']['ALT+B'] = array('New Bin', "{$f}.elements['newBin'].focus()", '', false);
    $this->_sections['action_move']['ALT+O'] = array('Comments', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_move']['ALT+M'] = array('Move', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_reject
    ////////////////////////
    $this->_sections['action_reject'] = array();
    $f = "window.document.forms['rejectForm']";
    $this->_sections['action_reject']['ALT+O'] = array('Reason', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_reject']['ALT+R'] = array('Reject', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_relate
    ////////////////////////
    $this->_sections['action_relate'] = array();
    $f = "window.document.forms['relateTicketForm']";
    $this->_sections['action_relate']['ALT+I'] = array('Enter Ticket IDs', "{$f}.elements['relations'].select()", '', false);
    $this->_sections['action_relate']['ALT+O'] = array('Comments', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_relate']['ALT+R'] = array('Relate', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_reopen
    ////////////////////////
    $this->_sections['action_reopen'] = array();
    $f = "window.document.forms['reopenForm']";
    $this->_sections['action_reopen']['ALT+O'] = array('Comments or Instructions', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_reopen']['ALT+R'] = array('Reopen', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_test
    ////////////////////////
    $this->_sections['action_test'] = array();
    $f = "window.document.forms['testForm']";
    $this->_sections['action_test']['ALT+H'] = array('Hours Worked', "{$f}.elements['hours'].select()", '', false);
    $this->_sections['action_test']['ALT+O'] = array('Comments or Instructions', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_test']['ALT+E'] = array('Testing Complete', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_upload
    ////////////////////////
    $this->_sections['action_upload'] = array();
    $f = "window.document.forms['addAttachmentForm']";
    $this->_sections['action_upload']['ALT+U'] = array('Select a File to Upload', "{$f}.elements['userfile'].focus()", '', false);
    $this->_sections['action_upload']['ALT+E'] = array('Description of Attachment', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_upload']['ALT+A'] = array('Add Attachment', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_yank
    ////////////////////////
    $this->_sections['action_yank'] = array();
    $this->_sections['action_yank']['ALT+O'] = array('Reason', "window.document.forms['pullForm'].elements['comments'].select()", '', false);
    $this->_sections['action_yank']['ALT+U'] = array('Pull', "window.document.forms['pullForm'].submit()", '', false);
    
    ////////////////////////
    // agreement_view
    ////////////////////////
    $this->_sections['agreement_view'] = array();
    $this->_sections['agreement_view']['ALT+E'] = array('Edit', "window.document.forms['editAgreementForm'].submit()", '', false);
    $msg = Zen::fixJsHtml(tr("Are you sure you want to archive this agreement?"),"'");
    $this->_sections['agreement_view']['ALT+A'] = array('Archive', "confirmSubmit(window.document.forms['archiveAgreementForm'],$msg)", '', false);
    $msg = Zen::fixJsHtml(tr("Are you sure you want to delete this agreement?"),"'");
    $this->_sections['agreement_view']['ALT+D'] = array('Delete', "confirmSubmit(window.document.forms['deleteAgreementForm'],$msg)", '', false);
    
    ////////////////////////
    // agreement_form
    ////////////////////////
    $this->_sections['agreement_form'] = array();
    $f = "window.document.forms['agreementForm']";
    $this->_sections['agreement_form']['ALT+A'] = array('Add Item', "rerouteAgreementForm('addItems')", '', false);
    $this->_sections['agreement_form']['ALT+O'] = array('Drop Items', "rerouteAgreementForm('removeItems')", '', false);
    $this->_sections['agreement_form']['ALT+R'] = array('Create', "{$f}.submit()", '', false);
    $this->_sections['agreement_form']['ALT+M'] = array('Agreement ID', "{$f}.elements['contractnr'].select()", '', false);
    $this->_sections['agreement_form']['ALT+E'] = array('Description', "{$f}.elements['description'].select()", '', false);
    
    ////////////////////////
    // auto_login
    ////////////////////////
    $this->_sections['auto_login'] = array();
    $this->_sections['auto_login']['ALT+O'] = array('Turn On', "window.document.autoForm.submit()", 'Toggle setting on/off', false);

    ////////////////////////
    // contacts
    ////////////////////////
    $this->_sections['contacts'] = array();
    $this->_sections['contacts']['ALT+N'] = array('Find', "KeyEvent.createLoadUrl('{rootUrl}/searchContacts.php')", '', false);
    $this->_sections['contacts']['ALT+B'] = array('Browse', "KeyEvent.createLoadUrl('{rootUrl}/agreements.php')", '', false);
    $this->_sections['contacts']['ALT+G'] = array('New Agreement', "KeyEvent.createLoadUrl('{rootUrl}/newAgreement.php')", '', false);
    
    ////////////////////////
    // contacts_new_menu
    ////////////////////////
    $this->_sections['contacts_new_menu'] = array();
    $this->_sections['contacts_new_menu']['ALT+Y'] = array('New Company', "KeyEvent.createLoadUrl('{rootUrl}/newContact.php?mode2=1')", '', false);
    $this->_sections['contacts_new_menu']['ALT+N'] = array('New Person', "KeyEvent.createLoadUrl('{rootUrl}/newContact.php?mode2=2')", '', false);
    
    ////////////////////////
    // contacts_view
    ////////////////////////
    $this->_sections['contacts_view'] = array();
    $this->_sections['contacts_view']['ALT+D'] = array('Edit', "KeyEvent.createLoadUrl('{rootUrl}/actions/contact_edit.php?cid={id}')", '', false);
    $this->_sections['contacts_view']['ALT+L'] = array('Delete', "KeyEvent.createLoadUrl('{rootUrl}/actions/contact_delete.php?cid={id}')", '', false);
    $this->_sections['contacts_view']['ALT+E'] = array('Add Employee', "KeyEvent.createLoadUrl('{rootUrl}/actions/contact_employee.php?cid={id}')", '', false);
    $this->_sections['contacts_view']['ALT+A'] = array('Add Agreement', "KeyEvent.createLoadUrl('{rootUrl}/actions/contact_agreement.php?cid={id}')", '', false);
    $this->_sections['contacts_view']['ALT+I'] = array('View Tickets', "KeyEvent.createLoadUrl('{rootUrl}/contact.php?overview=tickets&cid={id}')", '', false);
    $this->_sections['contacts_view']['ALT+Y'] = array('View Employees', "KeyEvent.createLoadUrl('{rootUrl}/contact.php?cid={id}&overview=contact')", '', false);
    $this->_sections['contacts_view']['ALT+M'] = array('View Agreements', "KeyEvent.createLoadUrl('{rootUrl}/contact.php?cid={id}&overview=agreement')", '', false);
    
    ////////////////////////
    // contacts_view_employee
    ////////////////////////
    $this->_sections['contacts_view_employee'] = array();
    $this->_sections['contacts_view_employee']['ALT+E'] = array('Edit', "window.document.forms['edit_form'].submit()", '', false);
    $msg = Zen::fixJsVal(tr("Are you sure you want to delete this contact?"));
    $this->_sections['contacts_view_employee']['ALT+D'] = array('Delete', "confirmSubmit(window.document.forms['delete_form'],$msg)", '', false);
    $this->_sections['contacts_view_employee']['ALT+I'] = array('View Tickets', "window.document.forms['view_form'].submit()", '', false);
    
    ////////////////////////
    // contacts_list
    ////////////////////////
    $this->_sections['contacts_list'] = array();
    $tabs = array('all',"abc","def","ghi","jkl","mno","pqrs","tuv","wxyz","!19");
    foreach($tabs as $t) {
      $c = 0;
      $k = false;
      while(!$k || (array_key_exists($k,$this->_keys) && $c < strlen($t))) {
        $k = strtoupper(substr($t,$c,1));
        if( $k == '!' ) { $k = false; }
        $c++;
      }
      $this->_sections['contacts_list']["$k"] = array($t, "updateUrl('setmode','$t')", '', false);
    }
    $this->_sections['contacts_list']['ALT+O'] = array("Company",  "updateUrl('overview', 'company')", '', false);
    $this->_sections['contacts_list']['ALT+E'] = array("External", "updateUrl('overview', 'external')", '', false);
    $this->_sections['contacts_list']['ALT+I'] = array("Internal", "updateUrl('overview', 'internal')", '', false);
    
    ////////////////////////
    // log
    ////////////////////////
    $this->_sections['log'] = array();
    $this->_sections['log']['ALT+L'] = array('Show All Logs', "window.document.getElementById('systemLogFilterCheckbox').click()", '', false);
    
    ////////////////////////
    // login
    ////////////////////////
    $this->_sections['login'] = array();
    $f = "window.document.forms['loginForm']";
    $this->newFxn("loginAutoCheck", "{$f}.elements['save_my_password'].checked = !window.document.forms['loginForm'].elements['save_my_password'].checked;");
    $this->_sections['login']['ALT+L'] = array('Log On', "{$f}.submit()", '', false);
    $this->_sections['login']['ALT+A'] = array('In the future, log me in automatically (using a cookie)', "loginAutoCheck()", '', false);
    $this->_sections['login']['ALT+N'] = array('Login Name', "{$f}.elements['username'].select()", '', false);
    $this->_sections['login']['ALT+W'] = array('Password', "{$f}.elements['passphrase'].select()", '', false);
    
    ////////////////////////
    // options
    ////////////////////////
    $this->_sections['options'] = array();
    $this->_sections['options']['ALT+L'] = array('Log Off',
        "KeyEvent.createLoadUrl('{rootUrl}/index.php?logoff=1')", 
        "Log out of ".$this->_zen->getSetting('system_name'), false);
    $this->_sections['options']['ALT+W'] = array('Change Password', "KeyEvent.createLoadUrl('{rootUrl}/misc/pwc.php')", '', false);
    $this->_sections['options']['ALT+A'] = array('Set Auto-Login', "KeyEvent.createLoadUrl('{rootUrl}/misc/autologin.php')", '', false);
    $this->_sections['options']['ALT+H'] = array('Change Home Bin', "KeyEvent.createLoadUrl('{rootUrl}/misc/homebin.php')", '', false);
    $this->_sections['options']['ALT+G'] = array('Set Language', "KeyEvent.createLoadUrl('{rootUrl}/misc/language.php')", '', false);
    
    ////////////////////////
    // paging
    ////////////////////////
    $this->_sections['paging'] = array();
    $this->_sections['paging']['ALT+E'] = array('Prev', "window.location = window.document.getElementById('pagingPrevLink').href", '', false);
    $this->_sections['paging']['ALT+X'] = array('Next', "window.location = window.document.getElementById('pagingNextLink').href", '', false);
    
    ////////////////////////
    // project_tasks
    ////////////////////////
    $this->_sections['project_tasks'] = array();
    $this->_sections['project_tasks']['ALT+A'] = array('Add Ticket to Project', "window.document.forms['newTicketHotkey'].submit()", '', false);
    $this->_sections['project_tasks']['ALT+R'] = array('Create Sub-Project', "window.document.forms['newProjectHotkey'].submit()", '', false);
    
    ////////////////////////
    // search_form
    ////////////////////////
    $this->_sections['search_form'] = array();
    $f = "window.document.forms['searchForm']";
    $this->_sections['search_form']['ALT+E'] = array('Search', "{$f}.submit()", '', false);
    $this->_sections['search_form']['ALT+O'] = array('Containing', "{$f}.elements['search_text'].select()", '', false);
    $this->_sections['search_form']['ALT+U'] = array('Summary', "{$f}.elements['search_fields[title]'].click()", '', false);
    $this->_sections['search_form']['ALT+D'] = array('Description', "{$f}.elements['search_fields[description]'].click()", '', false);
    
    ////////////////////////
    // tab_attachments
    ////////////////////////
    $this->_sections['tab_attachments'] = array();
    $this->_sections['tab_attachments']['ALT+D'] = array('Delete Attachments', "window.document.forms['deleteAttachmentForm'].submit()", '', false);
    $this->_sections['tab_attachments']['ALT+A'] = array('Add Attachment', "window.document.forms['addAttachmentForm'].submit()", '', false);
    
    ////////////////////////
    // tab_contacts
    ////////////////////////
    $this->_sections['tab_contacts'] = array();
    $this->_sections['tab_contacts']['ALT+N'] = array('Create New Contact', "window.document.forms['newContactForm'].submit()", '', false);
    $this->_sections['tab_contacts']['ALT+A'] = array('Add Contact', "window.document.forms['ContactsAddForm'].submit()", '', false);
    $this->_sections['tab_contacts']['ALT+D'] = array('Drop Contacts', "window.document.forms['dropContactsForm'].submit()", '', false);
    $this->_sections['tab_contacts']['ALT+Y'] = array('Field: company_id', "window.document.forms['ContactsAddForm'].elements['company_id'].focus()", 'Company', false);
    $this->_sections['tab_contacts']['ALT+E'] = array('Field: person_id', "window.document.forms['ContactsAddForm'].elements['person_id'].focus()", 'Person', false);
    
    ////////////////////////
    // tab_notify
    ////////////////////////
    $this->_sections['tab_notify'] = array();
    $this->_sections['tab_notify']['ALT+D'] = array('Drop Recipients', "window.document.forms['dropNotifyForm'].submit()", '', false);
    $this->_sections['tab_notify']['ALT+A'] = array('Add Recipients', "window.document.forms['notifyAddForm'].submit()", '', false);
    
    ////////////////////////
    // ticket_fields_editable
    ////////////////////////
    $this->_sections['ticket_fields_editable'] = array();
    $this->_sections['ticket_fields_editable']['ALT+A'] = array('Save', "window.document.forms['ticketTabForm'].submit()", '', false);
    
    ////////////////////////
    // ticket_view
    ////////////////////////
    $this->_sections['ticket_view'] = array();
    $map = $GLOBALS['zt_map'];
    $t = 'ticket';
    $j = 1;
    for($i=1; $i<=8; $i++) {
      $view = "{$t}_tab_{$i}";
      if( $map->getViewProp($view, 'visible') ) {
        $this->_tabkeys[$view] = $j;
        $label = $map->getViewProp($view,'label');
        $this->_sections['ticket_view']["$j"] = array($label, "KeyEvent.createLoadUrl('{rootUrl}/ticket.php?id={id}&setmode=$view')", '', false);
        $j++;
      }
    }
    
    ////////////////////////
    // project_view
    ////////////////////////
    $this->_sections['project_view'] = array();
    $map = $GLOBALS['zt_map'];
    $t = 'project';
    $j = 1;
    for($i=1; $i<=8; $i++) {
      $view = "{$t}_tab_{$i}";
      if( $map->getViewProp($view, 'visible') ) {
        $this->_tabkeys[$view] = $j;
        $label = $map->getViewProp($view,'label');
        $this->_sections['project_view']["$j"] = array($label, "KeyEvent.createLoadUrl('{rootUrl}/ticket.php?id={id}&setmode=$view')", '', false);
        $j++;
      }
    }
    
  }
  var $_sections;
  
  function listSections() {
    return array_keys($this->_sections);
  }
  
  function listEntries( $sect ) {
    return $this->_sections[$sect];
  }
  
  /** Prepares hot keys for a given section of the app */
  function loadSection( $sect ) {
    $sect = strtolower($sect);
    if( in_array($sect, $this->_alreadyLoaded) ) {
      $this->_zen->addDebug('loadSection', "$sect already loaded", 3);
      return;
    }
    $this->_alreadyLoaded[] = $section;
    
    //todo load registered hot keys from database and assign here
    $this->_zen->addDebug('loadSection', "Loading section: $sect", 3);
    
    if( !array_key_exists($sect, $this->_sections) ) {
      $this->_zen->addDebug('loadSection', "$sect is not valid", 1);
      return;
    }
    
    foreach($this->_sections[$sect] as $k=>$v) {
      $this->assign($k, $v[0], $v[1], $v[2], $v[3]);
    }
  }
  
  var $_tabkeys;
  
  function getTabKeys() {
    return $this->_tabkeys;
  }
  
  function newFxn( $name, $code ) {
    if( array_key_exists($name, $this->_fxns) ) {
      $this->_zen->addDebug('ZenHotKeys->newFxn', "The fxn '$name' already exists", 1);
      return;
    }
    $this->_zen->addDebug('ZenHotKeys->assign', "Added fxn '$name'", 3);
    $this->_fxns["$name"] = $code;
  }
  
  function getFxnName($key) {
    return str_replace('KeyEvent.createLoadUrl', 'KeyEvent.loadUrl', $this->_keys[$key]['fxn']);
  }

  /** 
   * Adds a hot key to the list.  The fxn param accepts the following special
   * placeholders:
   * <ul>
   *  <li>{rootUrl} - replaced with the value of $rootUrl in www/header.php
   *  <li>{id} - replaced with the current ticket/project/contact/agreement id (if any)
   * </ul>
   *
   * @param String $key a hot key such as 'ALT+SHIFT+Y'
   * @param String $label name of the hot key
   * @param String $fxn name of function to call when hot key is pressed
   * @param String $description tooltip text (defaults to label)
   */
  function assign( $key, $label, $fxn, $description = '', $global = false ) {
    global $id; global $rootUrl;

    // if the hot key doesn't exist, we fail and don't add anything
    $key = strtoupper($key);
    if( array_key_exists($key, $this->_keys) ) {
      $this->_zen->addDebug('ZenHotKeys->assign', "The key '$key' already exists and will not have a hot key", 1);
      return;
    }

    // add the label if it is not a duplicate... items which duplicate the label
    // cannot appear together
    if( array_key_exists($label, $this->_idx) ) {
      $this->_zen->addDebug('ZenHotKeys->assign', "The label '$label' already exists for key '".$this->_idx["$label"]."', this hotkey cannot be looked up by label accurately", 2);
    }
    else {
      $this->_idx["$label"] = $key;
    }
    
    // if there is no description, we use the label for this field
    if( !$description ) { $description = $label; }
    
    // replace special variables in the function call with current values
    $fxn = str_replace("{rootUrl}", $rootUrl, $fxn);
    $fxn = str_replace("{id}", $id, $fxn);
    
    // actually create the key assignment now
    $this->_zen->addDebug('ZenHotKeys->assign', "Added key '$key' for label '$label' and fxn '$fxn'", 3);
    $this->_keys["$key"] = array('label'=>$label, 'fxn'=>$fxn, 'description'=>$description, 'global'=>$global);
  }
  
  function disableAction( $key ) {
    $this->_keys["$key"]["fxn"] = 'doNothing';
  }
  
  /**
   * Return the hot key for a given label (the section must be loaded unless
   * this label appears in 'all')
   *
   * @param String $label
   * @return String the key for this label
   */
  function find( $label ) {
    if( !array_key_exists("$label", $this->_idx) ) { return false; }
    return $this->_idx["$label"];
  }
  
  
  /** Returns a tooltip for a given label */
  function tt( $label ) {
    $key = $this->find($label);
    if( !$key ) {
      $this->_zen->addDebug('ZenHotKeys->tt', "Invalid label '$label'", 1);
      return $label;
    }
    return $this->tooltip($key, $override_text = '');
  }
  
  /** Returns a parsed/translated label for a given label */
  function ll( $label, $override_text = '', $supress_key = false ) {
    $key = $this->find($label);
    if( !$key ) {
      $this->_zen->addDebug('ZenHotKeys->ll', "Invalid label '$label'", 1);
      return $override_text? $override_text : $label;
    }
    return $this->label($key, $override_text, $supress_key);
  }
  
  /** 
   * Return a tooltip message for a given key, this will be translated and
   * the hot key will be appended
   */
  function tooltip( $key ) {
    $key = strtoupper($key);
    return $this->_zen->ffv(tr($this->_keys["$key"]["description"])." ($key)");
  }
  
  /**
   * Return description for a given key, translated and escaped
   *
   * If the description is the same as the label, it will be skipped.
   */
  function description( $key ) {
    $key = strtoupper($key);
    $x = $this->_keys["$key"];
    if( $x["description"] == $x["label"] ) { return "&nbsp;"; }
    return $this->_zen->ffv(tr($x["description"]));
  }
  
  /** 
   * Return a label for a given key, this will be translated
   * and the hot key will be underlined if possible
   */
  function label( $key, $override_text = '' ) {
    $key = strtoupper($key);
    $char = $this->_getChar($key);
    $lchar = strtolower($char);
    $label = $override_text? tr($override_text) : tr($this->_keys["$key"]["label"]);
    $label = preg_replace('@^(Action|Field): @', '', $label);
    $label = str_replace('_', ' ', $label);
    $pos = strpos($label, $char);
    if( $pos === false ) { $pos = strpos($label, $lchar); $char = $lchar; }
    $len = strlen($label);
    if( $pos === 0 ) {
      // matched at beginning of string
      $txt = "<u>{$char}</u>".substr($label,1);
    }
    else if( $pos > 0 && $pos == $len-1 ) {
      // matched at end of string
      $txt = substr($label,0,$len-1)."<u>{$char}</u>";
    }
    else if( $pos > 0 ) {
      // matched inside the string
      $txt = substr($label,0,$pos)."<u>{$char}</u>".substr($label,$pos+1);
    }
    else {
      // no match, just return the label
      //return $label."<sub class='note'>$char</sub>";
      $txt = $label;
    }
    //if( !$supress_key ) { $txt .= $this->renderAccessKey($key); }
    $txt .= $this->addZenTab($key);
    return $txt;
  }
  
  /**
   * Renders any custom functions defined here.
   */
  function renderFunctions() {
    if( !count($this->_fxns) ) { return; }
    foreach( $this->_fxns as $k=>$v ) {
      print "function $k() {\n";
      print $v;
      print "}\n\n";
    }
     
  }
  
  /** 
   * Create javascript code needed for
   * hot keys to function.  Depends on the keyevents.js file
   *
   * This is meant to be used inside of the onload fxn for the page.   */
  function renderKeys() {
    if( !count($this->_keys) ) { return; }
    foreach( $this->_keys as $k=>$v ) {
      if( $this->_getAccessKey($k) || array_key_exists($k,$this->_keysRendered) ) { continue; }
      $this->_keysRendered[$k] = 1;
      $f = $v['fxn'];
      if( strpos($f,'KeyEvent.createLoadUrl')===false ) { $f = Zen::fixJsVal($f); }
      print "\tKeyEvent.register($f, '$k');\n";
    }
    foreach( $this->_tabs as $t=>$k ) {
      print "\tZenTabs.singleton.register('keySub_$t');\n";
    }
  }
  
  /**
   * create javascript code needed for
   * accesskey functions
   */
  function renderAccessKeys() {
    $keys = array();
    foreach($this->_keys as $k=>$v) {
      print $this->renderAccessKey($k);
    }
  }
  
  /**
   * Render a single access key, done this way so that they will focus near
   * the appropriate field, when possible
   */
  function renderAccessKey( $k ) {
    $v = $this->_keys[$k];
    if( array_key_exists($k,$this->_keysRendered) ) { return; }
    if( $key = $this->_getAccessKey($k) ) {
      $this->_keysRendered[$k] = 1;
      $fxn_parsed = Zen::fixJsHtml($v['fxn']);
      $fxn_parsed = str_replace('KeyEvent.createLoadUrl', 'KeyEvent.loadUrl', $fxn_parsed);
      return "<input type='button' name='accessKeyButton{$key}' value='' accesskey='{$key}' class='accesskeys' onclick=$fxn_parsed>";
    }
    return null;
  }
  
  /** Returns letter used to access this key if it is an accesskey */
  function _getAccessKey( $key ) {
    preg_match('@^ALT[+](\w)$@', $key, $matches);
    return count($matches)>1? $matches[1] : false;
  }
  
  /** Splits a key and returns the letter to be used */
  function _getChar( $key ) {
    return preg_replace('@^.*[+]@', '', $key);
  }
  
  function getChar( $key ) {
    return $this->_getChar($key);
  }
  
  /** Creates html output to display help info */
  function renderHelp() {
    print "<table width='300' border='0' cellspacing='1' cellpadding='2'><tr><td class='titleCell'>Hot Key</td><td class='titleCell'>Function</td></tr>";
    $keys = $this->_keys;
    uasort($keys, 'sortHotKeyTable');
    foreach( $keys as $k=>$v ) {
      print "<tr><td class='hotKeyCell'>$k</td><td class='hotKeyCell'>"
      .$this->label($k)."</td></tr>";
    }
    print "</table>\n";
  }
  
  /** Store a key that will be used to display subtext on tabs */
  function addZenTab( $key ) {
    $count = 1;
    $id = $key.$count++;
    while( array_key_exists($id, $this->_tabs) ) {
      $id = $key.$count++;
    }
    $this->_tabs[$id] = $key;
    return "<div id='keySub_$id' class='keySub".$this->_lh()."'>$key</div>";
  }
  
  function addZenTabByLabel($label) {
    $this->addZenTab($this->find($label));
  }
  
  function _lh() {
    return $this->_alternate? $this->_lh == 'High'? 'Low' : 'High' : "High";
  }
  
  var $_alternate;
  var $_lh;
  var $_fxns;
  var $_zen;
  var $_keys;
  var $_idx;
  var $_alreadyLoaded;
  var $_tabs;
  var $_keysRendered;
}

/** Must be declared outside of class to work with php */
function sortHotKeyTable( $a, $b ) {
  $a['label'] = preg_replace('@^(Action|Field): @', '', $a['label']);
  $b['label'] = preg_replace('@^(Action|Field): @', '', $b['label']);
  return strnatcmp($a['label'], $b['label']);
}

?>