<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
session_destroy();
session_start();

$_SESSION["conn"] = false;

if(isset($_REQUEST["page"]))
    header("Location: " . $_REQUEST["page"] . ".php");
else
    header("Location: ../../index.php");