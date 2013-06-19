<?php
require_once 'class.header.php';
require_once 'class.login.php';
$head=new Header();
$head->show_header("Notification");
if(Login::isLoggedIn()){
	require_once 'class.notific.booked.bookmark.php';
	$val=0;
	if(isset($_POST['page']))$val=$_POST['page'];
	echo '<div class="row-fluid"><legend>Notifications</legend><div class="span12"><div class="span6 offset2">';
	notific_booked_bookmark::show_notification($val);
	echo '</div></div></div>';
	$head->show_footer("notification.js");}
else header('Location: login.php')
?>