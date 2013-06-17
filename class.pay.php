<?php

/**
* 
*/
class Pay
{
	
	function __construct()
	{
	}

	public static function all_seller($val)
	{
		require_once "database_config.inc.php";
		$conn = oci_connect(db_user, db_pass,db_service);
		require_once 'class.login.php';
		$user=Login::getUser();
		if($conn) {
			$desc = array();
			$price = array();
			foreach ($val as $key => $value) {
				$q = "select id,userid,price from product where id=:ax";
				$query = oci_parse($conn, $q);
				oci_bind_by_name($query, ':ax', $key);
				oci_execute($query, OCI_DEFAULT) or die ("Unable to execute query");
				$db_data=oci_fetch_array($query);
				if($db_data)
				{
					if(!isset($desc[$db_data[1]]))$desc[$db_data[1]]='';
					if(!isset($price[$db_data[1]]))$price[$db_data[1]]=0;
					$desc[$db_data[1]].=';'.$db_data[0].':'.$val[$db_data[0]];
					$price[$db_data[1]]=$price[$db_data[1]]+$db_data[2]*$val[$db_data[0]];
				}
			}
			
			foreach ($desc as $key => $value) {
				$q = 'SELECT max(id) from ordered';
				$query = oci_parse($conn, $q);
				oci_execute($query);
				$db_data=oci_fetch_array($query);
				if(!$db_data)$db_data[0]=0;
				$db_data[0]=$db_data[0]+1;
				$q = "insert into ordered values (:aid,:aid1,:aid2,:adesc,:aprice,sysdate)";
				$query = oci_parse($conn, $q);
				oci_bind_by_name($query, ':aid', $db_data[0]);
				oci_bind_by_name($query, ':aid1', $key);
				oci_bind_by_name($query, ':aid2', $user);
				oci_bind_by_name($query, ':adesc', $value);
				oci_bind_by_name($query, ':aprice', $price[$key]);
				oci_execute($query, OCI_DEFAULT) or die ("Unable to execute query");

				// pay te insert

				$q = 'SELECT max(id) from pay';
				$query = oci_parse($conn, $q);
				oci_execute($query);
				$db_dat=oci_fetch_array($query);
				if(!$db_dat)$db_dat[0]=0;
				$db_dat[0]=$db_dat[0]+1;

				oci_commit($conn);

				$q = "insert into pay values (:aaid,:aaid1,:aaid2,:aoid,:aaprice)";
				$query = oci_parse($conn, $q);
				oci_bind_by_name($query, ':aaid', $db_dat[0]);
				oci_bind_by_name($query, ':aaid1', $key);
				oci_bind_by_name($query, ':aaid2', $user);
				oci_bind_by_name($query, ':aoid', $db_data[0]);
				oci_bind_by_name($query, ':aaprice', $price[$key]);
				oci_execute($query, OCI_DEFAULT) or die ("Unable to execute query");

				oci_commit($conn);
				
			}
			oci_close($conn);
		}
	}
}

?>