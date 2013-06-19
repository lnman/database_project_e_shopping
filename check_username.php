<?php
require_once 'class.header.php';
require_once 'class.login.php';
$head=new Header();
if(!Login::isLoggedIn()&&isset($_POST['uname']))
{
	require("database_config.inc.php");
	$conn = oci_connect(db_user, db_pass,db_service);
	if($conn) {
		$q = 'SELECT count(*) from USER_List where Username=:aUsername';
		$query = oci_parse($conn, $q);
		oci_bind_by_name($query, ':aUsername', $_POST['uname']);
		oci_execute($query);
		$db_data=oci_fetch_array($query);
		if($db_data[0]>0){echo 'found';}
		else echo 'not found';
		oci_close($conn);
	}	


}
?>