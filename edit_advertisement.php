<?php

require_once 'class.header.php';
require_once 'class.login.php';
$head=new Header();
$head->show_header("Edit advertisement");
if(Login::isLoggedIn()&&Login::getType()==3)
{
	require_once 'class.advertiser.php';
	$ad=new Advertiser();
	if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['id'])&&isset($_POST['update'])&&(isset($_POST['name'])||isset($_POST['desc'])||isset($_POST['tag'])||$_FILES["file"]["error"] <= 0))
	{
		$name="";$desc="";$tag="";$content="";
		if(isset($_POST['name']))$name=$_POST['name'];
		if(isset($_POST['desc']))$desc=$_POST['desc'];
		if(isset($_POST['tag']))$tag=$_POST['tag'];
		if($_FILES["file"]["error"] <= 0){
			$fileName = $_FILES['file']['name'];
			$tmpName  = $_FILES['file']['tmp_name'];
			$fileSize = $_FILES['file']['size'];
			$fileType = $_FILES['file']['type'];
			$fp      = fopen($tmpName, 'r');
			$content = fread($fp, filesize($tmpName));
			fclose($fp);
		}
		$ad->update_advertisement($_POST['id'],$name,$desc,$tag,$content);
		die();
	}
	else{
	$ad->show_edit_advertisement($_POST['id']);
	$head->show_footer("");}
}
else
{
	header('Location: login.php');
	die();
}

?>