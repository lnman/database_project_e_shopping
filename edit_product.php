<?php

require_once 'class.header.php';
require_once 'class.login.php';
$head=new Header();
$head->show_header("Edit Product");
if(Login::isLoggedIn()&&Login::getType()==2)
{
	require_once 'class.seller.php';
	$sl=new Seller();
	if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['id'])&&isset($_POST['update']))
	{
		$name="";$Manufacturer="";$CATEGORY="";$Price="";$No_of_product="";$Technical_detail="";$Pic_1="";$Pic_2="";$Pic_3="";
		if(isset($_POST['name']))$name=$_POST['name'];
		if(isset($_POST['manu']))$Manufacturer=$_POST['manu'];
		if(isset($_POST['cat']))$CATEGORY=$_POST['cat'];
		if(isset($_POST['price']))$Price=$_POST['price'];
		if(isset($_POST['n_o_p']))$No_of_product=$_POST['n_o_p'];
		if(isset($_POST['tech']))$Technical_detail=$_POST['tech'];
		if($_FILES["file_1"]["error"] <= 0){
			$fileName = $_FILES['file_1']['name'];
			$tmpName  = $_FILES['file_1']['tmp_name'];
			$fileSize = $_FILES['file_1']['size'];
			$fileType = $_FILES['file_1']['type'];
			$fp      = fopen($tmpName, 'r');
			$Pic_1 = fread($fp, filesize($tmpName));
			fclose($fp);
		}
		if($_FILES["file_2"]["error"] <= 0){
			$fileName = $_FILES['file_2']['name'];
			$tmpName  = $_FILES['file_2']['tmp_name'];
			$fileSize = $_FILES['file_2']['size'];
			$fileType = $_FILES['file_2']['type'];
			$fp      = fopen($tmpName, 'r');
			$Pic_2 = fread($fp, filesize($tmpName));
			fclose($fp);
		}
		if($_FILES["file_3"]["error"] <= 0){
			$fileName = $_FILES['file_3']['name'];
			$tmpName  = $_FILES['file_3']['tmp_name'];
			$fileSize = $_FILES['file_3']['size'];
			$fileType = $_FILES['file_3']['type'];
			$fp      = fopen($tmpName, 'r');
			$Pic_3 = fread($fp, filesize($tmpName));
			fclose($fp);
		}
		$sl->update_product($_POST['id'],$name,$Manufacturer,$CATEGORY,$Price,$No_of_product,$Technical_detail,$Pic_1,$Pic_2,$Pic_3);
		?>
		<div class='row-fluid'>
		<div class='span6 offset3'>
			<img src='./img/done.jpg'>
		</div>
		</div>
		<?php
		$head->show_footer("");
		die();
	}
	else{
	$sl->show_edit_product($_POST['id']);
	$head->show_footer("");}
}
else
{
	header('Location: login.php');
	die();
}

?>