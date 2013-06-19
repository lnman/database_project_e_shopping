<?php

require_once 'class.header.php';
require_once 'class.myself.php';
require_once 'class.login.php';
$head=new header();
$head->show_header("My account");
if(Login::isLoggedIn())
{
	$me=new Myself();
	if(isset($_POST['name']))
	{
		$mail='';$ph='';$sq='';$sa='';
		if(isset($_POST['email']))$mail=$_POST['email'];
		if(isset($_POST['phone']))$ph=$_POST['phone'];
		if(isset($_POST['sq']))$sq=$_POST['sq'];
		if(isset($_POST['sa']))$sa=$_POST['sa'];
		$me->update_myinfo($_POST['name'],$mail,$ph,$sq,$sa);
		echo '<div class="row-fluid alert alert-success"><div class="span9 pagination-centered"><p>'.'Account Updated'.'</p></div></div>';

	}
	$me->get_myinfo();
}

$head->show_footer("");
?>