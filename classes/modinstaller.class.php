<?php
/*
   Mod Manager 12 Mod Installer Class

   Public Methods:
      $this->install( $cfgpath );
      $this->batch_install( $cfgpathlist );

*/

require_once 'classes/modparser.class.php';

class modinstaller extends modparser
{

  protected $classID = "installer";

  public function __construct($objinits) {
    parent::__construct($objinits);
  }

  public function install($cfgpath) {
    $this->cfgpath = $cfgpath;
    $this->cfgfile = $cfgfile = pathinfo($cfgpath, PATHINFO_BASENAME);
    $this->parse_error = array();
    $this->mod_status = '';

    // GET PARSE TABLE FOR THIS MOD
    $tags = $this->parse($cfgpath);
    $tags = $this->arrange_table($tags);

    // LOG THE MOD INSTALLATION
    $this->new_logevent("{$this->admtext['installing']} <strong>$cfgpath</strong>");

    if (empty($tags) && empty($this->parse_error)) {
      $this->mod_status = self::CANTINST;
      $this->add_logevent("<span class=\"msgerror\">parse table {$this->admtext['missing']}</span>");
      $this->write_eventlog($error = true);
      return false;
    }

    // HANDLE FATAL ERROR
    if (!empty($this->parse_error)) {
      $this->modname = $cfgfile;
      $this->mod_status = self::ERRORS;
      $idx = $this->parse_error['text'];
      $this->add_logevent("<span class=\"msgerror\">$cfgfile</span> <span class=\"hilighterr msgbold\">{$this->admtext[$idx]}</span>");
      $this->write_eventlog();
      return false;
    }

    // INITIALIZE STATUS DATA
    $locations_required = 0;
    $locations_installed = 0;
    $newdirs_required = 0;
    $newdirs_created = 0;
    $newdirs_excused = 0;
    $newfiles_required = 0;
    $newfiles_created = 0;
    $newfiles_excused = 0;
    $copyfiles_required = 0;
    $copyfiles_copied = 0;
    $copyfiles_excused = 0;
    $statstring = '';
    $num_errors = 0;

    // PROCESS PARSE TABLE TO INSTALL THE CURRENT MOD
    for ($j = 0; isset($tags[$j]); $j++) {

      // IGNORE TAGS THAT WON'T BE INSTALLED IN TARGET FILE
      if ($this->is_infotag($tags[$j]['name'])) {
        continue;
      }

      /*************************************************************************
       * TARGETS
       *************************************************************************/
      if ($tags[$j]['name'] == 'target') {
        $flag = $tags[$j]['flag'];

        // DEPLOYED FILES WILL BE INSTALLED IN ORDER FOUND IN CFG SO IGNORE THIS
        if ($tags[$j]['arg1'] == 'files') {
          continue;
        }


        // NEW TARGET FILE? SAVE CURRENT TARGET BUFFER IF ANY;
        if (!empty($active_target_file) && !empty($target_file_contents)) {
          if (false === $this->write_file_buffer($active_target_file, $target_file_contents)) {
            $num_errors++;
            $logstring = "<span class=\"msgerror\">{$this->admtext['cantwrite']} %target:</span><span class=\"tgtfile\">$display_path</span><span class=\"tag\">%</span>&nbsp;";
            $this->add_logevent($logstring);
          } else {
            unset($target_file_contents);
          }
        }

        // INIT VARS FOR NEW TARGET FILE
        $target_file_contents = null;
        $active_target_file = $tags[$j]['arg1'];

        // REMOVE ROOTPATH PORTION OF TARGET FILE PATH FOR LOG DISPLAY
        $display_path = $flag . str_replace($this->rootpath, '', $tags[$j]['arg1']);

        $logstring = "{$this->admtext['line']} {$tags[$j]['line']}: <span class=\"tag\">%target:</span><span class=\"tgtfile\">$display_path</span><span class=\"tag\">%</span>&nbsp;";

        // READ TARGET FILE CONTENTS INTO PROCESSING BUFFER
        $target_file_contents = $this->read_file_buffer(
                $tags[$j]['arg1'],
                $flag);

        // REPORT FILE ERRORS IF ANY
        if (is_numeric($target_file_contents)) {
          switch ($target_file_contents) {
            case self::BYPASS:
              $logstring .= "{$this->admtext['optmissing']}&nbsp;<span class=\"msgapproved\">{$this->admtext['bypassed']}</span>";
              $this->add_logevent($logstring);
              break;
            case self::NOFOUL:
              $num_errors++;
              $logstring .= "{$this->admtext['tgtmissing']}&nbsp;<span class=\"msgerror\">{$this->admtext['required']}</span>";
              $this->add_logevent($logstring);
              break;
            case self::NOFILE:
              $num_errors++;
              $logstring .= "<span class=\"msgerror\">{$this->admtext['tgtmissing']}</span>";
              $this->add_logevent($logstring);
              break;
            case self::NOWRITE:
              $num_errors++;
              $logstring .= "<span class=\"msgerror\">{$this->admtext['notwrite']}</span>";
              $this->add_logevent($logstring);
              break;
            case self::ISEMPTY:
              $num_errors++;
              $logstring .= "<span class=\"msgerror\">{$this->admtext['emptyfile']}</span>";
              $this->add_logevent($logstring);
              break;
            default:
              break;
          }
          // don't try to write to defective file
          $active_target_file = '';
          $targt_file_contents = '';
          $istarget = false;
        } else {
          $istarget = true;
          $active_target_file = $tags[$j]['arg1'];
          $logstring .= "{$this->admtext['opened']}";
          $this->add_logevent($logstring);
        }
        continue;
      } // target
      /*************************************************************************
       * LOCATIONS
       *************************************************************************/
      if ($tags[$j]['name'] == 'location') {
        if (!$istarget) {
          continue;
        }
        $locations_required++;
        $logstring = "{$this->admtext['line']} {$tags[$j]['line']}: <span class=\"tag\">%location:%</span>&nbsp;";

        // TARGET FILE NOT OPENED FOR SOME REASON - NO POINT PROCESSING LOCATIONS
        if (empty($active_target_file)) {
          if ($tags[$j]['flag'] == self::FLAG_OPTIONAL) {
            $locations_required--;
          }
          continue;
        } // TARGET FILE OPEN & READY FOR MODIFICATION
        else {
          $tng_code = $tags[$j]['arg1'];
          $tng_code_trimmed = trim($tng_code, " \t");
          $j++; // go to next tag (the optag)
          $optag = $tags[$j]['name'];
          $new_code = $tags[$j]['arg1'];
          $logstring .= "(%.$optag:)&nbsp;";

          // CONSTRUCT SEARCH AND INSERT/REPLACE STRINGS
          $block_op = false;
          switch ($optag) {
            case 'insert:before':
            case 'vinsert:before':
              $tngcode = $tng_code_trimmed;
              $newcode = $new_code . "\r\n";
              $block_op = true;
              break;
            case 'insert:after':
            case 'vinsert:after':
              $tngcode = $tng_code_trimmed;
              $newcode = "\r\n" . $new_code;
              $block_op = true;
              break;
            case 'replace':
              $tngcode = $tng_code_trimmed;
              $newcode = $new_code;
              $block_op = true;
              break;
            case 'triminsert:before':
              $tngcode = $tng_code;
              $newcode = $new_code . $tng_code;
              break;
            case 'triminsert:after':
              $tngcode = $tng_code;
              $newcode = $tng_code . $new_code;
              break;
            case 'trimreplace':
              $tngcode = $tng_code;
              $newcode = $new_code;
              break;
            default:
              break;
          }

          // IF MOD ALREADY INSTALLED ACCEPT IT AND MOVE ON
          if (false !== strpos($target_file_contents, $newcode)) {
            $locations_installed++;
            $logstring .= "<span class=\"msgapproved\">{$this->admtext['installed']}</span>";
            $this->add_logevent($logstring);
            continue;
          }

          // SET POINTER TO BEGINNING OF GOOD TARGET
          if (false === $i = strpos($target_file_contents, $tngcode)) {
            $num_errors++;
            $logstring .= "<span class=\"msgerror\">{$this->admtext['badtarget']}</span>";
            $this->add_logevent($logstring);
            continue;
          }


          // USE POINTER TO MARK START AND END POSITIONS OF TNG BLOCK IN TARGET FILE
          if ($block_op) {
            $fragment = false;
            // SELECT BLOCK OF TEXT IN TARGET FILE TO OPERATE ON
            // set pointer ($p) to beginning of matched text from cfg and move it
            // backwards back to end of previous CRLF or top of file,
            // skipping white space but checking to see if we have additional
            // code -- considered a fragment (incomplete block)
            $p = $i;
            while ($p > 0) {
              $p--;
              if ($target_file_contents[$p] == "\n") {
                $p++;
                break;
              }
              if ($target_file_contents[$p] != " " && $target_file_contents[$p] != "\t") {
                $fragment = true;
              }
            }
            $start = $p;

            // set pointer to end of last line of target and move it forward to CRLF
            // or end of file, skipping white space but checking for data between
            // end of the target and the end of the block (CRLF) making it a fragment
            $p = $i + strlen($tngcode); // last position in target str
            while (true) {
              if (!isset($target_file_contents[$p])) { // EOF - no CRLF
                break;
              }
              if ($target_file_contents[$p] == "\r") { // CRLF
                break;
              }
              if ($target_file_contents[$p] != " " && $target_file_contents[$p] != "\t") {
                $fragment = true;
              }
              $p++;
            }
            $end = $p;
            $length = ($end - $start) + 1;

            // SEE THAT %REPLACE:% REPLACES A COMPLETE BLOCK
            if ($fragment && $optag == "%replace:%") {
              $num_errors++;
              $logstring .= "<span class=\"msgerror\">{$this->admtext['no_frag']}</span>";
              $this->add_logevent($logstring);
              continue;
            }
          } else { // OTHERWISE CFG CODE AND TGT MUST EXACTLY MATCH EACH OTHER
            $start = $i;
            $length = strlen($tngcode);
            $end = ($start + $length);
          }

          // FIND START POSITION AND LENGTH FOR SUBSTR_REPLACE() FUNCTION
          // Double quotes here to make these unique (single quotes above)
          switch ($optag) {
            case "insert:before":
            case "vinsert:before":
              $pos = $start;
              $len = 0; // zero for insert at $pos; # for amount of tgt to replace
              break;
            case "insert:after":
            case "vinsert:after":
              $pos = $end;
              $len = 0;
              break;
            case "replace":
            case "triminsert:before":
            case "triminsert:after":
            case "trimreplace":
              $pos = $start;
              $len = $length;
              break;
            default:
              break;
          }

          // modify the target file contents
          $target_file_contents = substr_replace($target_file_contents, $newcode, $pos, $len);

          // test for success
          if (false !== strpos($target_file_contents, $newcode)) {
            $locations_installed++;
            $logstring .= "<span class=\"msgapproved\">{$this->admtext['installed']}</span>";
            $this->add_logevent($logstring);
            continue;
          } else {
            $num_errors++;
            $logstring .= "<span class=\"msgerror\">{$this->admtext['badinstall']}</span>";
            $this->add_logevent($logstring);
            continue;
          }
        } // open target file
      } // locations
      /*************************************************************************
       * COPYFILE OPERATIONS
       *************************************************************************/
      if ($tags[$j]['name'] == 'copyfile' || $tags[$j]['name'] == 'copyfile2') {
        $flag = $tags[$j]['flag'];
        $copyop = $tags[$j]['name'];
        $copyfiles_required++;
        $source_path = $tags[$j]['arg1'];
        $source_file = pathinfo($source_path, PATHINFO_BASENAME);
        //echo $source_path;exit;
        $filename = pathinfo($source_path, PATHINFO_BASENAME);
        $destination_path = $tags[$j]['arg2'];
        $dest_path = str_replace($this->rootpath, '', $destination_path);

        $logstring = "{$this->admtext['line']} {$tags[$j]['line']}: %<span class=\"tag\">{$tags[$j]['name']}:</span>";
        $logstring .= "<span class=\"tgtfile\">{$flag}$dest_path</span>%&nbsp;";

        if (!file_exists($source_path)) {
          if ($flag == self::FLAG_OPTIONAL) {
            $copyfiles_excused++;
            $logstring .= "{$this->admtext['optsrcfilemissing']}&nbsp;<span class=\"msgapproved\">{$this->admtext['bypassed']}</span>";
            $this->add_logevent($logstring);
            continue;
          } else {
            $num_errors++;
            $logstring .= "<span class=\"msgerror\">{$this->admtext['srcfilemissing']}</span>";
            $this->add_logevent($logstring);
            continue;
          }
        }
        // DO NOT OVERCOPY PROTECTED FILE
        if (file_exists($destination_path)) {
          if ($flag == self::FLAG_PROTECTED) {
            $copyfiles_excused++;
            $logstring .= "<span class=\"msgapproved\">{$this->admtext['protected']}</span>";
            $this->add_logevent($logstring);
            continue;
          }
        }

        if (@copy($source_path, $destination_path) === false) {
          // failed copy excused?
          if ($flag == self::FLAG_OPTIONAL) {
            $copyfiles_excused++;
            $logstring .= "{$this->admtext['optnocopy']}&nbsp;<span class=\"msgapproved\">{$this->admtext['bypassed']}</span>";
            $this->add_logevent($logstring);
            continue;
          } // failed copy
          else {
            $num_errors++;
            $logstring .= "<span class=\"msgerror\">{$this->admtext['notcopied']}</span>";
            $this->add_logevent($logstring);
            continue;
          }
        } else {
          // copy was successful
          $copyfiles_copied++;
          $logstring .= "<span class=\"msgapproved\">{$this->admtext['copied']}</span>";
          $this->add_logevent($logstring);
          continue;
        }
      } /*************************************************************************
       * NEWFILE OPERATIONS
       *************************************************************************/
      elseif ($tags[$j]['name'] == 'newfile') {
        $flag = $tags[$j]['flag'];
        $newfiles_required++;
        $destination_file = $tags[$j]['arg1'];
        $dest_file = str_replace($this->rootpath, '', $destination_file);
        $logstring = "{$this->admtext['line']} {$tags[$j]['line']}: <span class=\"tag\">%newfile:</span><span class=\"tgtfile\">{$flag}$dest_file</span><span class=\"tag\">%</span>&nbsp;";

        // DO NOT OVERCOPY PROTECTED FILE
        if (file_exists($destination_file)) {
          if ($flag == self::FLAG_PROTECTED) {
            $newfiles_excused++;
            $logstring .= "<span class=\"msgapproved\">{$this->admtext['protected']}</span>";
            $this->add_logevent($logstring);
            continue;
          }
        }

        $newfile_code = $tags[$j]['arg2'];
        if (!empty($newfile_code)) {
          if (false !== $this->write_file_buffer($destination_file, $newfile_code)) {
            $newfiles_created++;
            $logstring .= "<span class=\"msgapproved\">{$this->admtext['created']}</span>";
            $this->add_logevent($logstring);
            continue;
          } // optional file not created?
          elseif ($flag == self::FLAG_OPTIONAL) {
            $newfiles_excused++;
            $logstring .= "{$this->admtext['optnotcreated']}&nbsp;<span class=\"msgapproved\">{$this->admtext['bypassed']}</span>";
            $this->add_logevent($logstring);
            continue;
          } else {
            $num_errors++;
            $logstring .= "<span class=\"msgerror\">{$this->admtext['notcreated']}</span>";
            $this->add_logevent($logstring);
            continue;
          }
        }

      } // newfiles
      elseif ($tags[$j]['name'] == 'mkdir') {
        $newdirs_required++;
        $dirpath = $tags[$j]['arg1'];
        $display_path = str_replace($this->rootpath, '', $dirpath);

        $logstring = "{$this->admtext['line']} {$tags[$j]['line']}: <span class=\"tag\">%mkdir:</span><span class=\"tgtfile\">$display_path</span><span class=\"tag\">%</span>&nbsp;";
        if (file_exists($dirpath)) {
          $logstring .= "<span class=\"msgapproved\">{$this->admtext['created']}</span>";
          $this->add_logevent($logstring);
          continue;
        }
        mkdir($dirpath, 0777, true);
        if (file_exists($dirpath)) {
          $logstring .= "<span class=\"msgapproved\">{$this->admtext['created']}</span>";
          $this->add_logevent($logstring);
          continue;
        } else {
          $logstring .= "<span class=\"msgerror\">{$this->admtext['notcreated']}</span>";
          $this->add_logevent($logstring);
          continue;
        }
      }
    } // tags processing loop

    // Everything processed, flush last buffer to file
    if (!empty($active_target_file) && !empty($target_file_contents)) {
      if (false === $this->write_file_buffer($active_target_file, $target_file_contents)) {
        $num_errors++;
        $logstring = "<span class=\"msgerror\">{$this->admtext['cantwrite']} %target:</span><span class=\"tgtfile\">$display_path</span><span class=\"tag\">%</span>&nbsp;";
        $this->add_logevent($logstring);
      }
    }
    if (!$num_errors) {

      // compute the final statistics
      if ($copyfiles_required == ($copyfiles_copied + $copyfiles_excused) && ($newfiles_required == ($newfiles_created + $newfiles_excused) && ($locations_required == $locations_installed))) {
        if ($copyfiles_copied == 0 && $copyfiles_excused == 0 && $newfiles_created == 0 && $newfiles_excused == 0 && $locations_installed == 0) {
          $status = self::OK2INST;
          $class = "class=\"msgapproved\"";
        } else {
          $status = self::INSTALLED;
          $class = "class=\"msgapproved\"";
        }
      }
    } else {
      $status = self::ERRORS;
      $class = "class=\"msgerror\"";
      $this->batch_error = true;
    }
    $this->add_logevent("<span class=\"msgbold\">{$this->admtext['toterrors']}:</span> $num_errors");
    $this->add_logevent("$locations_required {$this->admtext['modsreq']}: $locations_installed {$this->admtext['modsinst']}");
    $this->add_logevent("$copyfiles_required {$this->admtext['copiesreq']}: $copyfiles_copied {$this->admtext['filescopied']} and $copyfiles_excused {$this->admtext['excused']}");
    $this->add_logevent("$newfiles_required {$this->admtext['newfilesreq']}: $newfiles_created {$this->admtext['nfcreated']} and $newfiles_excused {$this->admtext['excused']}");
    $this->add_logevent("{$this->admtext['status']}: <span $class>{$this->admtext[$status]}</span>");

    $this->mod_status = $status;
    $this->write_eventlog();
    return ($status == self::OK2INST || $status == self::INSTALLED);
  } // install

  public function batch_install($cfgpathlist) {
    foreach ($cfgpathlist as $cfgpath) {
      if (!$this->install($cfgpath)) {
        $this->batch_error = true;
      };
    }
    return !$this->batch_error;
  }
} // class modinstaller

?>