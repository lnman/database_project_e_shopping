<?php
//change oci_connect variables

if(isset($_POST['uname'])&& isset($_POST['passwd'])) 
{
	$conn = oci_connect('system', '0112358','ORCL');

	if($conn) {}
	else {exit ("connection failed: " .$conn);}
	$name = $_POST['uname'];
	$q = 'SELECT passwd from tabletest where uname=:uname';

	$query = oci_parse($conn, $q);
	oci_bind_by_name($query, ':name', $name);

	$passwd=oci_execute($query);
	if($passwd==md5($_POST['passwd']))
	{
		session_start();
		oci_close($conn);
		header('Location:home.php');
	}
	else {
		oci_close($conn);
		header('Location:login.php');
	}
	
}
else{

}

?>