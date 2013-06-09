<?php

require_once 'class.login.php';
session_start();
if(Login::isLoggedIn())
{
	Login::logout();
}
header("Location: login.php");
?>