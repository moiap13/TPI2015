<?php
session_start();
session_destroy();
session_start();


/****************************************************************
 * Author               : Antonio Pisanello                     *
 * Class                : Ecole d'informatique Genève IN-P4A    *
 * Version              : 1.0                                   *
 * Date of modification : AVRIL - MAI 2015                      *
 * Modification         :                                       *
 ****************************************************************/

$_SESSION["conn"] = false;

if(isset($_REQUEST["page"]))
    header("Location: " . $_REQUEST["page"] . ".php");
else
    header("Location: ../../index.php");