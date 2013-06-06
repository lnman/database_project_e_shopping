<?php

if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['uname'])&&isset($_POST['passwd']))
{
	require_once 'class.login.php';
	Login::log_in($_POST['uname'],$_POST['passwd']);
}
else {
	require_once 'class.login.php';
	require_once 'header.php';
	$head=new header();
	$head->show_header();
	if(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']=='http://localhost/login.php'){Login::show_error();}
	?>
	<!--Code For Login -->
    <div class="row-fluid">
      <div class="span9 offset2">
      <form id="signin" class="form-horizontal" method="post" >
    <legend>Sign In</legend>
    <div class="control-group">
          <label class="control-label">Username</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-user"></i></span>
          <input type="text" class="input-xlarge" id="uname" name="uname" placeholder="Username">
        </div>
      </div>
    </div>
    <div class="control-group">
          <label class="control-label">Password</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-lock"></i></span>
          <input type="Password" id="passwd" class="input-xlarge" name="passwd" placeholder="Password">
        </div>
      </div>
    </div>

    <div class="control-group">
    <label class="control-label"></label>
        <div class="controls">
         <button type="submit" class="btn btn-success" >Log In</button>
		 <a class="offset1">Forgot Password?</a>
        </div>
      </div>
    </form>
      </div>
    </div>
<?php
	$head->show_footer("login_validate.js");
}
?>
