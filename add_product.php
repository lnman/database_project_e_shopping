<?php

require_once 'class.header.php';
require_once 'class.login.php';
$head=new Header();
$head->show_header("Add product");
if(Login::isLoggedIn()&&Login::getType()==2)
{
	require_once 'class.seller.php';
	$sl=new Seller();
	if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['name'])&&isset($_POST['manu'])&&isset($_POST['cat'])&&isset($_POST['price'])&&isset($_POST['n_o_p'])&&$_FILES["file_1"]["error"] <= 0)
	{
		$tech="";
		if(isset($_POST['tech']))$tech=$_POST['tech'];
		$fileName = $_FILES['file_1']['name'];
		$tmpName  = $_FILES['file_1']['tmp_name'];
		$fileSize = $_FILES['file_1']['size'];
		$fileType = $_FILES['file_1']['type'];
		$fp      = fopen($tmpName, 'r');
		$content_1 = fread($fp, filesize($tmpName));
		fclose($fp);
		$content_2="";
		if($_FILES["file_2"]["error"]<=0){
			$fileName = $_FILES['file_2']['name'];
			$tmpName  = $_FILES['file_2']['tmp_name'];
			$fileSize = $_FILES['file_2']['size'];
			$fileType = $_FILES['file_2']['type'];
			$fp      = fopen($tmpName, 'r');
			$content_2 = fread($fp, filesize($tmpName));
			fclose($fp);
		}
		$content_3="";
		if($_FILES["file_3"]["error"]<=0){
			$fileName = $_FILES['file_3']['name'];
			$tmpName  = $_FILES['file_3']['tmp_name'];
			$fileSize = $_FILES['file_3']['size'];
			$fileType = $_FILES['file_3']['type'];
			$fp      = fopen($tmpName, 'r');
			$content_3 = fread($fp, filesize($tmpName));
			fclose($fp);
		}
		$sl->add_product($_POST['name'],$_POST['manu'],$_POST['cat'],$_POST['price'],$_POST['n_o_p'],$tech,$content_1,$content_2,$content_3);
		?>
		<div class='row-fluid'>
		<div class='span6 offset3'>
			<img src='./img/done.jpg'>
		</div>
		</div>
		<?php
		$head->show_footer("");
	}
	else{
	$sl->show_add_product();
	$head->show_footer("product_validate.js");}
}
else
{
	header('Location: login.php');
	die();
}

?>