<?php
/*
   Mod Manager 12 Mod Lising Class

   Class extends modparser.  It lists mod config filesaccording to selectable
   filters, does basic error checking, shows identifying information, displays
   installation status and lists files affected.

   Incorporates 1) mod listing enhancements by Robin Richmond and 2) a button
   by Jeff Robison to show detailed status for Installed or OK to install mods
   (default is not to show any detail for them.)


   Public Methods:
      $this->list_mods();
*/

include_once 'classes/modparser.class.php';

class modlister extends modparser
{

  /*
     // filter
     const F_ALL = 0;
     const F_READY = 1;
     const F_INSTALLED = 2;
     const F_CLEAN = 3;
     const F_BADCFG = 4;
     const F_SELECT = 5;

     // sorting
     const NAMECOL = "0";
     const FILECOL = "1";

     // processing
     const INSTALL = 1;
     const REMOVE = 2;
     const DELETE = 3;
     const CLEANUP = 4;
     const EDITP = 5;
     const UPDATEP = 6;
     const RESTOREP = 7;

     // status
     //const OK2INST     = 'ok2inst';
     const PARTINST    = 'partinst';
     //const INSTALLED   = 'installed';
     const NOTINST     = 'notinst';
     const LINE        = 'line';

     // errors
     const NOPARAM     = 'noparam';
     const NOLOCATION  = 'nolocation';
     const NOACT       = 'noact';
  */

  protected $classID = "lister";

  public $filter = self::F_ALL;
  public $fbox_checked = false;
  public $modlist = array();

  protected $parameters = 0;
  protected $num_errors = 0;
  protected $num_required = 0;
  protected $mods_required = 0;
  protected $copies_required = 0;
  protected $newfiles_required = 0;
  protected $newdirs_required = 0;
  protected $num_installed = 0;
  protected $mods_installed = 0;
  protected $copies_installed = 0;
  protected $newfiles_installed = 0;
  protected $newdirs_installed = 0;
  protected $provisional_errors = 0;
  protected $status_string = '';
  protected $warning = '';

  function __construct($objinits) {
    parent::__construct($objinits);
  }

  public function list_mods() {

    // SEE IF USER'S MOD OPTIONS FILE NEEDS UPDATING
    if (!isset($this->delete_support)) {
      $sysmsg = $this->admtext['updateopts'];
    }

    // APPROVED LIST OF MODFILES PASSED BY FILTER FOR DISPLAY
    $selected_mods = array();
    if (!empty($this->modlist)) {
      foreach ($this->modlist as $modfile) {
        $selected_mods[] = pathinfo($modfile, PATHINFO_BASENAME);
      }
    }
    // fix capitalization in admtext array
    $this->admtext['line'] = strtolower($this->admtext['line']);

    /*******************************************************************
     * FILTER WHICH MODS ARE LISTED
     *******************************************************************/
    $lockit = "";

    // SET SELECTED VALUE FROM FILTER DROP DOWN LIST
    $s0 = $s1 = $s2 = $s3 = $s4 = $s5 = '';
    ${'s' . $this->filter} = "selected";

    // FIXED OR SCROLLING HEADER & FILTER BAR?
    $fbclass = $this->fix_header == self::YES ? "fbar-fixed" : "fbar-scroll";
    $mmlistclass = $this->fix_header == self::YES ? "mmlist-fixed" : "mmlist-scroll";

    // SET FILTER BAR ACTION BUTTONS
    $btnline = $this->setup_filter_line($this->filter);

    // FILTER LOCK AND BATCH OPERATIONS FILE SELECTOR
    if ($this->filter != self::F_ALL) {

      // set lock on by default for this filter
      if ($this->filter == self::F_SELECT) {
        $cbchecked = 'checked';
        $_SESSION['filter'] = self::F_SELECT;
      } else {
        $cbchecked = $this->fbox_checked ? "checked" : "";
      }
      $lockit .= "
            {$this->admtext['stayon']}&nbsp;&nbsp;<input type=\"checkbox\" id=\"stayon\" $cbchecked/>";

      $selectboxes = "
         <button type=\"button\" id=\"selectAll\">
            {$this->admtext['selectall']}
         </button>
         &nbsp;&nbsp;
         <button type=\"button\" id=\"clearAll\">
            {$this->admtext['clearall']}
         </button>";
    } else {
      $selectboxes = '';
    }
    /*******************************************************************
     * SHOW THE MOD FILTER BAR
     *******************************************************************/
    // MAKE ENGLISH CHOICES CONSISTENT IN FILTER STATUS DROPDOWN MENU
    $this->admtext['partinst'] = ucfirst($this->admtext['partinst']);
    $this->admtext['cantinst'] = ucfirst($this->admtext['cantinst']);

    // RETURN NEW FILTER STATUS TO MODHANDLER FOR REDISPLAY IF CHANGED BY USER
    echo "
<form action=\"admin_modhandler.php\" method=\"POST\">
<table id=\"fbar\" class=\"normal lightback $fbclass\">
   <tr>
      <td class=\"fieldnameback fieldname mmpadtop5\">
         <div class=\"float-left\">
         &nbsp;{$this->admtext['statusfilter']}:&nbsp;
         <select name=\"filter\" >
            <option $s0 value=" . self::F_ALL . ">{$this->admtext['all']}</option>
            <option $s1 value=" . self::F_READY . ">{$this->admtext['ready']}</option>
            <option $s2 value=" . self::F_INSTALLED . ">{$this->admtext['installed']}</option>
            <option $s3 value=" . self::F_CLEAN . ">{$this->admtext['partinst']}</option>
            <option $s4 value=" . self::F_BADCFG . ">{$this->admtext['cantinst']}</option>
            <option $s5 value=" . self::F_SELECT . ">{$this->admtext['choose']}</option>
         </select>
         <input type=\"submit\" name=\"newlist\" value=\"{$this->admtext['go']}\" />
         &nbsp;&nbsp;$lockit&nbsp;&nbsp;$selectboxes &nbsp;&nbsp; $btnline
         </div>
    </td>
   </tr>
</table>";
    /*******************************************************************
     * GET SORTED CFG FILE NAMES AND PREPARE COLUMN HEADER SORT ICONS
     *******************************************************************/
    $modlisting = $this->get_modlist_sorted();

    // DISPLAY BIG SYSTEM MESSAGE IF NO MODFILES ARE FOUND
    if (empty($this->modspath)) {
      $sysmsg = "<span class=\"msgerror\">\$modspath {$this->admtext['missing']}";
    } elseif (empty($this->extspath)) {
      $sysmsg = "<span class=\"msgerror\">\$extspath {$this->admtext['missing']}";
    } elseif ($modlisting == self::NOPATH) {
      $sysmsg = "{$this->admtext['cannotopendir']}: " . rtrim($this->modspath, "/") . "!";
    } elseif ($modlisting == self::NOMODS) {
      $this->admtext['nomods'] = str_replace("xxx", "cfg", $this->admtext['nomods']);
      $sysmsg = "{$this->admtext['nomods']} - " . rtrim($this->modspath, "/");
    }


    // CONFIGURE COLUMN HEADER SORT ICONS
    $filesort = $namesort = '';
    if ($this->sortby == self::NAMECOL) {
      $filesort = "<a href=\"admin_modhandler.php?sort=" . self::FILECOL . "\"><img src=\"img/tng_sort_asc.gif\"
            width=\"15\" height=\"8\" border=\"0\" alt=\"\" title=\"{$this->admtext['text_sort']}\" /></a>";
      $namesort = "<img src=\"img/tng_sort_desc.gif\"
            width=\"15\" height=\"8\" border=\"0\" alt=\"\" />";
    } else {
      $namesort = "<a href=\"admin_modhandler.php?sort=" . self::NAMECOL . "\"><img src=\"img/tng_sort_asc.gif\"
            width=\"15\" eight=\"8\" border=\"0\" alt=\"\" title=\"{$this->admtext['text_sort']}\" /></a>";
      $filesort = "<img src=\"img/tng_sort_desc.gif\"
            width=\"15\" eight=\"8\" border=\"0\" alt=\"\" />";
    }

    /*******************************************************************
     * SHOW MOD LIST HEADINGS
     *******************************************************************/
    // uses bounding table to eliminate jumping during page load
    echo "
<table id=\"mmgrid\" class=\"lightback $mmlistclass\">
<tr class=\"databack\">
<td class=\"tngshadow\">

<table class=\"tfixed normal\">
   <tr>";

    // SHOW LEFT-SIDE SELECTION BOX HEADING IF A FILTER IS APPLIED
    if ($this->filter != self::F_ALL) {
      echo "
		<th class=\"fieldnameback fieldname center colselct\">
         <div class=\"mminner\">&nbsp;{$this->admtext['choose']}</div>
      </th>";
    }

    // DISPLAY THE MOD LISTING ROW HEADINGS
    echo "
      <th class=\"fieldnameback fieldname center colmodnm\">{$this->admtext['modname']}&nbsp;&nbsp;$namesort</th>
      <th class=\"fieldnameback fieldname center colcfgnm\">{$this->admtext['cfgname']}&nbsp;&nbsp;$filesort</th>
      <th class=\"fieldnameback fieldname center colversn\">{$this->admtext['version']}</th>
      <th class=\"fieldnameback fieldname center colwiki\">
         <div class=\"mminner\">
            {$this->admtext['wiki']}
         </div>
      </th>
      <th class=\"fieldnameback fieldname center colstatus\">{$this->admtext['status']}</th>
      <th class=\"fieldnameback fieldname center colaflist\"><strong>{$this->admtext['aflist']}</strong></th>
   <tr>";

    $id = 0;
    $ix = 0;
    $dbx = 0;
    $dbclass = 'databackalt';
    // if a system message has been set, show it here and quit
    if (!empty($sysmsg)) {
      $this->sys_msg($sysmsg);
      return;
    }
    /*******************************************************************
     * LIST STATUS OF EACH MOD IN THE MOD DIRECTORY
     *******************************************************************/
    foreach ($modlisting as $cfgfile => $modname) {
      if (!empty($selected_mods) && !in_array($cfgfile, $selected_mods)) {
        continue;
      }

      // INITIALIZE DYNAMIC ELEMENTS FOR THIS MOD
      // mod info
      $this->cfgfile = $cfgfile;
      $this->cfgpath = $this->rootpath . $this->modspath . '/' . $cfgfile;
      $this->status_string = '';
      $this->description = $this->note = $this->private = $this->wikipage = $wikilink = '';
      $istarget = false;
      $authors = array();

      // statistics
      $this->num_required = 0;
      $this->mods_required = 0;
      $this->copies_required = 0;
      $this->newfiles_required = 0;
      $this->newdirs_required = 0;
      $this->num_installed = 0;
      $this->mods_installed = 0;
      $this->copies_installed = 0;
      $this->newfiles_installed = 0;
      $this->newdirs_installed = 0;
      $this->parameters = 0;
      $this->num_errors = 0;
      $this->provisional_errors = 0;
      $this->init_status();

      // init data array for affected_files_listing() function
      $aff_files = array(
              'afchange' => array(),
              'afcopy' => array(),
              'afcopy2' => array(),
              'afcreate' => array()
      );
//echo __LINE__;print_r( $this->cfgpath);exit;
      $tags = $this->parse($this->cfgpath);
      $istarget = false;

      // PROCESS THE PARSE TABLE USING WHILE LOOP
      while (empty($this->parse_error)) {
        $this->warning = '';
        /*************************************************************
         * CHECK FOR MISSING TAGS (REQUIRED)
         *************************************************************/
        // REQUIRED TAGS
        if (false === $this->find_tagname_value($tags,
                        'name', 'name')) {
          $this->parse_error['line'] = '0';
          $this->parse_error['tag'] = '%name:';
          $this->parse_error['text'] = self::REQTAG; // index into admtext[]
        } elseif (false === $this->find_tagname_value($tags,
                        'name', 'version')) {
          $this->parse_error['line'] = '0';
          $this->parse_error['tag'] = '%version:';
          $this->parse_error['text'] = self::REQTAG; // index into admtext[]
        } elseif (false === $this->find_tagname_value($tags,
                        'name', 'description')) {
          $this->parse_error['line'] = '0';
          $this->parse_error['tag'] = '%description:';
          $this->parse_error['text'] = self::NOCOMPS; // index into admtext[]
        }
        if (!empty($this->parse_error)) {
          break;
        }
        /*************************************************************
         * PROCESS THE PARSE TABLE FOR THE CURRENT MOD
         *************************************************************/
        $this->isprivate = false;
        for ($j = 0; isset($tags[$j]); $j++) {
          /**********************************************************
           * INFO OR NOT PROCESSED FOR LISTING
           **********************************************************/
          switch ($tags[$j]['name']) {
            case 'private':
              $this->isprivate = true;
            case 'name':
            case 'version':
            case 'description':
            case 'note':

            case 'wikipage':
              // create variable from the name and assign its value
              $this->{$tags[$j]['name']} = $tags[$j]['arg1'];
              continue 2; // DO NOT CONTINUE PROCESSING THIS TAG
            case 'author':
              $authors[] = !empty($tags[$j]['arg2']) ?
                      "<a href=\"{$tags[$j]['arg2']}\" target=\"_blank\">
                           {$tags[$j]['arg1']}</a>"
                      : $tags[$j]['arg1'];
              $this->authors = $authors;
              continue 2; // DO NOT CONTINUE PROCESSING THIS TAG
            case 'desc':
              // error - tag should have been processed with parameter
              $this->parse_error['line'] = $tags[$j]['line'];
              $this->parse_error['tag'] = '%desc:';
              $this->parse_error['text'] = self::NOPARAM;
              break 3; // ERROR - BAIL AND STOP PROCESSING ANY MORE TAGS
            case 'replace':
            case 'trimreplace':
            case 'insert:before':
            case 'insert:after':
            case 'vinsert:before':
            case 'vinsert:after':
            case 'triminsert:before':
            case 'triminsert:after':
              // error- tag should have been processed with location
              $this->parse_error['line'] = $tags[$j]['line'];
              $this->parse_error['tag'] = '%' . $tags[$j]['name'] . ':';
              $this->parse_error['text'] = self::NOLOCATION;
              break 3; // fatal error - break out of parser
            default:
              break;
          }
          // CONTINUE PROCESSING TAG
          /**********************************************************
           * TARGETS - GET FILE CONTENTS
           **********************************************************/
          if ($tags[$j]['name'] == 'target') {
            $flag = $tags[$j]['flag'];
            if ($tags[$j]['arg1'] == 'files') {
              continue;
            }
            $target_location_count = 1;
            $active_target_file = '';
            $istarget = false;

            // ONLY A RELATIVE PATH IS NEEDED FOR SCREEN DISPLAYS
            $display_path = str_replace($this->rootpath, '', $tags[$j]['arg1']);

            // MAINTAIN AFFECTED FILES LIST
            $aff_files['afchange'][] = $display_path;

            // SPECIAL NOTE ASSOCIATED WITH THIS TARGET?
            if (!empty($tags[$j]['arg3'])) {
              $notestr = "<div class=\"target-note\">{$tags[$j]['arg3']}</div><br />";
            } else {
              $notestr = '';
            }

            // INCORPORATE ROBIN RICHMOND'S CODE TO BREAK UP LONG LINES OF TEXT FOR DISPLAY
            $display_path = $this->foldable_string($display_path);

            $statstring = "$notestr<div class=\"list-indent\">{$this->admtext['line']} {$tags[$j]['line']}: <span class=\"target\">%<span class=\"tag\">target:</span><span class=\"tgtfile\">$flag$display_path</span>%</span>&nbsp;";

            // GET CODE FROM TARGET FILE INTO BUFFER FOR EXAMINATION
            // function increases global error count if unable to read
            $target_file_contents = $this->read_file_buffer(
                    $tags[$j]['arg1'], $flag);

            // NOTE FILE RETRIEVAL ERRORS IF ANY
            if (is_numeric($target_file_contents)) {
              switch ($target_file_contents) {
                case self::BYPASS: // not an error
                  if ($this->num_installed > 0) {
                    $statstring .= "{$this->admtext['optmissing']}&nbsp;<span class=\"msgapproved\">{$this->admtext['bypassed']}</span>";
                  } else {
                    $statstring .= "{$this->admtext['optmissing']}&nbsp;<span class=\"msgapproved\">{$this->admtext['willbypass']}</span>";
                  }
                  $this->set_status($statstring);
                  break;
                case self::NOFOUL:
                  if ($this->num_installed > 0) { // mod has been installed
                    $statstring .= "<span class=\"hilighterr msgbold\">{$this->admtext['tgtmissing']}&nbsp;{$this->admtext['provisional']}</span>";
                  } else { // mod not installed - no error yet
                    $statstring .= "{$this->admtext['tgtmissing']}&nbsp;<span class=\"msgapproved\">{$this->admtext['provisional']}</span>";
                  }
                  $this->set_status($statstring);
                  break;
                case self::NOFILE:
                  $statstring .= "<span class=\"hilighterr msgbold\">{$this->admtext['tgtmissing']}</span>";
                  $this->set_status($statstring);
                  break;
                case self::NOWRITE:
                  $statstring .= "<span class=\"hilighterr msgbold\">{$this->admtext['notwrite']}</span>";
                  $this->set_status($statstring);
                  break;
                case self::ISEMPTY:
                  $statstring .= "<span class=\"msgerror\">{$this->admtext['emptyfile']}</span>";
                  $this->set_status($statstring);
                  break;
                default:
                  break;
              }
            } else {
              $statstring .= "{$this->admtext['verified']}";
              $this->set_status($statstring);
              $istarget = true;
              $active_target_file = $tags[$j]['arg1'];
            }
            continue;
          } // TARGETS

          /**********************************************************
           * PARAMETERS - JUST LOG THEM - MAKE SURE DESC TAG FOLLOWS
           **********************************************************/
          elseif ($tags[$j]['name'] == 'parameter') {
            if (!$istarget) {
              $j++;
              continue;
            }
            // IS THE NEXT TAG DESC (REQUIRED)?
            if ($tags[$j + 1]['name'] != 'desc') {
              $this->parse_error['line'] = $tags[$j]['line'];
              $this->parse_error['tag'] = '%desc:';
              $this->parse_error['text'] = self::REQTAG; // index into admtext[]
              break 2; // break out of the entire processing loop
            }
            $this->parameters++;
            $paramstr = $this->foldable_string("{$tags[$j]['arg1']}:{$tags[$j]['arg2']}");
            $statstring = "<div class=\"list-indent\">{$this->admtext['line']} {$tags[$j]['line']}: %<span class=\"tag\">parameter:$paramstr</span>%&nbsp;";
            $this->set_status($statstring);
            $j++; // skip 'desc' - nothing is done with it in the listing
            continue;
          } /**********************************************************
           * LOCATION - VALIDATE OPTAG - TEST VALUES WITH TARGET FILES
           **********************************************************/
          elseif ($tags[$j]['name'] == 'location') {
            if (!$istarget) {
              $j++;
              continue;
            }
            // next tag should be the optag (action tag)
            $optag = $tags[$j + 1]['name'];
            if (!in_array($optag, $this->optags)) {
              $this->parse_error['line'] = $tags[$j]['line'];
              $this->parse_error['tag'] = '%location:';
              $this->parse_error['text'] = self::NOACT;
              break 2; // break out of the entire processing loop
            }

            $this->num_required++;
            $this->mods_required++;

            // SPECIAL NOTE ASSOCIATED WITH THIS LOCATION?
            $notestr = '';


            if (!empty($tags[$j]['arg3'])) {
              $notestr = "<span class=\"location-note\">{$tags[$j]['arg3']}</span><br />";
            } else {
              $notestr = '';
            }

            $statstring = "$notestr{$this->admtext['line']} {$tags[$j]['line']}: <span class=\"tag\">%location:% #$target_location_count</span>&nbsp;";
            $tng_code = $tags[$j]['arg1']; // LOCATION CODE
            $j++;
            $new_code = $tags[$j]['arg1']; // OPTAG CODE

            // CHECK FOR EMPTY OPTAG CODE -> CANNOT INSTALL
            $nc = trim($new_code);
            if (empty($nc)) {
              $this->num_errors++;
              $statstring .= "<span class=\"hilighterr msgbold\">$optag {$this->admtext['errors']}</span>";
              $this->set_status($statstring);
              continue;
            }

            $tng_code_trimmed = trim($tng_code, " \t");
            $target_location_count++;
            /*******************************************************
             * CONFIGURE CODE STRINGS DEPENDING ON OPTAG
             *******************************************************/
            switch ($optag) {
              case "insert:before":
              case "vinsert:before";
                $tngcode = $tng_code_trimmed;
                $newcode = $new_code . "\r\n";
                break;
              case "insert:after":
              case "vinsert:after":
                $tngcode = $tng_code_trimmed;
                $newcode = "\r\n" . $new_code;
                break;
              case "replace":
                $tngcode = $tng_code_trimmed;
                $newcode = $new_code;
                break;
              case "triminsert:before":
                $tngcode = $tng_code;
                $newcode = $new_code . $tng_code;
                break;
              case "triminsert:after":
                $tngcode = $tng_code;
                $newcode = $tng_code . $new_code;
                break;
              case "trimreplace":
                $tngcode = $tng_code;
                $newcode = $new_code;
                break;
              default:
                break;
            }

            // SET GLOBAL STATUS STRING FOR THIS LOCATION
            $this->validate_location($target_file_contents,
                    $tngcode, $newcode, $optag, $statstring);
            continue; // TO NEXT TAG
          } // location
          /**********************************************************
           * FILE COPY OPERATIONS - TEST & REPORT STATUS
           **********************************************************/
          elseif ($tags[$j]['name'] == 'copyfile') {

            // MAINTAIN AFFECTED FILES LIST - USE RELATIVE PATH
            $aff_files['afcopy'][] = str_replace($this->rootpath, '', $tags[$j]['arg2']);

            // SET GLOBAL STATUS STRING FOR THIS COPYFILE OP
            $this->copyfile_status_check($tags[$j]);
          } elseif ($tags[$j]['name'] == 'copyfile2') {
            // MAINTAIN AFFECTED FILES LIST - USE RELATIVE PATH
            $aff_files['afcopy2'][] = str_replace($this->rootpath, '', $tags[$j]['arg2']);

            // SET GLOBAL STATUS STRING FOR THIS COPYFILE OP
            $this->copyfile_status_check($tags[$j]);
            continue;
          } /**********************************************************
           * NEWFILE - TEST & REPORT STATUS
           **********************************************************/
          elseif ($tags[$j]['name'] == 'newfile') {

            // MAINTAIN AFFECTED FILES LIST - USE RELATIVE PATH
            $aff_files['afcreate'][] = str_replace($this->rootpath, '', $tags[$j]['arg1']);

            // SET GLOBAL STATUS STRING FOR THIS NEWFILE
            $this->newfile_status_check($tags[$j]);
            continue;
          } /**********************************************************
           * MKDIR - TEST & REPORT STATUS
           **********************************************************/
          elseif ($tags[$j]['name'] == 'mkdir') {

            // SET GLOBAL STATUS STRING FOR THIS NEWFILE
            $this->mkdir_status_check($tags[$j]);
            continue;
          }

        } // TAGS TABLE PROCESSING
        break;
      } // WHILE NO PARSE ERRORS LOOP

      /****************************************************************
       * ASSIGN FINAL STATUS TO MOD
       ****************************************************************/
      $status = '';
      $error = '';


//Debug statistics
      /*
      echo __LINE__,'<br />';
      echo 'num_errors = ', $this->num_errors,'<br />';
      echo 'num_required = ', $this->num_required,'<br />';
      echo 'num_installed = ', $this->num_installed,'<br />';
      echo 'mods_required = ', $this->mods_required,'<br />';
      echo 'mods_installed = ', $this->mods_installed,'<br />';
      echo 'newdirs_required = ', $this->newdirs_required,'<br />';
      echo 'newdirs_installed = ', $this->newdirs_installed,'<br />';
      echo 'copies_required = ', $this->copies_required,'<br />';
      echo 'copies_installed = ', $this->copies_installed,'<br />';
      echo 'newfiles_required = ', $this->newfiles_required,'<br />';
      echo 'newfiles_installed = ', $this->newfiles_installed,'<br />';
      echo 'provisional_errors = ', $this->provisional_errors,'<br />';
      exit;
      */

      $status_header = '';
      // IF PARSE ERROR COMPLAIN AND QUIT
      if (!empty($this->parse_error)) {
        $this->num_errors++;
        $this->description = $this->admtext['cannotinstall'] . ". " . $this->admtext['needmodupdate'] . '.';
        $error .= "{$this->admtext['line']} {$this->parse_error['line']}: {$this->parse_error['tag']} <span class=\"msgerror\">
               {$this->admtext[$this->parse_error['text']]}</span><br />";
        $this->set_status($error);
        $status_header = self::CANTINST;
        $error = '';
      } // MOD PROCESSING COMPLETE - ANALYZE STATISTICS FOR STATUS (FOUR POSSIBLES)
      else {
        // Mod uninstalled - no mkdir errors
        // if the only thing installed is a directory which you may not
        // be able to remove --- show as uninstalled?

        if ($this->num_installed == $this->newdirs_installed) {
          $this->num_installed = 0;
          $this->newdirs_installed = 0;
        }

        // Mod installed
        if ($this->num_installed > 0 && (
                        $this->num_installed < $this->num_required ||
                        $this->provisional_errors > 0)) {
          $this->num_errors += $this->provisional_errors;
          $status_header = self::PARTINST;
        } // INSTALLED OR OK TO INSTALL - NO ERRORS
        elseif (!$this->num_errors) {
          if ($this->num_required > 0) {
            if ($this->num_installed == $this->num_required) {
              $status_header = self::INSTALLED;
            } elseif ($this->num_installed == 0) {
              $status_header = self::OK2INST;
            }
          }
        }
        // CAN'T INSTALL - WARNINGS OR ERRORS NOTED
        if (empty($status_header)) {
          $status_header = self::CANTINST;
          $filtered = array_filter($aff_files);
          if (empty($filtered) && $this->num_required == 0) {
            $this->warning = 'Mod makes no changes to target files!';
          }
        }
      }

      // OUTPUT FILTERED HERE NOW THAT STATUS OF MOD IS KNOWN
      if ($this->filter == self::F_INSTALLED) {
        if ($status_header != self::INSTALLED) {
          continue;
        }
      } elseif ($this->filter == self::F_READY) {
        if ($status_header != self::OK2INST) {
          continue;
        }
      } elseif ($this->filter == self::F_CLEAN) {
        if ($status_header != self::PARTINST) {
          continue;
        }
      } elseif ($this->filter == self::F_BADCFG) {
        if ($status_header != self::CANTINST) {
          continue;
        }
      }
      $id++;

      // HIDE STATUS DETAIL FOR OK TO INSTALL AND INSTALLED
      if ($status_header == self::OK2INST || $status_header == self::INSTALLED) {
        $status .= "<div id='hiddenstatus$id' style='display:block;'>" . $this->get_status() . "</div>";
      } else {
        $status .= $this->get_status();
      }

      // SET STYLES PER STATUS TYPE
      if ($status_header == self::PARTINST) {
        $status = str_replace(
                array("NINST", "NCOPY", "NCREATE"),
                array("hilight", "hilight", "hilight"),
                $status
        );
      } else {
        $status = str_replace(
                array("NINST", "NCOPY", "NCREATE"),
                array("none", "none", "none"),
                $status
        );
      }

      //CREATE DISPLAY STRING FOR MOD AUTHOR(S)
      $author_str = '';
      if (count($authors) > 1) {
        $author_str = "<strong>Authors</strong>: ";
      } elseif (count($authors) == 1) {
        $author_str = "<strong>Author</strong>: ";
      }
      if (!empty($author_str)) {
        foreach ($authors as $author) {
          $author_str .= $author . ' & ';
        }
        $author_str = rtrim($author_str, ' &') . '<br />';
      }

      // CONSTRUCT THE FOLDING STATUS DISPLAY
      $fstatus = $this->format_status($status_header, $error, $status, $author_str, $id);
      $aff_files = $this->affected_files_listing($id, $cfgfile, $modname, $aff_files);
      $wikilink = '';
      if (!empty($this->wikipage)) {
        $wiki = $this->wikibase . $this->wikipage;

        $wikilink = "
            <div class=\"mminner center\">
               <a href=\"$wiki\" target=\"_blank\"><img class=\"center\" src=\"classes/wiki16.png\"></a>
            </div>";
      }
      if (!$this->use_striping) {
        $dbclass = 'databack';
      } elseif ($this->stripe_after > 0) {
        if ($dbx % $this->stripe_after == 0) {
          $dbclass = $dbclass == 'databack' ? "databackalt" : 'databack';
        }
      }

      $dbx++;

      /****************************************************************
       * DISPLAY A LISTING LINE FOR THE MOD
       ****************************************************************/
      echo "
   <tr class=\"modline\">";
      if ($this->filter != self::F_ALL) {
        echo "
		<td class=\"mmcell $dbclass\">
         <div class=\"mminner center checkpad\">
            <input class=\"sbox\" type=\"checkbox\" name=\"mods[$ix][selected]\" value=\"1\" />
            <input type=\"hidden\" name=\"mods[$ix][file]\" value=\"$this->cfgfile\" target=\"_blank\" />
         </div>
      </td>";
        $ix++;
      }
      echo "
      <td id=\"flinka{$id}\" class=\"flink mmcell $dbclass\">
         <div class=\"mminner mmcellpad\">
            $id. <strong>";
      if (!empty($this->show_developer)) {
        $namestr = "<a style=\"text-decoration:none;\" href=\"admin_modtables.php?modfile=$cfgfile\" title=\"{$this->admtext['parsetable']}\" >{$this->modname}</a>";
      } else {
        $namestr = $this->modname;
      }

      echo "
            $namestr
            </strong>
         </div>
      </td>
      <td id=\"flinkb{$id}\" class=\"flink mmcell $dbclass\">
	  <!-- only add admtext['show'] to title tooltip if Show Developer is enabled -->
         <div class=\"mminner mmcellpad\" title=\"$cfgfile\">";
      if (!empty($this->show_developer)) {
        $filestr = "<a style=\"text-decoration:none;\" href=\"showcfg.php?mod={$this->modspath}/$cfgfile\"
                     target=\"_blank\" title=\"{$this->admtext['show']} $cfgfile\">$cfgfile</a>";
      } else {
        $filestr = $cfgfile;
      }
      echo "
            $filestr
         </div>
      </td>
      <td id=\"flinkc{$id}\" class=\"flink mmcell $dbclass center\">
         <div class=\"mminner mmcellpad\">";
      echo ltrim($this->version, "vV");
      echo "
         </div>
      </td>
      <td class=\"mmcell $dbclass center mmcellpad\">
         $wikilink
      </td>
      <td class=\"stcell\">
         $fstatus
      </td>
      <td class=\"afcell\">
         $aff_files
      </td>
   </tr>";
    }// FOREACH MOD FILE
    echo "
   </table>
   </td><!--tngshadow-->
   </tr><!--databack-->
   </table><!--mmlist-->
</form>";
    return isset($tags) ? $tags : array();
  } // FUNCTION LIST MODS

  /**********************************************************************
   * SUPPORTING FUNCTIONS
   **********************************************************************/
  private function foldable_string($string) {
    return preg_replace('@([\./_])@', '&#8203;$1', $string);
  }

  public function set_modfile($modfile) {
    $this->modlist = array($modfile);
  }

  public function get_last_status() {
    return $this->status_header;
  }

  protected function validate_location($buffer, $tngcode, $newcode, $optag, $statstring) {

    // VINSERT VARIABLES (ANY VALUE) ALREADY INSTALLED
    if ($optag == 'vinsert:before' || $optag == 'vinsert:after') {
      $num_vars = 0;
      $vars_installed = 0;
      preg_match_all("#(\\$[^\s=]+)\s*=+#sm", $newcode, $matches);
      $vars = $matches[1];
      $num_vars = count($vars);
      foreach ($vars as $var) {
        $count = substr_count($buffer, $var);
        if ($count > 1) {
          // VAR IS NOT UNIQUE
          $this->num_errors++;
          $statstring .= "$optag:$var&nbsp;<span class=\"hilighterr msgbold\">{$this->admtext['notunique']}</span>";
          $this->set_status($statstring);
          return false;
        }
        $vars_installed += $count;
      }
      if ($vars_installed > 0) {
        if ($vars_installed == $num_vars) {
          // ALL VARS ARE INSTALLED CORRECTLY
          $this->num_installed++;
          $this->mods_installed++;
          $statstring .= $this->admtext['installed'];
          $this->set_status($statstring);
          return true;
        } elseif ($vars_installed < $num_vars) {
          $this->provisional_errors++;
          $this->num_installed++;
          $statstring .= "$optag:&nbsp;<span class=\"hilighterr msgbold\">{$this->admtext['partinst']}</span>";
          $this->set_status($statstring);
          return false;
        }
      } else {
        // VARS ARE NOT YET INSTALLED
        $statstring .= "$optag:&nbsp;<span class=\"NINST\">{$this->admtext['notinst']}</span>";
        $this->set_status($statstring);
        return true;
      }
    }

    // NEW CODE ALREADY INSTALLED
    $already_installed = substr_count($buffer, $newcode);
    if ($already_installed) {
      $this->num_installed++;
      $this->mods_installed++;
      $statstring .= $this->admtext['installed'];
      $this->set_status($statstring);
      return true;
    }
    // NOT INSTALLED YET - CHECK TNG CODE
    $num_targets = substr_count($buffer, $tngcode);

    // INSERTING NEW CODE MIGHT RESULT IN 'NOT UNIQUE' CONDITION
    if ($num_targets == 1) {
      if ($optag != '%replace:%' && $optag != '%trimreplace:%') {
        if (false !== strpos($buffer, $newcode)) {
          $this->num_errors++;
          $statstring .= "<span class=\"hilighterr msgbold\">{$this->admtext['notunique']}</span>";
          $this->set_status($statstring);
          return false;
        }
      }
    }

    // MORE THAN ONE TARGET - SO NOT UNIQUE
    if ($num_targets > 1) {
      $this->num_errors++;
      $statstring .= "<span class=\"hilighterr msgbold\">{$this->admtext['notunique']}</span>";
      $this->set_status($statstring);
      return false;
    }

    // TNG CODE NOT FOUND - BAD TARGET
    if ($num_targets == 0) {
      $this->num_errors++;
      $statstring .= "<span class=\"hilighterr msgbold\">{$this->admtext['badtarget']}</span>";
      $this->set_status($statstring);
      return false;
    }

    // REPLACEMENT FRAGMENT ERROR?
    // If MM replaced a whole block of code based on a fragment, it would not be
    // able to restore it upon removal of the mod - so it is an error
    if ($optag == "replace") {
      $is_fragment = false;
      if (false !== $i = strpos($buffer, $tngcode)) {
        // ANY NON WHITE SPACE BEFORE TARGETED TNG CODE ON FIRST LINE?
        $p = $i;
        while ($p > 0) {
          $p--;
          if ($buffer[$p] == "\n") {
            break;
          }
          // NOT WHITE-SPACE? HERE IS A FRAGMENT!
          if ($buffer[$p] != " " && $buffer[$p] != "\t") {
            $is_fragment = true;
            break;
          }
        }

        if (!$is_fragment) {
          // CHECK EACH CHAR FOR NON-WHITE SPACE AFTER TARGET CODE ON LAST LINE
          $p = $i + strlen($tngcode); // last position in target str
          while (true) {
            if (!isset($buffer[$p])) { // EOF - no CRLF
              break;
            }
            if ($buffer[$p] == "\r") { // CRLF
              break;
            }
            // NOT WHITE-SPACE? HERE IS A FRAGMENT!
            if ($buffer[$p] != " " && $buffer[$p] != "\t") {
              $is_fragment = true;
              break;
            }
            $p++;
          }
        }
      }
      if ($is_fragment) {
        $this->num_errors++;
        $statstring .= "<span class=\"msgerror\">{$this->admtext['no_frag']}</span>";
        $this->set_status($statstring);
        return false;
      }
    }
    $statstring .= "<span class=\"NINST\">{$this->admtext['notinst']}</span>";
    $this->set_status($statstring);
    return true;
  } // VALIDATE LOCATION

  protected function copyfile_status_check($tag) {
    $flag = $tag['flag'];
    $line = $tag['line'];
    $srcpath = $tag['arg1'];
    $srcfilename = pathinfo($tag['arg1'], PATHINFO_BASENAME);
    $relsrcpath = str_replace($this->rootpath, '', $tag['arg1']);
    // add zero-length spaces to a %copyfile% source and destination paths so that they can wrap.
    $relsrcpath = $this->foldable_string($relsrcpath);
    $destpath = $tag['arg2'];
    $reldestpath = str_replace($this->rootpath, '', $tag['arg2']);
    $reldestpath = $this->foldable_string($reldestpath);
    $statstring = "<div class=\"list-indent\">
      {$this->admtext['line']} {$tag['line']}: <span class=\"tag\">%{$tag['name']}: </span>
      <span class=\"copyfile\">
         $flag$reldestpath
      </span>&nbsp;";

    $this->num_required++;
    $this->copies_required++;

    // FILE ALREADY COPIED TO DESTINATION
    if (file_exists($destpath)) {
      if ($flag == self::FLAG_PROTECTED) {
        $statstring .= "<span class=\"msgapproved\">{$this->admtext['protected']}</span>";
        $this->num_required--;
        $this->copies_required--;
      } else {
        $this->num_installed++;
        $this->copies_installed++;
        $statstring .= $this->admtext['copied'];
      }
      $this->set_status($statstring, $relsrcpath);
      return;
    }

    // SOURCE FILE FOR COPY MUST EXIST
    if (!file_exists($srcpath)) {
      $this->num_errors++;
      $statstring .= "<span class=\"hilighterr msgbold\">{$this->admtext['srcfilemissing']}</span>";
      $this->set_status($statstring, $relsrcpath);
      return;
    }

    // DESTINATION FOLDER FOR COPY MUST EXIST IF NOT OPTIONAL OR NOFOUL
    $thefolder = pathinfo($destpath, PATHINFO_DIRNAME);
    if (!file_exists($thefolder)) {
      if ($flag == self::FLAG_OPTIONAL) {
        $this->num_required--;
        $statstring .= "{$this->admtext['nofolder']}&nbsp;<span class=\"msgapproved\">{$this->admtext['willbypass']}</span>";
      } elseif ($flag == self::FLAG_NOFOUL) {
        $this->num_required--;
        $this->provisional_errors++;
        $statstring .= "{$this->admtext['nofolder']}&nbsp;<span class=\"msgapproved\">{$this->admtext['provisional']}</span>";
      } else {
        $this->num_errors++;
        $statstring .= "<span class=\"hilighterr msgbold\">{$this->admtext['nofolder']}</span>";
      }
      $this->set_status($statstring, $relsrcpath);
      return;
    }

    $statstring .= "<span class=\"NCOPY\">{$this->admtext['notcopied']}</span>";
    $this->set_status($statstring, $relsrcpath);
    return;

  } // COPYFILE STATUS CHECK

  protected function newfile_status_check($tag) {
    $flag = $tag['flag'];
    $line = $tag['line'];
    $destpath = $tag['arg1'];

    // USE RELATIVE DESTINATION PATH FOR DISPLAYS
    $reldestpath = str_replace($this->rootpath, '', $tag['arg1']);
    $reldestpath = $this->foldable_string($reldestpath);

    $statstring = "<div class=\"list-indent\">{$this->admtext['line']} $line: <span class=\"tag\">%newfile: </span><span class=\"newfile\">$flag$reldestpath</span>&nbsp;";

    if ($flag == self::FLAG_PROTECTED) {
      if (file_exists($destpath)) {
        $statstring .= "<span class=\"msgapproved\">{$this->admtext['protected']}</span>";
        $this->set_status($statstring);
        return;
      }
    }

    $this->num_required++;
    $this->newfiles_required++;

    // warn if destination folder for new file does not exist
    $thefolder = pathinfo($destpath, PATHINFO_DIRNAME);
    if (!file_exists($thefolder)) {
      if ($flag == self::FLAG_NOFOUL) {
        $this->num_required--;
        $this->newfiles_required--;
        $this->provisional_errors++;
        $statstring .= "<span class=\"tag\">{$this->admtext['nofolder']}&nbsp;</span><span class=\"msgapproved\">{$this->admtext['provisional']}</span>";
        $this->set_status($statstring);
        return;
      } elseif ($flag == self::FLAG_OPTIONAL) {
        $this->num_required--;
        $this->newfiles_required--;
        $statstring .= "<span class=\"tag\">{$this->admtext['optmissing']}&nbsp;</span><span class=\"msgapproved\">{$this->admtext['willbypass']}</span>";
        $this->set_status($statstring);
        return;
      } else {
        $this->num_errors++;
        $statstring .= "<span class=\"hilighterr msgbold\">{$this->admtext['nofolder']}</span>";
        $this->set_status($statstring);
      }
      return;
    }

    // IF NEWFILE INSTALLED CHECK VERSION
    if (file_exists($destpath)) {
      if ($flag != self::FLAG_OPTIONAL) {
        $this->num_installed++;
        $this->newfiles_installed++;
      }

      // match cfg fileversion with installed newfile version
      if (!preg_match("#%version:" . $tag['arg3'] . "%#", $tag['arg2'])) {
        $this->num_installed--;
        $this->newfiles_installed--;
        $this->num_errors++;
        $statstring .= "<span class=\"hilighterr msgbold\">{$this->admtext['badversion']}</span>";
        $this->set_status($statstring);
        return;
      }
      $statstring .= $this->admtext['created'];
      $this->set_status($statstring);
      return;
    } // NEW FILE NOT CREATED YET
    else {
      $statstring .= "<span class=\"NCREATE\">{$this->admtext['nocreated']}</span>";
      $this->set_status($statstring);
      return;
    }
    if ($flag != self::FLAG_OPTIONAL) {
      $this->num_required--;
      $this->newfiles_required--;
    }
    return;
  } // NEWFILE STATUS CHECK \

  protected function mkdir_status_check($tag) {
    $flag = $tag['flag'];
    $line = $tag['line'];
    $destpath = $tag['arg1'];

    // USE RELATIVE DESTINATION PATH FOR STATUS DISPLAYS
    $reldestpath = $flag . str_replace($this->rootpath, '', $tag['arg1']);
    $reldestpath = $this->foldable_string($reldestpath);

    $statstring = "<div class=\"list-indent>{$this->admtext['line']} $line: <span class=\"tag\">%mkdir: </span><span class=\"mkdir\">$reldestpath</span>&nbsp;";

    $this->num_required++;
    $this->newdirs_required++;

    // REPORT ON EXISTENCE OF FOLDER
    if (!file_exists($destpath)) {
      // no error
      $statstring .= "<span class=\"NCREATE\">{$this->admtext['nocreated']}</span>";
      $this->set_status($statstring);
    } else {
      $this->num_installed++;
      $this->newdirs_installed++;
      $statstring .= "<span class=\"none\">{$this->admtext['exists']}</span>";
      $this->set_status($statstring);
    }
    return;
  }

  // SHOW FILTER LINE BUTTONS
  protected function setup_filter_line($filter) {
    $buttons['installall'] = "\r\n<button type=\"submit\" id=\"btnInstall\"
         class=\"msgapproved\" name=\"submit\" value=\"installall\">{$this->admtext['installall']}</button>";
    $buttons['deleteall'] = "\r\n<button type=\"submit\" id=\"btnDelete\"
         class=\"msgerror\" name=\"submit\" value=\"deleteall\">{$this->admtext['deleteall']}</button>";;
    $buttons['removeall'] = "\r\n<button type=\"submit\" id=\"btnRemove\"
         class=\"msgapproved\" name=\"submit\" value=\"removeall\">{$this->admtext['removeall']}</button>";
    $buttons['cleanupall'] = "\r\n<button type=\"submit\" id=\"btnClean\"
         class=\"msgapproved\" name=\"submit\" value=\"cleanupall\">{$this->admtext['cleanupall']}</button>";
    $buttons['selectall'] = "\r\n<button type=\"submit\" id=\"btnChoose\"
         class=\"msgapproved\" name=\"submit\" value=\"selectall\">{$this->admtext['choose']}</button>";

    $btnline = "";
    switch ($filter) {
      case self::F_READY:
        $btnline = $buttons['installall'] . "\r\n&nbsp;&nbsp;\r\n" . $buttons['deleteall'];
        break;
      case self::F_INSTALLED:
        $btnline = $buttons['removeall'];
        break;
      case self::F_CLEAN:
        $btnline = $buttons['cleanupall'];
        if ($this->delete_partial) {
          $btnline .= "\r\n&nbsp;&nbsp;\r\n" . $buttons['deleteall'];
        }
        break;
      case self::F_BADCFG:
        $btnline = $buttons['deleteall'];
        break;
      case self::F_SELECT:
        $btnline = $buttons['selectall'];
        if ($this->delete_partial && $this->delete_installed) {
          $btnline .= "\r\n&nbsp;&nbsp;\r\n" . $buttons['deleteall'];
        }
        //$btnline = $buttons['selectall'];
        break;
      default:
        $btnline = "\r\n&nbsp;&nbsp;{$this->admtext['choosefilter']}";
        break;

    }
    return $btnline;
  }

  protected function set_status($string, $relsrcpath = '') {

    // closes the status line div before inserting the table for the copyfile display
    if (substr($string, 0, 4) == '<div') {
      $string .= '</div>';
    }

    if (!empty($relsrcpath)) {

      // In the <table> tag, add a left margin to replace the left margin from the parent <div>
      $string .= "
      <table style='margin-left:1em;'>
         <tr>
            <td class=\"normal fieldnameback fieldname\">
               {$this->admtext['source']}: $relsrcpath
            </td>
         </tr>
      </table>";

    }
    // add <br /> tag to end of $string before finalizing it
    // code that closed the status line div is now above the copyfile source path table
    if (substr($string, 0, 4) != '<div') {
      $string .= '<br />';
    }
    $this->status_string .= $string;
  }

  protected function get_status() {
    $retstr = "<br style=\"line-height:6px\" /><strong><i><div style=\"padding-bottom:3px;border-bottom:1px solid #000;\">flags:<br />@&nbsp;&nbsp;{$this->admtext['optional']}<br />^&nbsp;&nbsp;{$this->admtext['provisional']}<br />~&nbsp;&nbsp;protected</div></i></strong><br style=\"line-height:6px\" />";
    return $retstr . $this->status_string;
  }

  protected function init_status() {
    $this->status_string = '';
  }

  protected function format_status($status_header, $error, $status, $author_str, $id) {
    $this->status_header = $status_header;
    $btn_install = "<button class=\"msgapproved\" type=\"button\" onclick='window.location.href=\"?a=" . self::INSTALL . "&m=$this->cfgfile\"'>{$this->admtext['install']}</button>";

    $confirm = empty($this->delete_support) ?
            $this->admtext['confdelmod1'] :
            $this->admtext['confdelmod'];

    // javascript messages must contain a single quote character
    $confirm = str_replace("'", "\'", $confirm);

    $btn_delete = "<button class=\"msgerror\" type=\"button\" onclick=\"if(confirm('{$confirm}')) {window.location.href='?a=" . self::DELETE . "&m=$this->cfgfile';}\">{$this->admtext['delete']}</button>";

    $btn_remove = "<button class=\"msgapproved\" type=\"button\" onclick='window.location.href=\"?a=" . self::REMOVE . "&m=$this->cfgfile\"'>{$this->admtext['uninstall']}</button>";

    $btn_cleanup = "<button class=\"msgapproved\" type=\"button\" onclick='window.location.href=\"?a=" . self::CLEANUP . "&m=$this->cfgfile\"'>{$this->admtext['cleanup']}</button>";

    $btn_edit = '';
    if ($this->parameters) {
      $btn_edit = "<button type=\"button\" onclick='window.location.href=\"admin_modeditor.php?a=" . self::EDITP . "&m=$this->cfgfile\"'>{$this->admtext['edopts']}</button>";
    }

    // SHOW AVAILABLE FUNCTION BUTTONS IN OPENED STATUS AREA
    /*
          $btn_list = "";
    */
    $btn_list = "<button class=\"smallbutton\" type=\"button\"  name=\"listlocation$id\" onclick=\"if(document.getElementById('hiddenstatus$id').style.display=='none') document.getElementById('hiddenstatus$id').style.display='block'; else document.getElementById('hiddenstatus$id').style.display='none';\">{$this->admtext['detail']}</button>";
    $options_link = '';

    $buttons = '';
    if ($status_header == self::OK2INST) {
      $status_header = $this->admtext[$status_header];
      $style = "ready";
      $buttons = "<div>
                  $btn_install
                  $btn_delete
                  $btn_list
               </div>";
    } elseif ($status_header == self::CANTINST) {
      $status_header = $this->admtext[$status_header];
      $style = "badcfg";
      $buttons = "<div>
                  $btn_delete
               </div>";
    } elseif ($status_header == self::INSTALLED) {
      $status_header = $this->admtext[$status_header];
      if (!empty($this->parameters)) {
        $status_option = $this->admtext['hasoptions'];
        $status_header .= " [$status_option]";
      }
      $style = "installed";
      $buttons = "<div>
                  $btn_remove
                  $btn_edit";
      if ($this->delete_installed) {
        $buttons .= "
               $btn_delete";
      }
      $buttons .= " $btn_list";
      $buttons .= "</div>";
    } elseif ($status_header == self::PARTINST) {
      $status_header = $this->admtext[$status_header];
      $style = "partinst";
      $buttons = "<div>
                  $btn_cleanup
                  $btn_delete
               </div>";
    }

    if (isset($this->isprivate) && $this->isprivate) {
      $status_header .= "&nbsp;&nbsp;<span style=\"font-size:90%;\"><strong>{$this->admtext['privatemod']}</strong> $this->private</span>";
    }

    if (!empty($this->warning)) {
      $status_header .= "&nbsp;&nbsp;<strong><span style=\"font-size:90%;color:#990000;\"><strong>{$this->admtext['noeffect']}</strong></span>";
    }

    if (!empty($this->note)) {
      $status_header .= "&nbsp;&nbsp;<span style=\"font-size:90%;width:100%;\"> $this->note</span>";
    }

    if ($this->num_required > 0) {
      $summary = "<hr />
               <ul class=\"results fieldnameback fieldname\">
                  <li>{$this->admtext['modsreq']}: $this->mods_required; {$this->admtext['modified']}: $this->mods_installed</li>
                  <li>{$this->admtext['copiesreq']}: $this->copies_required; {$this->admtext['copied']}: $this->copies_installed</li>
                  <li>{$this->admtext['newfilesreq']}: $this->newfiles_required; {$this->admtext['created']}: $this->newfiles_installed</li>
                  <li>{$this->admtext['newdirsreq']}: $this->newdirs_required; {$this->admtext['created']}: $this->newdirs_installed</li>
                  <li>{$this->admtext['errors']}: $this->num_errors</li>
               </ul>";
    } else {
      $summary = '';
    }


    return "<div class=\"$style\">
            <span class=\"modlink closed\" id=\"link{$id}\">
               $status_header
            </span>
         </div>
         <div class=\"moddiv $style\" id=\"link{$id}div\" style=\"display:none;padding:5px;\">
            $buttons
            <hr />
            $author_str
            $this->description
            $error
            $status
            $summary
         </div>";
  } // format status

  // RETURN AFFECTED FILES POPUP LIST
  protected function affected_files_listing($id, $cfgfile, $modname, $aff_files) {
    $retstr = "
         <div class=\"descpop1 nw imgcenter\" title=\"\">

            <img border=\"0\" src=\"img/tng_more.gif\" width=\"16\" alt=\"\" />

            <div>
               <table class=\"mmpopuptable\">
                  <tr>
                     <td class=\"normal fieldnameback fieldname mmpopuphdr\">
                        $id. <strong>$modname - </strong>$cfgfile
                     </td>
                  </tr>
               </table>";

    $filestr = '';
    $filestr .= $this->format_affrows($aff_files['afchange'], "{$this->admtext['target']}");
    $filestr .= $this->format_affrows($aff_files['afcreate'], "{$this->admtext['newfile']}");
    $filestr .= $this->format_affrows($aff_files['afcopy'], "{$this->admtext['copiesfile']}");
    $filestr .= $this->format_affrows($aff_files['afcopy2'], "{$this->admtext['copiesfile2']}");

    if (!empty($filestr)) {
      $retstr .= "
               <table class=\"whiteback normal cellspace1 mmpad2\">
               $filestr
               </table>";
    }

    $retstr .= "
            </div>
         </div>"; // descpop
    return $retstr;
  } // affected_files_listing

  // CALLED BY GET AFFECTED FILES FUNCTION
  private function format_affrows($file_array, $label) {
    $retstr = '';
    if (empty($file_array)) {
      return $retstr;
    }
    $retstr .= "
                  <tr>
                     <td class=\"normal fieldnameback fieldname aligntop nw\">$label</td>
                     <td class=\"normal databack w100 mmpadleft\">";
    foreach ($file_array as $listing) {
      if ($listing == 'files') {
        continue;
      }
      $retstr .= "
                        $listing<br />";
    }
    $retstr .= "
                     </td>
                  </tr>";
    return $retstr;
  }

  private function sys_msg($msg) {
    echo "
   <tr>
      <td colspan=\"6\" class=\"mmsysmsg\">
         $msg
      </td>
   </tr>
   </table>";
  }
} // MODLISTER CLASS
?>

