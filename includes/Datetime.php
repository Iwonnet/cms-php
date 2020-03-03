<?php

date_default_timezone_set("Europe/Warsaw");
$currenttime = time();
$displaycurrenttime = strftime("%A , %d-%B-%Y %H:%M:%S",$currenttime);
echo $displaycurrenttime;
