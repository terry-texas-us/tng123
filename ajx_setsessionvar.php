<?php
include("begin.php");
include("adminlib.php");

include("checklogin.php");

if ($currentuser) {
    $varname = cleanIt($varname);
    $varvalue = cleanIt($varvalue);
    $_SESSION[$varname] = $varvalue;
}
