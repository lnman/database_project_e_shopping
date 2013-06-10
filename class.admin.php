<?php


/**
* 
*/
class admin
{
	
	function __construct(argument)
	{
		# code...
	}

	public function show_report($page=0)
	{
		echo '<table class="table">';
	    require("database_config.inc.php");
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT description from report orderby time';
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
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT name,rank,register_date from user_list orderby register_date';
	      $query = oci_parse($conn, $q);
	      oci_execute($query);
	      $x=0+20*$page;
	      while($db_data=oci_fetch_array($query)){
	        $desc=$db_data[0];
	        echo '<tr class="user_list">'.'<td>'.$db_data[0].'</td>'.'<td>'.$db_data[1].'</td>'.'<td>'.$db_data[2].'</td>'.'<td>'.$db_data[3].'</td>'.'<tr>';
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