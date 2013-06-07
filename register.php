<?php
$res="empty";
if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['fname'])&&isset($_POST['lname'])&&isset($_POST['dob'])&&isset($_POST['email'])&&isset($_POST['phone'])&&isset($_POST['gender'])&&isset($_POST['user_type'])&&isset($_POST['sq'])&&isset($_POST['sa'])&&isset($_POST['uname'])&&isset($_POST['passwd'])&&isset($_POST['conpasswd']))
{
  require_once 'class.register.php';
  $reg=new Register($_POST['uname'],$_POST['passwd'],$_POST['conpasswd'],$_POST['fname']." ".$_POST['lname'],$_POST['dob'],$_POST['gender'],$_POST['user_type'],$_POST['phone'],$_POST['email'],$_POST['sq'],$_POST['sa']);
  $res=$reg->check_and_insert();
  if($res=="Success"){die();}
}
require_once 'header.php';
require_once 'class.register.php';
$head=new header();
$head->show_header('Register');
if($res!=="empty"){
  echo '<div class="row-fluid alert alert-error"><div class="span9 pagination-centered"><p>'.$res.'</p></div></div>';
}
Register::show_register();
$head->show_footer("register_validate.js");
?>