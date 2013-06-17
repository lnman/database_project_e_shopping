<?php


/**
* 
*/
class Admin
{
	
	function __construct()
	{
		# code...
	}

	public function show_report($page=0)
	{
		echo '<table class="table">';
	    require("database_config.inc.php");
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT description from report order by id';
	      $query = oci_parse($conn, $q);
	      oci_execute($query);
	      $x=0+20*$page;
	      while($db_data=oci_fetch_array($query)){
	        $desc=$db_data[0];
	        echo '<tr class="report">'.$desc.'</tr>';
	        $x++;
	        if($x>20*($page+1))break;
	      }
	      oci_close($conn);
	      echo '</table>';
	    }
	    else {exit ('DB Connection failed contact Administrator');}
	}

	public function show_user_list($page=0)
	{
		echo '<table class="table">';
	    require("database_config.inc.php");
	    echo '<legend>View user List</legend>';
	    echo '<tr class="user_list">'.'<td>'."Username".'</td>'.'<td>'."user Type".'</td>'.'</tr>';
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT username,user_type from user_list order by nid';
	      $query = oci_parse($conn, $q);
	      oci_execute($query);
	      $x=0+20*$page;
	      while($db_data=oci_fetch_array($query)){
	        echo '<tr class="user_list">'.'<td>'.$db_data[0].'</td>'.'<td>'.$db_data[1].'</td>'.'</tr>';
	        $x++;
	        if($x>20*($page+1))break;
	      }
	      oci_close($conn);
	      echo '</table>';
	    }
	    else {exit ('DB Connection failed contact Administrator');}
	}
}

?>