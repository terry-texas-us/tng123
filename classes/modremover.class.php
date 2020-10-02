<?php
/*
   Mod Manager 12 Mod Remover Class

   Public Methods:
      $this->remove( $cfgpath );
      $this->batch_remove( $cfgpathlist );

*/

require_once 'classes/modparser.class.php';

class modremover extends modparser
{

    public $classID = "remover";
    public $modstatus = '';

    public function __construct($objinits) {
        parent::__construct($objinits);
    }

    public function remove($cfgpath) {

        $this->cfgpath = $cfgpath;
        $this->cfgfile = $cfgfile = pathinfo($cfgpath, PATHINFO_BASENAME);
        $this->parse_error = [];
        $this->mod_status = '';
        $moddirs = [];

        // GET PARSE TABLE FOR THIS MOD
        $tags = $this->parse($cfgpath);
        $tags = $this->arrange_table($tags);

        // LOG THE MOD REMOVAL
        $this->new_logevent("{$this->admtext['removing']} <strong>$cfgpath</strong>");

        if (empty($tags) && empty($this->parse_error)) {
            $this->mod_status = self::CANTPROC;
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
        $locations_installed = 0;
        $locations_removed = 0;
        $files_installed = 0;
        $files_removed = 0;
        $num_errors = 0;

        // PROCESS PARSE TABLE TO REMOVE THE CURRENT MOD
        for ($j = 0; isset($tags[$j]); $j++) {

            // IGNORE TAGS THAT WON'T BE FOUND IN TARGET FILE
            if ($this->is_infotag($tags[$j]['name'])) {
                continue;
            }

            /****************************************************************
             * TARGETS
             ****************************************************************/
            if ($tags[$j]['name'] == 'target') {
                $flag = $tags[$j]['flag'];

                // DEPLOYED FILES WILL BE DELETED IN ORDER FOUND IN CFG SO IGNORE THIS
                if ($tags[$j]['arg1'] == 'files') {
                    continue;
                }

                // NEW TARGET FILE? SAVE CURRENT TARGET BUFFER IF ANY;
                if (!empty($active_target_file) && !empty($target_file_contents)) {
                    if (false === $this->write_file_buffer($active_target_file, $target_file_contents)) {
                        $num_errors++;
                        $logstring = "<span class=\"msgerror\">{$this->admtext['cantwrite']} %target:</span><span class=\"tgtfile\">{$flag}$display_path</span><span class=\"tag\">%</span>&nbsp;";
                        $this->add_logevent($logstring);
                    }
                    unset($target_file_contents);
                }

                // INIT VARS FOR NEW TARGET FILE
                $fileoptional = false;
                $target_file_basename = '';
                $active_target_file = '';
                $target_file_contents = null;

                // REMOVE ROOTPATH PORTION OF FILE PATH FOR LOGGING
                $display_path = str_replace($this->rootpath, '', $tags[$j]['arg1']);
                $logstring = "{$this->admtext['line']} {$tags[$j]['line']}: <span class=\"tag\">%target:</span><span class=\"tgtfile\">{$flag}$display_path</span><span class=\"tag\">%</span>&nbsp;";

                $fileoptional = $tags[$j]['arg2'] == 'fileoptional';

                // READ TARGET FILE CONTENTS INTO PROCESSING BUFFER
                $target_file_contents = $this->read_file_buffer(
                    $tags[$j]['arg1'], $tags[$j]['flag']);

                // REPORT FILE ERRORS IF ANY
                if (is_numeric($target_file_contents)) {
                    switch ($target_file_contents) {
                        case self::BYPASS:
                            // not an error
                            $logstring .= "{$this->admtext['optmissing']}&nbsp;<span class=\"msgapproved\">{$this->admtext['bypassed']}</span>";
                            $this->add_logevent($logstring);
                            break;
                        case self::NOFOUL:
                            // $provisional_errors++;
                            $this->provisional_errors--;
                            $logstring .= "<span class=\"msgapproved\">{$this->admtext['removed']}</span>";
                            $this->add_logevent($logstring);
                            break;
                        case self::NOFILE:
                            //$num_errors++;
                            $logstring .= "<span class=''>{$this->admtext['tgtmissing']}</span>";
                            $this->add_logevent($logstring);
                            break;
                        case self::NOWRITE:
                            //$num_errors++;
                            $logstring .= "<span class=\"msgerror\">{$this->admtext['notwrite']}</span>";
                            $this->add_logevent($logstring);
                            break;
                        case self::ISEMPTY:
                            //$num_errors++;
                            $logstring .= "<span class=\"msgerror\">{$this->admtext['emptyfile']}</span>";
                            $this->add_logevent($logstring);
                            break;
                        default:
                            break;
                    }
                    // don't try to write to defective file
                    $active_target_file = '';
                    $targt_file_contents = '';
                } else {
                    $istarget = true;
                    $active_target_file = $tags[$j]['arg1'];
                    $logstring .= "{$this->admtext['opened']}";
                    $this->add_logevent($logstring);
                }
                continue;  // target file buffer ready - get next tag
            } // TARGET
            /****************************************************************
             * LOCATIONS
             ****************************************************************/
            elseif ($tags[$j]['name'] == 'location') {
                $locations_installed++;
                $logstring = "{$this->admtext['line']} {$tags[$j]['line']}: <span class=\"tag\">%location:%</span>&nbsp;";

                // NO TARGET FILE OPEN - NO POINT PROCESSING LOCATIONS
                if (empty($active_target_file)) {
                    if ($fileoptional) {
                        $locations_installed--;
                    }
                    continue;
                } else {
                    // TARGET FILE OPEN AND READY FOR MODIFICATION
                    $tng_code = $tags[$j]['arg1'];

                    $j++; // go to optag

                    $optag = $tags[$j]['name'];
                    $new_code = $tags[$j]['arg1'];
                    $logstring .= "(%$optag:)&nbsp;";
                }
                // SET ARGUMENTS FOR PHP SUBSTR_REPLACE() FUNCTION
                switch ($optag) {
                    case 'insert:before':
                        $new_code .= "\r\n";
                        $len = strlen($new_code);
                        $replacement = '';
                        break;
                    case 'insert:after':
                        $new_code = "\r\n" . $new_code;
                        $len = strlen($new_code);
                        $replacement = '';
                        break;
                    case 'vinsert:before':
                        $this->remove_vinserts($target_file_contents, $optag, $new_code, $logstring);
                        continue 2; // finished - get next tag
                    case 'vinsert:after':

                        $this->remove_vinserts($target_file_contents, $optag, $new_code, $logstring);
                        continue 2;  // finished - get next tag
                    case 'replace':
                    case 'trimreplace':
                        $len = strlen($new_code);
                        $replacement = $tng_code;
                        break;
                    case 'triminsert:before':
                        $new_code .= $tng_code;
                        $len = strlen($new_code);
                        $replacement = $tng_code;
                        break;
                    case 'triminsert:after':
                        $new_code = $tng_code . $new_code;
                        $len = strlen($new_code);
                        $replacement = $tng_code;
                        break;
                    default:
                        break;
                }
                // WHICH CODE - TNG OR NEW - IS CURRENTLY INSTALLED
                if (false === $pos = strpos($target_file_contents, $new_code)) {
                    if (false === $pos = strpos($target_file_contents, $tng_code)) {
                        // file is corrupt
                    } else { // TNG CODE FOUND (NO ACTION REQUIRED) -- REPORT AND MOVE ON
                        $locations_removed++;
                        $logstring .= "<span class=\"msgapproved\">{$this->admtext['alreadyrem']}</span>";
                        $this->add_logevent($logstring);
                        continue;
                    }
                } else { // NEW CODE FOUND -- REPLACE IT WITH ORIGINAL TNG CODE
                    $target_file_contents = substr_replace($target_file_contents, $replacement, $pos, $len);
                    $locations_removed++;
                    $logstring .= "<span class=\"msgapproved\">{$this->admtext['restored']}</span>";
                    $this->add_logevent($logstring);
                    continue;
                }
            } // location
            /****************************************************************
             * FILE / FOLDER REMOVAL OPERATIONS
             ****************************************************************/
            else {
                // PREPARE PATH FOR COPIED FILE REMOVALS
                switch ($tags[$j]['name']) {
                    case 'copyfile':
                    case 'copyfile2':
                        $dest_path = str_replace($this->rootpath, '', $tags[$j]['arg2']);
                        $destination_path = $tags[$j]['arg2'];
                        $files_installed++;
                        break;
                    case 'newfile':
                        $dest_path = str_replace($this->rootpath, '', $tags[$j]['arg1']);
                        $destination_path = $tags[$j]['arg1'];
                        $files_installed++;
                        break;
                    case 'mkdir':
                        $moddirs[] = $tags[$j]['arg1'];
                        continue 2; // not further handled in processing loop
                    default:
                        continue 2; // not a tag for processing, continue through the for loop
                }
                $flag = $tags[$j]['flag'];

                // REMOVE FILE AND REPORT STATUS
                $logstring = "{$this->admtext['line']} {$tags[$j]['line']}: %<span class=\"tag\">{$tags[$j]['name']}:</span><span class=\"tgtfile\">{$flag}$dest_path</span>%&nbsp;";

                if (!file_exists($destination_path)) {
                    $logstring .= "{$this->admtext['notinst']}&nbsp;<span class=\"msgapproved\">{$this->admtext['bypassed']}</span>";
                    $this->add_logevent($logstring);
                    continue;
                } elseif ($flag == self::FLAG_PROTECTED) {
                    $logstring .= "<span class=\"msgapproved\">{$this->admtext['protected']}</span>";
                    $this->add_logevent($logstring);
                    continue;
                } elseif (false === unlink($destination_path)) {
                    if ($optional) {
                        $logstring .= "<span class=\"msgapproved\">{$this->admtext['cantremok']}</span>";
                        $this->add_logevent($logstring);
                        continue;
                    } else {
                        // failed to delete required file
                        $num_errors++;
                        $logstring .= "<span class=\"hilighterr msgbold\">{$this->admtext['cantdel']}</span>";
                        $this->add_logevent($logstring);
                        continue;
                    }
                } else {
                    $files_removed++;
                    $logstring .= "<span class=\"msgapproved\">{$this->admtext['deleted']}</span>";
                    $this->add_logevent($logstring);
                    continue;
                }
            }
        } // tags processing loop

        // DONE PROCESSING - WRITE LAST TARGET BUFFER TO FILE
        if (!empty($active_target_file) && !empty($target_file_contents)) {
            if (false === $this->write_file_buffer($active_target_file, $target_file_contents)) {
                $num_errors++;
                $logstring = "<span class=\"msgerror\">{$this->admtext['cantwrite']} %target:</span><span class=\"tgtfile\">$display_path</span><span class=\"tag\">%</span>&nbsp;";
                $this->add_logevent($logstring);
            }
            unset($target_file_contents);
        }

        // REMOVE FOLDERS INSTALLED BY MOD IF EMPTY
        // do it here so all installed files will be removed first
        if (count($moddirs)) {
            foreach ($moddirs as $moddir) {
                $dest_path = str_replace($this->rootpath, '', $moddir);
                $logstring = "{$this->admtext['line']} {$tags[$j]['line']}: %<span class=\"tag\">%remdir:</span><span class=\"tgtfile\">$dest_path</span>%&nbsp;";
                if (false !== rmdir($moddir)) {
                    $logstring .= "<span class=\"msgapproved\">{$this->admtext['removed']}</span>";
                    $this->add_logevent($logstring);
                } else {
                    $logstring .= "<span class=\"msgapproved\">{$this->admtext['cantrem']}</span>";
                    $this->add_logevent($logstring);
                }
            }

        }

        if (!$num_errors) {
            $status = self::MODREM;
            $class = "class=\"msgapproved\"";
        } else {
            $status = self::ERRORS;
            $class = "class=\"msgerror\"";
        }

        $this->add_logevent("<span class=\"msgbold\">{$this->admtext['toterrors']}:</span> $num_errors");
        $this->add_logevent("$locations_installed {$this->admtext['modsinst']}&nbsp;&nbsp;&nbsp;&nbsp; $locations_removed {$this->admtext['modsrem']}");
        $this->add_logevent("$files_installed {$this->admtext['filesinst']}&nbsp;&nbsp;&nbsp;&nbsp;$files_removed {$this->admtext['filesrem']}");
        $this->add_logevent("{$this->admtext['status']}: <span $class>{$this->admtext[$status]}</span>");

        $this->mod_status = $status;
        $this->write_eventlog();
        return ($status == self::MODREM);
    } // remove

    private function remove_vinserts(&$buffer, $optag, $newcode, $logstring) {

        $this->add_logevent($logstring);
        preg_match_all("#(\\$[^\s=]+)\s*=+#sm", $newcode, $matches);
        $vars = $matches[1];

        $num_vars = count($vars);
        foreach ($vars as $var) {
            $terminator = '';
            $pos = 0;
            $epos = 0;
            if (false !== $pos = strpos($buffer, $var)) {
                if (false !== $qpos = strpos($buffer, "=", $pos)) {
                    // GET TERMINATOR
                    while (isset($buffer[$qpos + 1])) {
                        $qpos++;
                        if ($buffer[$qpos] == " " || $buffer[$qpos] == "\t") {
                            continue;
                        }
                        if ($buffer[$qpos] == "'") {
                            $terminator = "';";
                            break;
                        }
                        if ($buffer[$qpos] == '"') {
                            $terminator = '";';

                        }
                        $terminator = ";";
                        break;
                    }
                    if (false !== $epos = strpos($buffer, $terminator, $pos)) {
                        $epos = strpos($buffer, "\r\n", $epos);
                    }
                    $len = ($epos - $pos) + 2; // the crlf too
                    $buffer = substr_replace($buffer, '', $pos, $len);
                }
            }
            $logstring = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$var&nbsp;<span class=\"msgapproved\">{$this->admtext['removed']}</span>";
            $this->add_logevent($logstring);
        }
    }

    public function batch_remove($cfgpathlist) {
        $this->batch_error = false;
        foreach ($cfgpathlist as $cfgpath) {
            if (!$this->remove($cfgpath)) {
                $this->batch_error = true;
            }
        }
        return !$this->batch_error;
    }
} // class modremover
