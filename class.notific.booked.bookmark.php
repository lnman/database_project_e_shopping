<?php

/**
* 
*/
class notific_booked_bookmark
{
	
	function __construct(argument)
	{
		# code...
	}

	public static function show_notification($page=0)
	{
		echo '<table class="table">';
	    require("database_config.inc.php");
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT description from notifications where userid=:user orderby time';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':user',$user);
	      oci_execute($query);
	      $x=0+20*$page;
	      while($db_data=oci_fetch_array($query)){
	        $desc=$db_data[0];
	        echo '<tr class="noific">'.$desc.'</tr>';
	        $x++;
	        if($x>20*($page+1))break;
	      }
	      oci_close($conn);
	      echo '</table>';
	    }
	    else {exit ('DB Connection failed contact Administrator');}

	}


	public static function show_booked_product($page=0)
	{
		echo '<table class="table">';
	    require("database_config.inc.php");
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT product_id,name,num_of_book,expiredate from Booked_product where userid=:user orderby expiredate';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':user',$user);
	      oci_execute($query);
	      $x=0+20*$page;
	      while($db_data=oci_fetch_array($query)){
	        echo '<tr class="booked_product">'.'<td>'.$db_data[0].'</td>'.'<td>'.$db_data[1].'</td>'.'<td>'.$db_data[2].'</td>'.'<td>'.$db_data[3].'</td>'.'<tr>';
	        $x++;
	        if($x>20*($page+1))break;
	      }
	      oci_close($conn);
	      echo '</table>';
	    }
	    else {exit ('DB Connection failed contact Administrator');}

	}

	public static function show_bookmarks($page=0)
	{
		echo '<table class="table">';
	    require("database_config.inc.php");
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT product_id,name from Bookmarks where userid=:user';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':user',$user);
	      oci_execute($query);
	      $x=0+20*$page;
	      while($db_data=oci_fetch_array($query)){
	        echo '<tr class="bookmarks">'.'<td>'.$db_data[0].'</td>'.'<td>'.$db_data[1].'</td>'.'<tr>';
	        $x++;
	        if($x>20*($page+1))break;
	      }
	      oci_close($conn);
	      echo '</table>';
	    }
	    else {exit ('DB Connection failed contact Administrator');}

	}

	public static function add_booked_product($product_id,$no,$exp)
	{

		require("database_config.inc.php");
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'insert  Booked_product values(:user,:product_id,:no_of_book,:expiredate)';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':user',$user);
	      oci_bind_by_name($query, ':product_id',$product_id);
	      oci_bind_by_name($query, ':no_of_book',$no);
	      oci_bind_by_name($query, ':expiredate',$exp);
	      oci_execute($query);
	      oci_close($conn);
	      
	    }
	    else {exit ('DB Connection failed contact Administrator');}
	}

	public static function add_bookmarks($product_id)
	{
		require("database_config.inc.php");
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'insert  Bookmarks values(:user,:product_id)';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':user',$user);
	      oci_bind_by_name($query, ':product_id',$product_id);
	      oci_execute($query);
	      oci_close($conn);
	      
	    }
	    else {exit ('DB Connection failed contact Administrator');}

	}

	public static function delete_booked_product($product_id)
	{

		require("database_config.inc.php");
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'Delete * from Booked_product where userid=:user and product_id=:product_id';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':user',$user);
	      oci_bind_by_name($query, ':product_id',$product_id);
	      oci_execute($query);
	      oci_close($conn);
	      
	    }
	    else {exit ('DB Connection failed contact Administrator');}
	}

	public static function delete_bookmarks($product_id)
	{
		require("database_config.inc.php");
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'Delete * from Bookmarks where userid=:user and product_id=:product_id';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':user',$user);
	      oci_bind_by_name($query, ':product_id',$product_id);
	      oci_execute($query);
	      oci_close($conn);
	      
	    }
	    else {exit ('DB Connection failed contact Administrator');}

	}

}


?>