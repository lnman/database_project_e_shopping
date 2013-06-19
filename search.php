<?php

require_once 'class.header.php';
require_once 'class.search.php';

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$head=new header();
	$head->show_header("Search");
	$sh='%';
	if(isset($_POST['search'])&&$_POST['search']!=="")$sh=$_POST['search'];
	$cat="";$time="";$manu="";$price="";$ship="";
	if(isset($_POST['category'])&&$_POST['category']!=='All Category')$cat=$_POST['category'];
	if(isset($_POST['time'])&&$_POST['time']!=='Forever'&&$_POST['time']!=="")$time=$_POST['time'];
	if(isset($_POST['manufacturer'])&&$_POST['manufacturer']!=='')$manu=$_POST['manufacturer'];
	if(isset($_POST['price_from'])&&isset($_POST['price_to'])&&$_POST['price_from']!=="")$price=array($_POST['price_from'],$_POST['price_to']);
	if(isset($_POST['shipping_region']))$ship=$_POST['shipping_region'];

	$srch=new Search($sh,$cat,$time,$price,$manu,$ship);
	$srch->set_search_and_page(0);
	$srch->show_search_bar();
	$head->show_footer("search.js");
}else if($_SERVER['REQUEST_METHOD']=='GET'&&isset($_GET['type']))
{
	$head=new header();
	$head->show_header("Search");
	$srch=new Search('%',$_GET['type'],"","","","");
	$srch->set_search_and_page(0);
	$srch->show_search_bar();
	$head->show_footer("search.js");
}else
{
	$head=new header();
	$head->show_header("Search");
	$srch=new Search("","","","","","");
	$srch->show_search_bar();
	$head->show_footer("search.js");
}
?>