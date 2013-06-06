<?php

/**
* header class for the project
* footer is also shown
*/
class header
{
	
	function __construct()
	{
		# code...
		session_start();
	}


	function show_header()
	{
		require_once 'class.login.php';
		?>
		<!DOCTYPE html>
			<html>
			  <head>
			    <meta charset="utf-8">
			    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
			    <title>Login</title>
			    <meta name="viewport" content="width=device-width, initial-scale=1.0">
			    <!-- Bootstrap -->
			    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
			    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
			  </head>
			  <body>
			    <div class="navbar navbar-inverse">
			      <div class="navbar-inner">
			        <div class="container">
			          
			          <a class="brand" href="./index.html">E-shopping</a>
			          <div class="nav-collapse collapse">
			          	<ul class="nav">
			            
		<?php
		if(Login::isLoggedIn())
		{

		}
		else {
			$menus = array('index','register' ,'login');
			foreach ($menus as $value) 
			{
				if(strcmp($_SERVER['PHP_SELF'],'/'.$value.'.php')==0)
				{
					echo '<li class="active">';
				}else{echo '<li class="">';}
				echo '<a href="./'.$value.'.php">'.$value.'</a></li>';
			}
		?>		
			            </ul>
			          </div>
			        </div>
			      </div>
			    </div>
		<?php
		}

	}
	function show_footer($additional_script)
	{
		?>
				<div class="navbar navbar-fixed-bottom">
			      <div class="span12 offset2">
			        <div class="span1"><a href="./index.php">Community</a></div>   
			        <div class="span1"><a href="./index.php">Security Center</a></div>
			        <div class="span1"><a href="./index.php">Policy</a></div>
			        <div class="span1"><a href="./index.php">Sitemap</a></div>
			        <div class="span1"><a href="./index.php">Contact Us</a></div>
			        <div class="span4"><a href="./index.php">Tell us what you think</a></div>
			      </div>
			    </div>
			    <script src="js/jquery.js"></script>
			    <script src="js/bootstrap.min.js"></script>
			    <script src="js/jquery.validate.js"></script>
		<?php
		$add=preg_split("/[\s,]+/", $additional_script,-1,PREG_SPLIT_NO_EMPTY);
		foreach ($add as $value) {
			# code...
			echo '<script src="js/'.$value.'"></script>';
		}
		?>
			</body>
		</html>
		<?php

	}


}


?>