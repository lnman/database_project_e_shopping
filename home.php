<?php

require_once 'class.header.php';
require_once 'class.home.php';

$head=new header();
$head->show_header("Home");
$ho=new Home();
$ho->show_home();
$head->show_footer("");


?>