<?php
require_once 'class.login.php';
require_once 'class.header.php';
$head=new Header();
$head->show_header("Product View");
if(isset($_GET['id'])){
	require_once 'class.buyer.php';
	$by=new Buyer();
	$by->get_product_data($_GET['id']);
}

$head->show_footer("product_view.js");

?>