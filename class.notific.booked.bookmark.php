<?php

/**
* 
*/
class notific_booked_bookmark
{
	
	function __construct()
	{
		# code...
	}

	public static function show_notification($page=0)
	{
		echo '<table class="table">';
		echo '<tr class="noific">'.'<th>'.'time'.'</th>'.'<th>'.'description'.'</th>'.'</tr>';
	    require_once "database_config.inc.php";
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT ntime,description,notific_id from notifications where userid=:auser order by ntime';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':auser',$user);
	      oci_execute($query);
	      $x=0+20*$page;
	      $mm=0;
	      while($db_data=oci_fetch_array($query)){
	        echo '<tr class="noific">'.'<td>'.$db_data[0].'</td>'.'<td>'.$db_data[1].'</td>'.'</tr>';
	        $x++;
	        if($db_data[2]>$mm)$mm=$db_data[2];
	        if($x>20*($page+1))break;
	      }
	      $q = 'update ';
	      if(Login::getType()==1)$q.=' buyer ';
	      if(Login::getType()==2)$q.=' seller ';
	      if(Login::getType()==3)$q.=' advertiser ';
	      $q.=' set last_not=:mm where userid=:auser';
	      $query = oci_parse($conn, $q);
	      oci_bind_by_name($query, ':auser',$user);
	      oci_bind_by_name($query, ':mm',$mm);
	      oci_execute($query);
	      oci_close($conn);
	      echo '</table>';
	    }
	    else {exit ('DB Connection failed contact Administrator');}

	}


	public static function show_booked_product($page=0)
	{
		echo '<table class="table">';
		echo '<tr class="noific">'.'<th>'.'Product_id'.'</th>'.'<th>'.'number of product'.'</th>'.'<th>'.'Expire date'.'</th>'.'</tr>';
	    require_once "database_config.inc.php";
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT product_id,no_of_book,expire_date from Booked_product where user_id=:auser order by expire_date';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':auser',$user);
	      oci_execute($query);
	      $x=0+20*$page;
	      while($db_data=oci_fetch_array($query)){
	        echo '<tr class="booked_product">'.'<td>'.$db_data[0].'</td>'.'<td>'.$db_data[1].'</td>'.'<td>'.$db_data[2].'</td>'.'<tr>';
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
		echo '<tr class="noific">'.'<th>'.'Bookmark Id'.'</th>'.'<th>'.'Product Id'.'</th>'.'</tr>';
	    require_once "database_config.inc.php";
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT Bookmark_id,Product_id from Bookmarks where userid=:auser';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':auser',$user);
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

	public static function add_booked_product($product_id,$no)
	{

		require_once "database_config.inc.php";
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {

	    	$q = 'SELECT max(Booked_product_id) from Booked_product ';
			$query = oci_parse($conn, $q);
			oci_execute($query);
			$db_data=oci_fetch_array($query);
			if(!$db_data)$db_data[0]=0;
			$db_data[0]=$db_data[0]+1;
	      $q = 'insert into Booked_product values(:aid,:auser,:aproduct_id,:ano_of_book,sysdate)';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':aid',$db_data[0]);
	      oci_bind_by_name($query, ':auser',$user);
	      oci_bind_by_name($query, ':aproduct_id',$product_id);
	      oci_bind_by_name($query, ':ano_of_book',$no);
	      oci_execute($query);

	      $q = 'select  userid from product where id=:product_id';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':product_id',$product_id);
	      oci_execute($query);
	      $res=oci_fetch_array($query);
	      oci_close($conn);
	      if($res[0])self::add_notification($res[0],$user.' booked '.$no.' of product no '.$product_id);
	      
	    }
	    else {exit ('DB Connection failed contact Administrator');}
	}

	public static function add_notification($id,$desc)
	{

		require_once "database_config.inc.php";
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {

	    	$q = 'SELECT max(Notific_id) from notifications';
			$query = oci_parse($conn, $q);
			oci_execute($query);
			$db_data=oci_fetch_array($query);
			if(!$db_data)$db_data[0]=0;
			$db_data[0]=$db_data[0]+1;
		      $q = 'insert into  notifications values(:aid,:auserid,:adesc,sysdate)';
		      $query = oci_parse($conn, $q);
		      oci_bind_by_name($query, ':aid',$db_data[0]);
		      oci_bind_by_name($query, ':auserid',$id);
		      oci_bind_by_name($query, ':adesc',$desc);
		      oci_execute($query);
		      oci_close($conn);
	      
	    }
	    else {exit ('DB Connection failed contact Administrator');}
	}

	public static function add_bookmarks($product_id)
	{
		require_once "database_config.inc.php";
	    require_once "class.login.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	    	$q = 'SELECT max(Bookmark_id) from Bookmarks';
			$query = oci_parse($conn, $q);
			oci_execute($query);
			$db_data=oci_fetch_array($query);
			if(!$db_data)$db_data[0]=0;
			$db_data[0]=$db_data[0]+1;
	      $q = 'insert into  Bookmarks values(:aid,:auser,:aproduct_id)';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':auser',$user);
	      oci_bind_by_name($query, ':aproduct_id',$product_id);
	       oci_bind_by_name($query, ':aid',$db_data[0]);
	      oci_execute($query);
	      oci_close($conn);
	      
	    }
	    else {exit ('DB Connection failed contact Administrator');}

	}

	public static function delete_booked_product($product_id)
	{

		require_once "database_config.inc.php";
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
		require_once "database_config.inc.php";
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