<?php
/* Mod Manager 12 Editor for mod parameters

   Public Methods:
      $this->show_editor( $cfgpath );
      $this->update_parameter( $param = [] );
      $this->restore_parameter( $param = [] );

   Only the value of the first occurrence of a variable is now edited in each
   file. This applies to both target files and mod configuration file. Parameter
   names in mod configuration files must be unique.
*/

require_once 'classes/modparser.class.php';

class modeditor extends modparser
{
    /*
       const UPDATEP = 6;
       const RESTOREP = 7;
    */
    protected $classID = 'editor';

    public function __construct($objinits) {
        parent::__construct($objinits);
    }

    public function show_editor($cfgpath) {
        $this->mod_status = '';

        // GET PARSE TABLE FOR THIS MOD
        $tags = $this->parse($cfgpath);

        // GET CONFIG FILE NAME
        $cfgfile = pathinfo($cfgpath, PATHINFO_BASENAME);

        // LOG THE MOD PARAMETER CHANGE
        $this->new_logevent("{$this->admtext['editing']} <strong>$cfgpath</strong>");

        if (empty($tags) && empty($this->parse_error)) {
            $this->mod_status = self::CANTUPD;
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


        // BUILD A PRELIM TABLE FROM TAGS ARRAY
        $i = 0; // params array index
        $k = 0;
        $params = [];
        for ($j = 0; isset($tags[$j]); $j++) {
            if ($tags[$j]['name'] == 'target') {
                $tgtfile = $tags[$j]['arg1'];
            } elseif ($tags[$j]['name'] == 'parameter') {
                $partable[$i]['file'] = $tgtfile;
                $partable[$i]['var'] = $tags[$j]['arg1'];
                $partable[$i]['val'] = $tags[$j]['arg2'];
                $j++;
                $partable[$i]['desc'] = $tags[$j]['arg1'];
                $partable[$i++]['def'] = $tags[$j]['arg2'];
            }
        }


// TARGET FILES WITH PARAMETERS

        $active_target_file = '';
        foreach ($partable as $parm) {
            if ($parm['file'] != $active_target_file) {

                // GET FILE BUFFER FOR EACH NEW FILE
                $active_target_file = $parm['file'];
                $atf = str_replace($this->rootpath, '', $active_target_file);
                $target_file_contents = $this->read_file_buffer($parm['file']);

                // FILE MUST EXIST OR IT IS AN ERROR
                if (is_numeric($target_file_contents)) {
                    $num_errors++;
                    $logstring .= "<span class=\"msgerror\">$atf&nbsp;{$this->admtext['tgtmissing']}</span>";
                    $this->add_logevent($logstring);
                    $this->write_eventlog();
                    return false;
                }
            }

            /*************************************************************************
             * PARAMETERS
             *************************************************************************/

            // GET TARGETED VARIABLE NAME
            $varname = str_replace("$", "\\$", $parm['var']);
            $varname = str_replace("[", "\\[", $varname);
            $varname = str_replace("]", "\\]", $varname);

            // GET TARGETED VARIABLE VALUE
            $reg_exp = "#(" . $varname . "\\s*=\\s*)(['\"]?)([^;]*);#";

            if (!preg_match($reg_exp, $target_file_contents, $matches)) {
                $this->mod_status = self::ERRORS;
                $this->show_log_errors = true;

                $this->add_logevent("<span class=\"msgerror\">{$this->admtext['tgtfile']} $atf</span> <span class=\"hilighterr msgbold\">{$this->admtext['noparam']}: {$parm['var']}</span>");
                $this->write_eventlog();
                return false;
            }

            // MANAGE SURROUNDING QUOTES IN VARIABLE VALUE
            $quotes = 0;
            if (!empty($matches[2])) {
                if ($matches[2] == "'") {
                    $quotes = 1;
                } elseif ($matches[2] == '"') {
                    $quotes = 2;
                }
            }

            // REMOVE QUOTES FOR PROCESSING
            $matches[3] = trim($matches[3], "'\"");

            // escape internal single quotes
            $matches[3] = str_replace("'", "\\'", $matches[3]);

            $params[$k]['val'] = $matches[3];
            $params[$k]['def'] = $parm['def'];
            $params[$k]['tgt'] = $atf;
            $params[$k]['cfg'] = $cfgpath;
            $params[$k]['param'] = $parm['var'];
            $params[$k]['quot'] = $quotes;
            $params[$k++]['label'] = $parm['desc'];
        } // PARAMS ARRAY

        if (empty($params)) {
            $this->mod_status = self::ERRORS;
            $this->show_log_errors = true;
            $this->add_logevent("<span class=\"msgerror\">$cfgfile</span> <span class=\"hilighterr msgbold\">{$this->admtext['cantupd']}: $varname</span>");
            $this->write_eventlog();
            return false;
        }
        /*************************************************************************
         * SHOW TITLE BAR
         *************************************************************************/
        // fixed or scrolling header/filter bar ?
        $tbclass = $this->fix_header == self::YES ? "tbar-fixed" : "tbar-scroll";
        $tableclass = $this->fix_header == self::YES ? "m3table-fixed" : "m3table-scroll";

        echo "<table id=\"tbar\" class=\"normal lightback $tbclass\">";
        echo "<tr><td style=\"padding-top: 5px;\"><div class=\"mmsubhead\">{$this->admtext['edopts']}: $cfgfile</div></td></tr>";
        echo "</table>";
        echo "<table id=\"m3table\" class=\"normal lightback $tableclass\">";
        echo "<tr><td>";
        if (!is_writable($cfgpath)) {
            echo "<span style=\"color:red;\">{$this->admtext['cfgnowrite']}</span>";
            exit;
        }
        // show the parameters editing form
        for ($i = 0; isset($params[$i]); $i++) {
            $relpath = str_replace($this->rootpath, '', $params[$i]['tgt']);
            echo "
<form method=\"post\" action=\"\">
<table class=\"normal tfixed\">
<tr>
   <td class='databack edpanel mmleftcol'>
      {$params[$i]['label']}
   </td>
   <td class='databack edpanel mmrightcol'>
      <div>$relpath: {$params[$i]['param']}</div>
      <textarea class=\"w100\" name=\"param[val]\">{$params[$i]['val']}</textarea>
      <input type='hidden' name=\"param[mod]\" value=\"$this->modname\">
      <input type='hidden' name=\"param[version]\" value=\"$this->version\">
      <input type='hidden' name=\"param[def]\" value=\"{$params[$i]['def']}\">
      <input type='hidden' name=\"param[tgt]\" value=\"{$params[$i]['tgt']}\">
      <input type='hidden' name=\"param[cfg]\" value=\"{$params[$i]['cfg']}\">
      <input type='hidden' name=\"param[param]\" value=\"{$params[$i]['param']}\">
      <input type='hidden' name=\"param[quot]\" value=\"{$params[$i]['quot']}\">
      <div class=\"edbuttonbar\">
         <button type='submit' name=\"submit\" value=\"pUpdate\">{$this->admtext['update']}</button>&nbsp;&nbsp;
         <button type='submit' name=\"submit\" value=\"pRestore\">{$this->admtext['restore']}</button>&nbsp;&nbsp;
      </div>
   </td>
</tr>
</table>
</form>";
        } // each parameter

        echo "
<tr>
<td>
<div class=\"lightback edreturn\">
   <form method=\"post\" action=\"\">
            <button type='submit' name=\"submit\" value=\"pCancel\">{$this->admtext['return']}</button>
   </form>
</div>
</td>
</tr>
</table>";
        return true;
    } // show_editor

    public function update_parameter($param) {

        while (empty($param['quot'])) {
            if (is_numeric($param['val']) && is_numeric($param['def'])) {
                break;
            }
            $val = strtolower($param['val']);
            $def = strtolower($param['def']);

            if ($def == 'true' || $def == 'false') {
                if ($val == 'true' || $val == 'false') {
                    break;
                }
            }

            if ($param['def'] != '') {
                $param['val'] = $param['def'];
                break;
            }
            return true;
        }

        $this->modname = $param['mod'];
        $this->version = $param['version'];
        $this->new_logevent("{$this->admtext['updparam']} {$param['param']}: <span class=\"msgbold\">{$param['tgt']}</span> {$this->admtext['formodname']} <span class=\"msgbold\">{$param['mod']}</span>");
        $this->cfgpath = $param['cfg'];
        $this->cfgfile = pathinfo($param['cfg'], PATHINFO_BASENAME);
        if (!is_writable($param['cfg'])) {
            $this->mod_status = self::ERRORS;
            $this->add_logevent("<span class=\"msgerror\">{$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$param['cfg']} %parameter:% {$param['param']}</span>");
            $this->add_logevent("{$this->admtext['fileperms']} ({$param['cfg']})");
            $this->write_eventlog();
            header("Location: admin_showmodslog.php");
            exit;
        }
        if (!is_writable($param['tgt'])) {
            $this->mod_status = self::ERRORS;
            $this->add_logevent("<span class=\"msgerror\">{$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$param['tgt']} %parameter:% {$param['param']}</span>");
            $this->add_logevent("{$this->admtext['fileperms']} ({$param['tgt']})");
            $this->write_eventlog();
            header("Location: admin_showmodslog.php");
            exit;
        }
        $success = 0;
        /*******************************************************************
         * UPDATE TARGET FILE WITH NEW PARAMETER VALUE
         *******************************************************************/
        // READ TARGET FILE INTO BUFFER TO UPDATE PARAMETER
        $target_file_contents = $this->read_file_buffer($param['tgt']);

        // prepare original quoting around variable value
        $quotes = '';
        if ($param['quot'] == 1) {
            $quotes = "'";
        } elseif ($param['quot'] == 2) {
            $quotes = '"';
        }

        // replacing a numerical variable with nothing is FATAL ERROR
        // prevent it by replacing the 'nothing' with zero (0)
        if ($param['val'] !== 0) {
            if (empty($quotes) && empty($param['val'])) {
                $param['val'] = 0;
            }
        }

        // remove any surrounding single or double quotes from new parameter value
        $varval = trim($param['val'], "\"'");

        //escape internal single quotes
        $varval = str_replace("'", "\\'", $varval);

        // add original quoting
        $varval = $quotes . $varval . $quotes;

        // escape $ sign and brackets in variable name
        $varname = str_replace("$", "\\$", $param['param']);
        $varname = str_replace("[", "\\[", $varname);
        $varname = str_replace("]", "\\]", $varname);

        $reg_exp = "#(" . $varname . "\\s*=\\s*)([^;]*)#";
        if (!preg_match($reg_exp, $target_file_contents, $matches)) {
            $this->add_logevent("<span class=\"msgerror\">{$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$param['tgt']} %parameter:% {$param['param']}</span>");
            $this->mod_status = self::CANTUPD;
        } else {
            $success++;
            $this->add_logevent("<span class=\"msgapproved\">{$param['param']} {$this->admtext['updated']}</span> ($varval)");
            $this->mod_status = self::UPDATED;
        }
        // UPDATE THE FIRST OCCURANCE IN THE TARGET FILE
        $targetstr = $matches[0];
        $updatestr = $matches[1] . $varval;
        $pos = strpos($target_file_contents, $targetstr);
        if ($pos !== false) {
            $target_file_contents = substr_replace($target_file_contents, $updatestr, $pos, strlen($targetstr));
        }
        // SAVE UPDATED PARAMETER TO TARGET FILE
        $this->write_file_buffer($param['tgt'], $target_file_contents);
        unset($target_file_contents);

        /*******************************************************************
         * UPDATE MOD CONFIG FILE WITH NEW PARAMETER VALUE
         *******************************************************************/
        // READ MOD CONFIG FILE INTO BUFFER TO UPDATE PARAMETER
        $config_file_contents = $this->read_file_buffer($param['cfg']);

        // IF MOD CONFIG FILE HAS INSERTED $VAR=VAL INTO TARGET FILE, UPDATE MOD CONFIG
        // VALUE TO PREVENT BAD TARGET ERRORS
        // This will replace all occurrences, so it is important that the same $var name
        // not be used in more than one location.
        $config_file_contents = str_replace($targetstr, $updatestr, $config_file_contents);

        // update the %parameter line val for backward compatibility
        $regex = '#%parameter:' . $varname . ':\\s*[^%]*%#';
        $parval = trim($param['val'], "\"'");
        $replacement = "%parameter:" . $param['param'] . ":" . $parval . "%";

        // This will replace all occurrences, so it is important that the same $var name
        // not be used for more than one parameter in the mod config file.
        $config_file_contents = preg_replace($regex, $replacement, $config_file_contents);

        // SAVE UPDATED PARAMETER TO MOD CONFIG FILE
        $this->write_file_buffer($param['cfg'], $config_file_contents);
        $this->write_eventlog();
        return $success;
    }

    public function restore_parameter($param) {

        while (empty($param['quot'])) {
            if (is_numeric($param['val']) && is_numeric($param['def'])) {
                break;
            }
            $val = strtolower($param['val']);
            $def = strtolower($param['def']);

            if ($def == 'true' || $def == 'false') {
                if ($val == 'true' || $val == 'false') {
                    break;
                }
            }

            if ($param['def'] != '') {
                $param['val'] = $param['def'];
                break;
            }
            return true;
        }

        $this->mod_status = self::ERRORS;
        $this->modname = $param['mod'];
        $this->version = $param['version'];
        $this->new_logevent("{$this->admtext['restparam']} {$param['param']}: <span class=\"msgbold\">{$param['tgt']}</span> {$this->admtext['formodname']} <span class=\"msgbold\">{$param['mod']}</span>");
        $this->cfgpath = $param['cfg'];
        $this->cfgfile = pathinfo($param['cfg'], PATHINFO_BASENAME);
        if (!is_writable($param['cfg'])) {
            $this->add_logevent("<span class=\"msgerror\">{$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$param['cfg']} %parameter:% {$param['param']}</span>");
            $this->add_logevent("{$this->admtext['fileperms']} ({$param['cfg']})");
            $this->write_eventlog();
            header("Location: admin_showmodslog.php");
            exit;
        }
        if (!is_writable($param['tgt'])) {
            $this->add_logevent("<span class=\"msgerror\">{$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$param['tgt']} %parameter:% {$param['param']}</span>");
            $this->add_logevent("{$this->admtext['fileperms']} ({$param['tgt']})");
            $this->write_eventlog();
            header("Location: admin_showmodslog.php");
            exit;
        }
        $success = 0;

        /*******************************************************************
         * UPDATE TARGET FILE WITH DEFAULT PARAMETER VALUE
         *******************************************************************/
        // READ TARGET FILE INTO BUFFER
        $target_file_contents = $this->read_file_buffer($param['tgt']);

        // remove surrounding single or double quotes from default parameter value
        $varval = trim($param['def'], "\"'");

        // escape internal single quotes
        $varval = str_replace("'", "\\'", $varval);

        // add original surrounding quotes if any
        $quotes = '';
        if ($param['quot'] == 1) {
            $quotes = "'";
        } elseif ($param['quot'] == 2) {
            $quotes = '"';
        }
        $varval = $quotes . $varval . $quotes;

        // escape $ sign and brackets in variabel name
        // should already have been trimmed and escaped!!
        $varname = str_replace("$", "\\$", $param['param']);
        $varname = str_replace("[", "\\[", $varname);
        $varname = str_replace("]", "\\]", $varname);

        $reg_exp = "#([^\w]" . $varname . "\\s*=\\s*)([^;]*)#";
        if (!preg_match($reg_exp, $target_file_contents, $matches)) {
            $this->add_logevent("<span class=\"msgerror\">{$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$param['param']}</span>");
            $this->mod_status = self::CANTUPD;
        } else {
            $success++;
            $this->add_logevent("<span class=\"msgapproved\">{$param['param']} {$this->admtext['updated']}</span> ($varval)");
            $this->mod_status = self::UPDATED;
        }

        // RESTORE THE FIRST OCCURANCE TO DEFAULT VALUE
        $targetstr = $matches[0];
        $updatestr = $matches[1] . $varval;
        $pos = strpos($target_file_contents, $targetstr);
        if ($pos !== false) {
            $target_file_contents = substr_replace($target_file_contents, $updatestr, $pos, strlen($targetstr));
        }
        // SAVE UPDATED BUFFER TO TARGET FILE
        $this->write_file_buffer($param['tgt'], $target_file_contents);
        unset($target_file_contents);

        /*******************************************************************
         * UPDATE MOD CONFIG FILE WITH DEFAULT PARAMETER VALUE
         *******************************************************************/
        // READ MOD CONFIG FILE INTO BUFFER
        $config_file_contents = $this->read_file_buffer($param['cfg']);

        // IF MOD CONFIG FILE INSERTED $VAR=VAL INTO TARGET FILE, UPDATE MOD CONFIG
        // VALUE TO PREVENT BAD TARGET ERRORS
        // This will replace all occurrences, so it is important that the same $var name
        // not be used in more than one location.
        $config_file_contents = str_replace($targetstr, $updatestr, $config_file_contents);

        // update the %parameter line val for backward compatibility
        $regex = '#%parameter:' . $varname . ':' . '[^%]*%#';
        $varval = trim($varval, "\"'");
        $replacement = "%parameter:" . $param['param'] . ":" . $varval . "%";

        // This will replace all occurrences, so it is important that the same $var name
        // not be used for more than one parameter in the mod config file.
        $config_file_contents = preg_replace($regex, $replacement, $config_file_contents);

        // SAVE DEFAULT PARAMETER VALUE TO MOD CONFIG FILE
        $this->write_file_buffer($param['cfg'], $config_file_contents);
        $this->write_eventlog();
        return $success;
    }
} // class modparser

