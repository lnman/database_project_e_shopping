<?php

require_once 'class.header.php';
require_once 'class.search.php';

$head=new header();
$head->show_header("Home");
$srch=new Search("","","","","","");
$srch->show_search_bar();
$head->show_footer("");

?>