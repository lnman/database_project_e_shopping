<?php
require_once 'class.header.php';
require_once 'class.login.php';
$head=new Header();
if(Login::isLoggedIn()&&Login::getType()==1&&isset($_POST['id']))
{
	$res = array();
    $temp=explode('&',$_POST['id']);
    foreach ($temp as  $value) {
    	$tt=explode('=',$value);
    	$res[$tt[0]]=$tt[1];
    }
    require_once 'class.pay.php';
    Pay::all_seller($res,$_POST['ad']);
	echo "done";
	die();
}
else header('Location: login.php')
?>