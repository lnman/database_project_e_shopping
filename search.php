<?php

require_once 'class.header.php';
require_once 'class.search.php';

if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['search'])&&$_POST['search']!=="")
{
	$head=new header();
	$head->show_header("Search");
	$cat="";
	if(isset($_POST['category'])&&$_POST['category']!=='All Category')$cat=$_POST['category'];
	$time="";
	if(isset($_POST['time'])&&$_POST['time']!=='Forever')$time=$_POST['time'];
	$manu="";
	if(isset($_POST['manufacturer'])&&$_POST['manufacturer']!=='')$manu=$_POST['manufacturer'];
	$price="";
	if(isset($_POST['price_from'])&&isset($_POST['price_to'])&&$_POST['price_from']!=="")$price=array($_POST['price_from'],$_POST['price_to']);
	$ship="";
	if(isset($_POST['shipping_region']))$ship=$_POST['shipping_region'];

	$srch=new Search($_POST['search'],$cat,$time,$price,$manu,$ship);
	$srch->set_search_and_page(0);
	$srch->show_search_bar();
	$head->show_footer("");
}
else{
	$head=new header();
	$head->show_header("Search");
	$srch=new Search("","","","","","");
	$srch->show_search_bar();
	$head->show_footer("");
}
?>