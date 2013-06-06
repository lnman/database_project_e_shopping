<?php


/**
* 
*/
class Login
{
	
	function __construct()
	{
		# code...
	}

	public static function log_in($user,$pass)
	{
		require("database_config.inc.php");
		$pass=mysql_real_escape_string($pass);
		$conn = oci_connect(db_user, db_pass,db_service);

		if($conn) {
			$q = 'SELECT PASSWORD,Salt from User_list where Username=:uname';
			$query = oci_parse($conn, $q);
			oci_bind_by_name($query, ':uname', $user);
			oci_execute($query);
			if(oci_num_rows($query)<1){
				unset($_SERVER['REQUEST_METHOD']);
				header("Location: login.php");
				die();
			}
			$db_data=oci_fetch_array($query);
			oci_close($conn);
			if($db_data['PASSWORD']==hash('sha256', $db_data['Salt'].hash('sha256', $pass)))
			{
				self::validateUser($user);
				header('Location : index.php');
				die();
			}
			else
			{
				header('Location : login.php');
				die();
			}

		}
		else {exit ('DB Connection failed contact Administrator');}
	} 

	private static function validateUser($userid)
	{
	    session_regenerate_id (); 
	    $_SESSION['valid'] = 1;
	    $_SESSION['userid'] = $userid;
	}

	public static function isLoggedIn()
	{
	    if(isset($_SESSION['valid']) && $_SESSION['valid'])
	        return true;
	    return false;
	}

	public static function getUser()
	{
		return $_SESSION['userid'];
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
}


?>