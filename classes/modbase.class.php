<?php
/*
   Mod Manager 12 modbase class

   Class is extended by modparser.

   This class contains fundamental constants, data and functons
   needed by other mod manager processing classes.

   It provides file reading and writing as well as status logging services.

   Data:
      Common data

   Methods:
      No public methods
*/

class modbase
{

  // GENERAL FLAGS
  const YES = "1";
  const NO = "0";

  const NOERR = 0;
  const ERROR = -1;
  const WARNING = -2;

  // PARSE TABLE FLAGS
  const FLAG_OPTIONAL = '@';
  const FLAG_NOFOUL = '^';
  const FLAG_PROTECTED = '~';

  // BUFFER STATUS FLAGS
  const BYPASS = '1';
  const NOFILE = '2';
  const NOWRITE = '3';
  const ISEMPTY = '4';
  const NOFOUL = '5';

  // FILE STATE FLAGS
  const NOPATH = "-1";
  const NOMODS = "1";

  // MOD LIST SORT FLAGS
  const NAMECOL = "0";
  const FILECOL = "1";

  // MOD LIST FILTER FLAGS
  const F_ALL = 0;
  const F_READY = 1;
  const F_INSTALLED = 2;
  const F_CLEAN = 3;
  const F_BADCFG = 4;
  const F_SELECT = 5;

  // MOD OPERATION FLAGS
  const INSTALL = 1;
  const REMOVE = 2;
  const DELETE = 3;
  const CLEANUP = 4;
  const EDITP = 5;
  const UPDATEP = 6;
  const RESTOREP = 7;

  // PATH CONSTRUCTION FLAGS
  const ROOT_DIR = 0;
  const MODS_DIR = 1;

  // LANGUAGE INDEXES
  const BADVERSION = 'badversion';
  const BOMFOUND = 'bomfound';
  const CANTDEL = 'cantdel';
  const CANTINST = 'cantinst';
  const CANTPROC = 'cantproc';
  const CANTUPD = 'cantupd';
  const DEFVAL = 'defval';
  const EMPTYFILE = 'emptyfile';
  const ERRORS = 'errors';
  const FILEDEL = 'filedel';
  const FILEPERMS = 'fileperms';
  const FORMAT = 'format';
  const INSTALLED = 'installed';
  const LINE = 'line';
  const MISSFILE = 'missfile';
  const MISSING = 'missing';
  const MODREM = 'modrem';
  const NOACCESS = 'noaccess';
  const NOACT = 'noact';
  const NOCFGFILE = 'nocfgfile';
  const NOCOMPS = 'nocomps';
  const NODESC = 'nodesc';
  const NOEND = 'noend';
  const NOLOCATION = 'nolocation';
  const NOPARAM = 'noparam';
  const NOSOURCE = 'srcfilemissing';
  const NOTARGET = 'notarget';
  const NOTWRITE = 'notwrite';
  const NOTINST = 'notinst';
  const OK2INST = 'ok2inst';
  const PARTINST = 'partinst';
  const REQTAG = 'reqtag';
  const TAGNOTERM = 'tagnoterm';
  const TAGUNK = 'tagunk';
  const UNXEND = 'unxend';
  const UPDATED = 'updated';

  /*
     const YES = "1";
     const NO = "0";

     const NOERR       =  0;
     const ERROR       = -1;
     const WARNING     = -2;

     // flags
     const FLAG_OPTIONAL     = '@';
     const FLAG_NOFOUL       = '^';
     const FLAG_PROTECTED    = '~';

     // file buffer return states
     const BYPASS   = '1';
     const NOFILE   = '2';
     const NOWRITE  = '3';
     const ISEMPTY  = '4';
     const NOFOUL   = '5';

     const NOPATH = "-1";
     const NOMODS = "1";

     // sorting
     const NAMECOL = "0";
     const FILECOL = "1";

     // paths
     const ROOT_DIR    = 0;
     const MODS_DIR    = 1;

     // values used for mod_status and logging
     const ERRORS      = 'errors';
     const CANTDEL     = 'cantdel';
     const CANTINST    = 'cantinst';
     const CANTPROC    = 'cantproc';
     const FILEDEL     = 'filedel';
     const CANTUPD     = 'cantupd';
     const INSTALLED   = 'installed';
     const MODREM      = 'modrem';
     const NOTINST     = 'notinst';
     const OK2INST     = 'ok2inst';
     const UPDATED     = 'updated';
  */

  protected $enventlog = null;
  protected $eventlog = '';
  protected $num_errors = 0;
  protected $provisional_errors = 0;

  // initializers
  protected $rootpath = '';
  protected $subroot = '';
  protected $extspath = '';
  protected $modspath = '';
  protected $modname = '';
  protected $version = '';
  protected $tng_version = '';
  protected $int_version = 0;
  protected $time_offset = 0;
  protected $sitever = 'standard';
  protected $currentuserdesc = '';
  protected $admtext = array();

  // options
  public $sortby = 0;
  protected $modlogfile = 'modmgrlog.txt';
  protected $maxloglines = 2000;
  protected $delete_partial = false;
  protected $delete_installed = false;
  protected $show_affected_files = true;
  protected $show_AFnewfile = true;
  protected $show_AFfilecopies = true;

  protected $fix_header = 1;
  protected $use_striping = false;
  protected $stripe_after = 3;
  protected $log_full_path = true;
  protected $wikibase = "https://tng.lythgoes.net/wiki/index.php?title=";

  // batch processing
  protected $batch_error = false;

  public function __construct($objinits) {

    // copy init values to data area
    foreach ($objinits as $key => $value) {
      if ($key == 'options') {
        foreach ($value as $option => $ovalue) {
          $this->$option = $ovalue;
        }
      } else {
        $this->$key = $value;
      }
      // if visitor is mobile don't use fixed headers
      if ($this->sitever == 'mobile') {
        $this->fix_header = 0;
      }
    }
      $this->int_version = $this->version2integer($this->tng_version);

      if (!empty($this->admtext['error'])) {
          $this->admtext['error'] = "<span class=\"msgerror\"><strong>{$this->admtext['error']}</strong></span>";
      }
      if (!empty($this->admtext['okay'])) {
          $this->admtext['okay'] = "<span class=\"msgapproved\"><strong>{$this->admtext['okay']}</strong></span>";
      }
  } // __construct

// BUFFERS

    protected function fix_eol($buffer)
    {
        return preg_replace("#(?:\r\n|\r\r\n|[\r\n])#", "\r\n", $buffer);
    }

    // remove spaces or tabs in from of CRLF that might prevent target match
    protected function remove_hidden_whitespace($buffer)
    {
        return preg_replace("#[ \t]*\r\n#", "\r\n", $buffer);
    }

  protected function read_file_buffer($filepath, $flag = '') {
    $buffer = '';

    // UNCOMMENT NEXT LINE TO USE RELATIVE PATHS FOR FILE READS
    //$filepath = str_replace( $this->rootpath, '', $filepath );

    // FILEPATH DOES NOT EXIST
    if (!file_exists($filepath)) {

      if ($flag == self::FLAG_OPTIONAL) {
        return self::BYPASS;
      } elseif ($flag == self::FLAG_NOFOUL) {
        $this->provisional_errors++;
        return self::NOFOUL;
      } // FLAG_PROTECTED ONLY APPLIES TO FILE COPIES - NO NEED TO ACT HERE
      else {
        $this->num_errors++;
        return self::NOFILE;
      }
    }
    // TARGET FILE PATH IS NOT WRITABLE
    $ext = pathinfo($filepath, PATHINFO_EXTENSION);
    if ($ext != 'cfg' && !is_writable($filepath)) {
      $this->num_errors++;
      return self::NOWRITE;
    }

    // GET FILE CONTENTS INTO BUFFER - PROTECT FILE WITH SHARED LOCK
    $fhandle = fopen($filepath, 'rb');
    flock($fhandle, LOCK_SH);
    $buffer = $this->fix_eol(file_get_contents($filepath));
    $buffer = $this->remove_hidden_whitespace($buffer);
    fclose($fhandle);

    // FILE IS EMPTY
    if (empty($buffer)) {
      $this->num_errors++;
      return self::ISEMPTY;
    }

    // GOOD BUFFER
    return $buffer;
  } // GET FILE BUFFER

  protected function write_file_buffer($filepath, $buffer) {

    // UNCOMMENT NEXT LINE TO USE RELATIVE PATHS FOR FILE WRITES
    //$filepath = str_replace( $this->rootpath, '', $filepath );

    $fp = fopen($filepath, 'wb');
    if (!$fp) {
        $_SESSION['err_msg'] = "{$this->admtext['checkwrite']} {$this->admtext['cannotopen']} $filepath ";
        return false;
    }
      flock($fp, LOCK_EX);
      $ret = fwrite($fp, $buffer);
      flock($fp, LOCK_UN);
      fclose($fp);
      return $ret;
  }

// LOGS

    protected function add_logevent($string)
    {
        $this->eventlog .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;" . $string;
    }

    private function create_logfile()
    {
        $rootpath = $this->rootpath;

        $content = "#### Mod Manager Log " . date("D d M Y h:i:s A", time() + (3600 * $this->time_offset)) . " ####";
        return $this->write_file_buffer($this->modlogfile, $content);
  }

  // begin logging for new event
  protected function new_logevent($string) {

    // get elements for enhanced header line
    $datetime = date("D d M Y h:i:s A", time() + (3600 * $this->time_offset));
    if ($this->classID == 'installer') {
      $operation = "<span class=\"msgbold\">{$this->admtext['install']}</span>";
    } elseif ($this->classID == 'remover') {
      $operation = "<span class=\"msgbold\">{$this->admtext['uninstall']}</span>";
    } elseif ($this->classID == 'cleaner') {
      $operation = "<span class=\"msgbold\">{$this->admtext['cleanup']}</span>";
    } elseif ($this->classID == 'editor') {
      $operation = "<span class=\"msgbold\">{$this->admtext['edparams']}</span>";
    } elseif ($this->classID == 'deleter') {
      $operation = "<span class=\"msgbold\">{$this->admtext['delete']}</span>";
    } else {
      $operation = '';
    }

    $modname = $this->modname;
    $modversion = $this->version;

    $this->eventlog = $datetime . ' | ' . $operation . ' | ' . $modname . ' ' . $modversion . ' | zzzxxzzz | ' . $this->currentuserdesc . ' xxxzzxxx';
    $this->add_logevent($string);
  }


  protected function write_eventlog($error = false) {
    $mod_status = $this->mod_status;
    $hlight = empty($error) ? ' highlight' : ' hilighterr';

    // if log file is missing start a new one
    if (!file_exists($this->modlogfile)) {
      if (!$this->create_logfile()) {
        $_SESSION['err_msg'] = "{$this->admtext['checkwrite']} {$this->admtext['cantwrite']} $this->modlogfile !";
        unset($this->eventlog);
        return false;
      }
    }

    // import existing log lines
    $lines = file($this->modlogfile);

    // add dynamic results to event log
    $modstat1 = "<span class=\"msgbold$hlight\">{$this->admtext[$mod_status]}</span>";
    $modstat2 = " <span class=\"hidden\">$mod_status</span>";

    $this->eventlog = str_replace("zzzxxzzz", $modstat1, $this->eventlog);
    $this->eventlog = str_replace("xxxzzxxx", $modstat2, $this->eventlog);

    // add new event log lines to $lines array
    array_unshift($lines, $this->eventlog . "\n");

    $fp = @fopen($this->modlogfile, "w");
    if (!$fp) {
      $_SESSION['err_msg'] = "{$this->admtext['checkwrite']} {$this->admtext['cannotopen']} $this->modlogfile ";
      unset($this->eventlog);
      return false;
    }

    flock($fp, LOCK_EX);
    $linecount = 0;
    foreach ($lines as $line) {
      trim($line);
      if ($line) {
        fwrite($fp, $line);
      }
      $linecount++;
        if ($linecount == $this->maxloglines) {
            break;
        }
    }
      flock($fp, LOCK_UN);
      fclose($fp);
      unset($this->eventlog);
      return;
  }

// MODS

    public function get_modfile_names()
    {
        $fileNames = array();

        if ($handle = opendir($this->modspath)) {
            while (false !== ($file = readdir($handle))) {
                if (pathinfo($file, PATHINFO_EXTENSION) == 'cfg') {
                    $fileNames[] = $file;
                }
            }
      closedir($handle);
      sort($fileNames);
    }
    return $fileNames;
  }

  // returns file names (no path) as array indexes and mod name as array values
  public function get_modlist_sorted() {

      $mod_list = array();

    if (!is_dir($this->modspath)) {
      return self::NOPATH;
    }
    // get file list -- look up names & add to list
    $modfiles = $this->get_modfile_names();

    foreach ($modfiles as $modfile) {
      $contents = $this->read_file_buffer($this->rootpath . $this->modspath . '/' . $modfile);

      // HANDLE FILE ACCESS ERRORS IF ANY
      if (is_numeric($contents)) {
        $mod_list[$modfile] = $this->admtext['noaccess'];
        continue;
      }
      preg_match('#.*%name:([^%]*).*#s', $contents, $matches);
      if (isset($matches[1])) {
        $mod_list[$modfile] = trim($matches[1]);
      } else {
        $mod_list[$modfile] = '';
      }
    }
    if (!count($mod_list)) {
      return self::NOMODS;
    }
    // Natrually sorted by file name - resort by mod name
    if ($this->sortby == self::NAMECOL) {
      // use temporary array because we can't actually change file name
      $temp = array_map('strtolower', $mod_list);

      array_multisort($temp, SORT_ASC, SORT_STRING, $mod_list);
    }
    return $mod_list;
  }

  // construct full paths for each file
  protected function resolve_file_path($path, $relative = self::ROOT_DIR) {

      // leading slash unnecesary - all paths relative to tng root
    $path = ltrim($path, "/");

    // set path for TNG config files
    if (in_array($path, $this->configs)) {
      return $this->subroot . $path;
    } elseif ($relative == self::MODS_DIR) {
      $path = $this->resolve_path_vars($path);
      return $this->rootpath . $this->modspath . '/' . $path;
    } else {
        return $this->rootpath . $this->resolve_path_vars($path);
    }
  }

    protected function resolve_path_vars($str)
    {
        $str = str_replace('$modspath', $this->modspath, $str);
        $str = str_replace('$extspath', $this->extspath, $str);
        return $str;
    }


// MISCELLANEOUS

    protected function version2integer($version)
    {
        $int_version = preg_replace("#[^0-9]#", "", $version);
        return (int)str_pad($int_version, 4, "0", STR_PAD_RIGHT);
    }

} // CLASS
