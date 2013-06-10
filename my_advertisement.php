<?php
require_once 'class.header.php';
require_once 'class.login.php';
$head=new Header();
$head->show_header("Add advertisement");
if(Login::isLoggedIn()&&Login::getType()==3)
{
	require_once 'class.advertiser.php';
	$ad=new Advertiser();
	$ad->show_my_advertisement();
	$head->show_footer("");
}
else
{
	header('Location: login.php');
	die();
}


?>