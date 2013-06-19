<?php


require_once 'class.login.php';
require_once 'class.header.php';

$head=new header();
$head->show_header("Report");

if(Login::isLoggedIn()&&Login::getType()==10)
{
	require_once 'class.admin.php';
	$ad=new Admin();
	$ad->show_report();
}
$head->show_footer("");

?>