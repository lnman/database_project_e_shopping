<?php

/**
* Register class
* Usage: create object,call check
* check returns "Success" if inserted
*/
class Register
{
	private $Username ,$PASSWORD,$PASS2,$NAME ,$Date_of_birth ,$Gender,$User_type ,$Nid,$Age ,$Phone_No ,$Email ,$Secret_Q ,$Secret_A,$Salt;
	public function __construct($Username ,$PASSWORD,$PASS2,$NAME ,$Date_of_birth ,$Gender,$User_type ,$Phone_No ,$Email ,$Secret_Q ,$Secret_A)
	{
		$this->$Username =$Username;
		$this->$PASSWORD=$PASSWORD;
		$this->$PASS2=$PASS2;
		$this->$NAME=$NAME;
		$this->$Date_of_birth=$Date_of_birth;
		$this->$Gender=$Gender;
		$this->$User_type=$User_type;
		$this->$Age=calcutateAge($this->$Date_of_birth);
		$this->$Phone_No=$Phone_No;
		$this->$Email=$Email;
		$this->$Secret_Q=$Secret_Q;
		$this->$Secret_A=$Secret_A;
		$this->$Salt=$this->createSalt();
	}
	public function check_and_insert()
	{
		if($this->check_password()!==''){return $this->check_password();}
		if($this->check_other()!==''){return $this->check_other();}
		return $this->check_db_and_insert();
	}

	private function check_password()
	{
		$error='';
		if($this->$PASSWORD==null){return 'Password cannot be null';}
		if($this->$PASSWORD!==$this->$PASS2){return 'Password does not match';}
		if( strlen($this->$PASSWORD) < 8 ) {
			$error .= "Password too short! ";
		}
		if( !preg_match("#[0-9]+#",$this->$PASSWORD) ) {
			$error .= "Password must include at least one number! ";
		}
		if( !preg_match("#[a-z]+#", $this->$PASSWORD) ) {
			$error .= "Password must include at least one letter! ";
		}
		if( !preg_match("#[A-Z]+#", $this->$PASSWORD) ) {
			$error .= "Password must include at least one CAPS! ";
		}
		if( !preg_match("#\W+#", $this->$PASSWORD) ) {
			$error .= "Password must include at least one symbol! ";
		}
		return $error;
	}
	private function check_other()
	{
		if($this->$Username==null){return 'Username cannot be null';}
		if($this->$NAME==null){return 'Name cannot be null';}
		list($year, $month, $day, $hour, $minute, $second) = preg_split('%( |-|:)%', $this->$Date_of_birth);
		if(!checkdate($month, $day, $year)){return 'Date is not valid';}
		if($this->$Gender!=='M' or $this->$Gender!=='F' ){return 'Gender must be either M or F';}
		if($this->$Phone_No==null){return 'Phone no cannot be null';}
		if(!filter_var($this->$Email, FILTER_VALIDATE_EMAIL)){return 'Email Address is not valid';}
		if($this->$Secret_Q==null){return 'Secret Question no cannot be null';}
		if($this->$Secret_A==null){return 'Secret Answer cannot be null';}
		return '';
	}


	private function check_db_and_insert()
	{
		require("databse_config.inc.php");
		$conn = oci_connect(db_user, db_pass,db_service);
		if($conn) {
			$q = 'SELECT count(*) from USER_List where Username=:Username or Phone_No=:Phone_No or Email=:Email';
			$query = oci_parse($conn, $q);
			oci_bind_by_name($query, ':Username', $this->$Username);
			oci_bind_by_name($query, ':Phone_No', $this->$Phone_No);
			oci_bind_by_name($query, ':Email', $this->$Email);
			$res=oci_execute($query);
			if($res>0){return 'Username or Phone_No or Email already in use';}

			/*get nid*/
			$q = 'SELECT count(*) from USER_List';
			$query = oci_parse($conn, $q);
			$this->$Nid=oci_execute($query)+1;

			/*insert here*/
			$q = 'insert into USER_List values(:$Username ,:$PASSWORD,:$NAME ,:$Date_of_birth ,:$Gender,:$Nid ,:$User_type ,:$Age ,:$Phone_No ,:$Email ,:$Secret_Q ,:$Secret_A,:$Salt) ';
			$query = oci_parse($conn, $q);
			oci_bind_by_name($query, ':$Username', $this->$Username);
			oci_bind_by_name($query, ':$PASSWORD', hash('sha256',$this->$Salt.hash('sha256',$this->$PASSWORD)));
			oci_bind_by_name($query, ':$NAME', $this->$NAME);
			oci_bind_by_name($query, ':$Date_of_birth', $this->$Date_of_birth);
			oci_bind_by_name($query, ':$Gender', $this->$Gender);
			oci_bind_by_name($query, ':$Nid', $this->$Nid);
			oci_bind_by_name($query, ':$User_type', $this->$User_type);
			oci_bind_by_name($query, ':$Age', $this->$Age);
			oci_bind_by_name($query, ':$Phone_No', $this->$Phone_No);
			oci_bind_by_name($query, ':$Email', $this->$Email);
			oci_bind_by_name($query, ':$Secret_Q', $this->$Secret_Q);
			oci_bind_by_name($query, ':$Secret_A', $this->$Secret_A);
			oci_bind_by_name($query, ':$Salt', $this->$Salt);
			oci_execute($query);
			oci_close($conn);
			return "Success";
		}
		else {exit ('DB Connection failed contact Administrator');}

	}


	private function calcutateAge($dob)
	{
        $dob = date("Y-m-d",strtotime($dob));
        $dobObject = new DateTime($dob);
        $nowObject = new DateTime();
        $diff = $dobObject->diff($nowObject);
        return $diff->y;
	}

	private function createSalt()
	{
	    $string = md5(uniqid(rand(), true));
	    return substr($string, 0, 3);
	}
}


?>