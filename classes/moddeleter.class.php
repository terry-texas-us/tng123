<?php
/*
   Mod Manager 12 deleter class
   It also provide logging services.

   Data:

   Methods:
      public function delete_mod( $cfgpath );
      public function batch_delete( $cfgpathlist );
*/

include_once 'classes/modbase.class.php';

class moddeleter extends modbase
{
  protected $classID = "deleter";

  function __construct($objinits) {
    // pass arguments thru to base class
    parent::__construct($objinits);
    //echo __LINE__;print_r(get_defined_vars());exit;
  }

  public function delete_mod($cfgpath) {

    // parse file to get logging info
    $support_folder = '';
    //$this->cfgpath = $cfgpath;
    $cfgfile = pathinfo($cfgpath, PATHINFO_BASENAME);
    $contents = file_get_contents($cfgpath, null, null, 0);

    if (preg_match("#%name:([^%]+)%#", $contents, $matches)) {
      $this->modname = $matches[1];
    } else {
      $this->modname = "no name";
    }

    $this->new_logevent("{$this->admtext['deleting']} <strong>$cfgfile</strong>");


    // SEE IF WE HAVE A SUPPORT FOLDER TO DELETE FROM THE MODS DIRECTORY
    if ($this->delete_support) {

      preg_match_all("#%copyfile[2]?:([^%]+)%#", $contents, $matches);

      // PATH TO SUPPORT FOLDER FOR DELETION
      $support_folder = '';
      foreach ($matches[1] as $match) {

        // source on left [0], destination on right [1] (discard)
        $args = explode(":", $match, $limit = 2);
        $args[0] = trim($args[0], " /");

        // only delete source folder in the mods dir
        if (false !== strpos($args[0], "../")) {
          continue;
        }

        // if just file name ignore it
        $pos = strpos($args[0], "/");
        if ($pos === false) {
          continue;
        }

        // need to delete top level folder
        $parts = explode("/", $args[0], $limit = 2);
        $support_folder = trim($parts[0]);

        if (empty($support_folder)) {
          continue;
        }

        $support_folder = $this->rootpath . $this->modspath . $support_folder;

        break;
      }

      if (!empty($support_folder)) {

        // DELETE SUPPORT FOLDER - only if mods is parent
        $parent = pathinfo($support_folder, PATHINFO_DIRNAME);
        if ($parent == $this->rootpath . $this->modspath) {

          $retstat = $this->delTree($support_folder);
          if ($retstat == false) {
            $this->add_logevent($this->admtext['cantdel'] . ' ' . $support_folder);
          } else {
            $this->add_logevent($this->admtext['folder'] . ' ' . $support_folder . ' ' . $this->admtext['deleted']);
          }
        }
      }
    } // support folder

//echo '<br /> line ',__LINE__;exit;

    if (@!unlink($cfgpath)) {
      $msg = "<span class=\"hilighterr msgbold\">{$this->admtext['cantdel']} $cfgfile</span>";
      $this->mod_status = self::CANTDEL;
      $success = false;
    } else {
      $msg = "<span class=\"msgapproved\">$cfgfile {$this->admtext['filedel']}</span>";
      $this->mod_status = self::FILEDEL;
      $success = true;
    }
    $this->add_logevent($msg);
    $this->write_eventlog();
    return $success;
  }

  /**********************************************************************
   * SUPPORTING FUNCTIONS
   **********************************************************************/
  public function batch_delete($cfgpathlist) {
    foreach ($cfgpathlist as $cfgpath) {
      if (!$this->delete_mod($cfgpath)) {
        $this->batch_error = true;
      };
    }
    return !$this->batch_error;
  }

  private function delTree($dir) {

    if (!file_exists($dir)) {
      return true;
    }

    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
      (is_dir("$dir/$file") && !is_link($dir)) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
  }
}
