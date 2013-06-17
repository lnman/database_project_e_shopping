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

	public function has_notification($id,$type)
	{
		# code...
		require_once "database_config.inc.php";
		$conn = oci_connect(db_user, db_pass,db_service);
		if($conn) {
			$q = 'SELECT last_not from ';
			if($type==1)$q.=' buyer ';
			if($type==2)$q.=' seller ';
			if($type==3)$q.=' advertiser ';
			$q.=' where userid=:auserid';
	        $query = oci_parse($conn, $q);
	        oci_bind_by_name($query, ':auserid', $id);
	        oci_execute($query);
	        $db_data=oci_fetch_array($query);
	        $prev=$db_data[0];

	        $q = 'SELECT max(Notific_id) from notifications  where userid=:auserid';
	        $query = oci_parse($conn, $q);
	        oci_bind_by_name($query, ':auserid', $id);
	        oci_execute($query);
	        $db_data=oci_fetch_array($query);
	        if(!$db_data)$db_data[0]=0;
	        $new=$db_data[0];
	        oci_close($conn);
	        if($prev<$new)return true;
	        else return false;
		}
	}

	public function show_header($title)
	{
		require_once 'class.login.php';
		if(Login::isLoggedIn()){
			if(strcmp($_SERVER['PHP_SELF'],'/login.php')==0 or strcmp($_SERVER['PHP_SELF'],'/register.php')==0 )
			{
				header("Location: home.php");
				die();
			}
		}
		
		?>
		<!DOCTYPE html>
			<html>
			  <head>
			    <meta charset="utf-8">
			    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
			    <title><?php echo $title;?></title>
			    <meta name="viewport" content="width=device-width, initial-scale=1.0">
			    <!-- Bootstrap -->
			    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
			    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
			    <link href="css/bootstrap-fileupload.min.css" rel="stylesheet" media="screen">
			  </head>
			  <body>
			    <div class="navbar navbar-inverse">
			      <div class="navbar-inner">
			        <div class="container">
			          
			          <a class="brand" href="./index.html">E-shopping</a>
			          <div class="nav-collapse collapse">
			          	<ul class="nav">
			            
		<?php
		$menus = array();
		if(Login::isLoggedIn())
		{
			if(Login::getUser()!=='Admin' && $this->has_notification(Login::getUser(),Login::getType()))
			{
				$menus = array('Home'=>'home','Notification<img src="./img/new_icon.jpg" style="height :20px;width: 50px;">' =>'notification');
			}
			else $menus = array('Home'=>'home','Notification' =>'notification');
		}
		else {
			$menus = array('Home'=>'home','Register'=>'register' ,'Login'=>'login');
		}
		foreach ($menus as $key => $value) 
		{
			if(strcmp($_SERVER['PHP_SELF'],'/'.$value.'.php')==0)
			{
				echo '<li class="active">';
			}else{echo '<li class="">';}
			echo '<a href="./'.$value.'.php">'.$key.'</a></li>';
		}
		if(Login::isLoggedIn()){
			$user=Login::getUser();
			$type=Login::getType();
			$submenu;
			if($type==1)
			{
				$submenu = array('Bookmarks'=>'bookmark','Booked Product'=>'booked_product','My Cart <img src="/img/cart.jpg"></img><label id="change"/>'=>'cart','check out'=>'check_out','Log out'=>'logout' );
			}else if($type==2){
				$submenu = array('Add product'=>'add_product','My product' =>'my_product' ,'Log out'=>'logout');

			}else if($type==3){
				$submenu = array('Add advertisement'=>'add_advertisement','My advertisement' =>'my_advertisement' ,'Log out'=>'logout');

			}else{
				$submenu = array('Report'=>'report' ,'View User List'=>'view_user','Log out'=>'logout');
			}
			echo '</ul>'.'<ul class="nav pull-right">';
			echo '<li class="dropdown">';
			echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$user.'<b class="caret"></b></a>';
			echo '<ul class="dropdown-menu">';
			foreach ($submenu as $key => $value) {
				echo '<li class=""><a href="./'.$value.'.php">'.$key.'</a></li>';
			}
			echo '</ul></li>';
		}
		?>		
			            </ul>
			          </div>
			        </div>
			      </div>
			    </div>
		<?php

	}
	public function show_footer($additional_script)
	{
		?>
				<div class="navbar navbar-bottom">
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
			    <script src="js/bootstrap-carousel.js"></script>
			    <script src="js/bootstrap-fileupload.min.js"></script>
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