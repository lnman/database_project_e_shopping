<?php

if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['uname'])&&isset($_POST['passwd']))
{
	require_once 'class.login.php';
	Login::log_in($_POST['uname'],$_POST['passwd']);
}
else {
	require_once 'class.login.php';
	require_once 'header.php';
	$head=new header();
	$head->show_header('Login');
	if(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']=='http://localhost/login.php'){Login::show_error();}
	Login::show_login();
	$head->show_footer("login_validate.js");
}
?>
