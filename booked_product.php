<?php
require_once 'class.header.php';
require_once 'class.login.php';
$head=new Header();

if(Login::isLoggedIn()&&Login::getType()==1&&isset($_POST['id'])&&isset($_POST['no']))
{
	require_once 'class.notific.booked.bookmark.php';
	notific_booked_bookmark::add_booked_product($_POST['id'],$_POST['no']);
	echo "done";
	die();
}
if(isset($_POST['id'])&&!Login::isLoggedIn()) {echo "not loggged";die();}
if(isset($_POST['id'])&&Login::getType()!==1){echo "not a buyer";die();}

$head->show_header("Bookmark");
if(Login::isLoggedIn()&&Login::getType()==1){
	require_once 'class.notific.booked.bookmark.php';
	$val=0;
	if(isset($_POST['page']))$val=$_POST['page'];
	echo '<div class="row-fluid"><legend>My booked Product</legend><div class="span12"><div class="span8 offset2">';
	notific_booked_bookmark::show_booked_product($val);
	echo '</div></div></div>';
	$head->show_footer("book.js");}

?>