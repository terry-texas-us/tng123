<?php
include_once 'classes/modlister.class.php';

class modinfo extends modlister
{

  function __construct($objinits) {
    parent::__construct($objinits);
    $this->modname = '';
    $this->version = '';
    $this->description = '';
    $this->authors = array();
    $this->wikipage = '';
    $this->private = '';
    $this->status_header = '';
  }

  public function collect_info($modfile) {
    $this->set_modfile($modfile);
    // prevent output
    ob_start();
    $this->tags = $this->list_mods();
    ob_end_clean();
  }

  public function get_modname() {
    return $this->modname;
  }

  public function get_version() {
    return $this->version;
  }

  public function get_description() {
    return $this->description;
  }

  public function get_authors() {
    return $this->authors;
  }

  public function get_wikipage() {
    return $this->wikipage;
  }

  public function get_private() {
    return $this->private;
  }

  public function get_status() {
    return $this->status_header;
  }

  public function get_parse_table() {
    return $this->show_parse_table($this->tags);
  }

  public function get_target_files() {
    $targets = array();
    foreach ($this->tags as $tag) {
      if ($tag['name'] == 'target') {
        $targets[] = $tag['arg1'];
      }
    }
    return $targets;
  }
} // class
