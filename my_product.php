<?php
require_once 'class.header.php';
require_once 'class.login.php';
$head=new Header();
$head->show_header("My product");
if(Login::isLoggedIn()&&Login::getType()==2)
{
	require_once 'class.seller.php';
	$sl=new Seller();
	$sl->show_my_product();
	$head->show_footer("");
}
else
{
	header('Location: login.php');
	die();
}


?>