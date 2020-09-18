<?php

class StyleManager
{
    private array $ruleSets = [];

    public function __construct() {
    }

    public function addDeclaration($selector, $declaration) {
    }

    public function addSelector($selector, $declarationBlock) {
        $this->ruleSets[$selector] = $declarationBlock;
    }

    public function getSelector($selector) {
        if (array_key_exists($selector, $this->ruleSets)) {
            $declarationBlock = $this->ruleSets[$selector];
        } else {
            $trace = debug_backtrace();
            $message = 'Undefined selector via getSelector(): ' . $selector . ' in ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'];
            trigger_error($message, E_USER_NOTICE);
            $declarationBlock = [];
        }
        return $declarationBlock;
    }

    public function getStyle() {
        $out = "<style>";
        foreach ($this->ruleSets as $selector => $declarationBlocks) {
            $out .= $selector . "{";
            foreach ($declarationBlocks as $name => $value) {
                $out .= $name . ":" . $value . ";";
            }
            $out .= "}";
        }
        $out .= "</style>\n";
        return $out;
    }
}
