<?php
require_once 'class.header.php';
$head=new Header();
$head->show_header("Notification");
$val=0;
if(isset($_POST['page']))$val=$_POST['page'];
$not= notific_booked_bookmark::show_notification($val);
$head->show_footer("");
?>