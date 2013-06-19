<?php


/**
* Login class
* Most of the members are static
* Originally need log_in and other get Methods
*/
class Login
{
	
	function __construct()
	{
		# code...

	}

	public static function log_in($user,$pass)
	{
		session_start();
		require("database_config.inc.php");
		$pass=mysql_real_escape_string($pass);
		$conn = oci_connect(db_user, db_pass,db_service);
		if($conn) {
			$q = 'SELECT PASSWORD,Salt,user_type from User_list where Username=:uname';
			$query = oci_parse($conn, $q);
			oci_bind_by_name($query, ':uname', $user);
			oci_execute($query);
			unset($_SERVER['REQUEST_METHOD']);
			while($db_data=oci_fetch_array($query)){
				if($db_data[0]==hash('sha256', $db_data[1].hash('sha256', $pass)))
				{
					self::validateUser($user,$db_data[2]);
					header('Location: home.php');
					die();
				}
				else
				{
					header('Location: login.php');
					die();
				}
			}
			oci_close($conn);
			header("Location: login.php");
			die();

		}
		else {exit ('DB Connection failed contact Administrator');}
	} 

	private static function validateUser($userid,$type)
	{
	    session_regenerate_id (); 
	    $_SESSION['valid'] = 1;
	    $_SESSION['userid'] = $userid;
	    $_SESSION['type'] = $type;
	}

	public static function isLoggedIn()
	{
	    if(isset($_SESSION['valid']) && $_SESSION['valid']){
	    	return true;
	    }
	    return false;
	}

	public static function getUser()
	{
		return $_SESSION['userid'];
	}

	public static function getType()
	{
		return $_SESSION['type'];
	}

	public static function show_error()
	{
		?>
		<div class="row-fluid alert alert-error">
      		<div class="span9 pagination-centered">
      			<p>The password did not match</p>
      		</div>
      	</div>
		<?php
	}

	public static function logout()
	{
	    $_SESSION = array();
	    session_destroy();
	}


	public static function show_login()
	{
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
	}
}


?>