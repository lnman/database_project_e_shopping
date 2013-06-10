<?php

require_once 'class.header.php';
require_once 'class.login.php';
$head=new Header();
$head->show_header("Add advertisement");
if(Login::isLoggedIn()&&Login::getType()==3)
{
	require_once 'class.advertiser.php';
	$ad=new Advertiser();
	if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['name'])&&isset($_POST['desc'])&&isset($_POST['tag'])&&$_FILES["file"]["error"] <= 0)
	{
		$fileName = $_FILES['file']['name'];
		$tmpName  = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$fileType = $_FILES['file']['type'];
		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		fclose($fp);
		$ad->add_advertisement($_POST['name'],$_POST['desc'],$_POST['tag'],$content);
	}
	else{
	$ad->show_add_advertisement();
	$head->show_footer("");}
}
else
{
	header('Location: login.php');
	die();
}

?>