<?php
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

$_SESSION["User_ID"]=null;
$_SESSION["User_name"]=null;
$_SESSION["Aname"]=null;

session_destroy();

Redirect_to("Login.php");

?>