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
		$this->Username =$Username;
		$this->PASSWORD=$PASSWORD;
		$this->PASS2=$PASS2;
		$this->NAME=$NAME;
		$this->Date_of_birth=$Date_of_birth;
		$this->Gender=$Gender;
		$this->User_type=$User_type;
		$this->Age=$this->calculateAge($this->Date_of_birth);
		$this->Phone_No=$Phone_No;
		$this->Email=$Email;
		$this->Secret_Q=$Secret_Q;
		$this->Secret_A=$Secret_A;
		$this->Salt=$this->createSalt();
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
		if($this->PASSWORD==null){return 'Password cannot be null';}
		if($this->PASSWORD!==$this->PASS2){return 'Password does not match';}
		if( strlen($this->PASSWORD) < 8 ) {
			$error .= "Password too short! ";
		}
		if( !preg_match("#[0-9]+#",$this->PASSWORD) ) {
			$error .= "Password must include at least one number! ";
		}
		if( !preg_match("#[a-z]+#", $this->PASSWORD) ) {
			$error .= "Password must include at least one letter! ";
		}
		if( !preg_match("#[A-Z]+#", $this->PASSWORD) ) {
			$error .= "Password must include at least one CAPS! ";
		}
		if( !preg_match("#\W+#", $this->PASSWORD) ) {
			$error .= "Password must include at least one symbol! ";
		}
		return $error;
	}
	private function check_other()
	{
		if($this->Username==null){return 'Username cannot be null';}
		if($this->NAME==null){return 'Name cannot be null';}
		list($month, $day,$year) = preg_split('%( |-|:)%', $this->Date_of_birth);
		if(checkdate($month, $day, $year)){return 'Date is not valid';}
		if($this->Gender!=='M' and $this->Gender!=='F' ){return 'Gender must be either M or F';}
		if($this->Phone_No==null){return 'Phone no cannot be null';}
		if(!filter_var($this->Email, FILTER_VALIDATE_EMAIL)){return 'Email Address is not valid';}
		if($this->Secret_Q==null){return 'Secret Question no cannot be null';}
		if($this->Secret_A==null){return 'Secret Answer cannot be null';}
		return '';
	}


	private function check_db_and_insert()
	{
		require("database_config.inc.php");
		$conn = oci_connect(db_user, db_pass,db_service);
		if($conn) {
			$q = 'SELECT count(*) from USER_List where Username=:Username or Phone_No=:Phone_No or Email=:Email';
			$query = oci_parse($conn, $q);
			oci_bind_by_name($query, ':Username', $this->Username);
			oci_bind_by_name($query, ':Phone_No', $this->Phone_No);
			oci_bind_by_name($query, ':Email', $this->Email);
			oci_execute($query);
      $db_data=oci_fetch_array($query);
			if($db_data[0]>0){return 'Username or Phone_No or Email already in use';}

			/*get nid*/
			$q = 'SELECT count(*) from USER_List';
			$query = oci_parse($conn, $q);
			oci_execute($query);
			$db_data=oci_fetch_array($query);
			$this->Nid=$db_data[0]+1;
			/*insert here*/
			$q = 'insert into USER_List values(:Username ,:PASSWORD,:NAME ,:Date_of_birth ,:Gender,:Nid ,:User_type ,:Age ,:Phone_No ,:Email ,:Secret_Q ,:Secret_A,:Salt) ';
			$query = oci_parse($conn, $q);
			$pass_hash=hash('sha256',$this->Salt.hash('sha256',$this->PASSWORD));
			$this->Date_of_birth = date("d-M-Y",strtotime($this->Date_of_birth));
			oci_bind_by_name($query, ':Username', $this->Username);
			oci_bind_by_name($query, ':PASSWORD', $pass_hash);
			oci_bind_by_name($query, ':NAME', $this->NAME);
			oci_bind_by_name($query, ':Date_of_birth', $this->Date_of_birth);
			oci_bind_by_name($query, ':Gender', $this->Gender);
			oci_bind_by_name($query, ':Nid', $this->Nid);
			oci_bind_by_name($query, ':User_type', $this->User_type);
			oci_bind_by_name($query, ':Age', $this->Age);
			oci_bind_by_name($query, ':Phone_No', $this->Phone_No);
			oci_bind_by_name($query, ':Email', $this->Email);
			oci_bind_by_name($query, ':Secret_Q', $this->Secret_Q);
			oci_bind_by_name($query, ':Secret_A', $this->Secret_A);
			oci_bind_by_name($query, ':Salt', $this->Salt);
			oci_execute($query);
			oci_close($conn);
			return "Success";
		}
		else {exit ('DB Connection failed contact Administrator');}

	}


	private function calculateAge($dob)
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

	public static function show_register()
	{
		?>
		<!--Code For Register -->
    <div class="row-fluid">
      <div class="span9 offset2">
      <form id="signup" class="form-horizontal" method="post">
    <legend>Sign Up</legend>
    <div class="control-group">
          <label class="control-label">First Name</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-user"></i></span>
          <input type="text" class="input-xlarge" id="fname" name="fname" placeholder="First Name">
        </div>
      </div>
    </div>
    <div class="control-group ">
          <label class="control-label">Last Name</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-user"></i></span>
          <input type="text" class="input-xlarge" id="lname" name="lname" placeholder="Last Name">
        </div>
      </div>
    </div>
    <div class="control-group">
          <label class="control-label">Date of Birth</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-calendar"></i></span>
          <input type="date" class="input-xlarge" id="dob" name="dob" placeholder="date of birth">
        </div>
      </div>
    </div>
    <div class="control-group">
          <label class="control-label">Email</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-envelope"></i></span>
          <input type="text" class="input-xlarge" id="email" name="email" placeholder="Email">
        </div>
      </div>
    </div>
    <div class="control-group">
          <label class="control-label">Phone No</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-envelope"></i></span>
          <input type="text" class="input-xlarge" id="phone" name="phone" placeholder="phone no">
        </div>
      </div>
    </div>
    <div class="control-group">
          <label class="control-label">Secret Question</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-user"></i></span>
          <input type="text" class="input-xlarge" id="sq" name="sq" placeholder="Your Secret Question">
        </div>
      </div>
      <div class="control-group">
          <label class="control-label">Question Answer</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-user"></i></span>
          <input type="text" class="input-xlarge" id="sa" name="sa" placeholder="Your Question Answer">
        </div>
      </div>
    <div class="control-group">
          <label class="control-label">User type</label>
      <div class="controls">
          <select name='user_type'>
            <option value=1>Buyer</option>
            <option value=2>Seller</option>
            <option value=3>Advetiser</option>
          </select>
        </div>
      </div>
    <div class="control-group">
          <label class="control-label">Gender</label>
      <div class="controls">

          <input type="radio" name="gender" value="M" >Male</input>
          <input type="radio" name="gender" value="F" >Female</input>
      </div>
    </div>
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
          <label class="control-label">Confirm Password</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-lock"></i></span>
          <input type="Password" id="conpasswd" class="input-xlarge" name="conpasswd" placeholder="Re-enter Password">
        </div>
      </div>
    </div>

    <div class="control-group">
    <label class="control-label"></label>
        <div class="controls">
         <button type="submit" class="btn btn-success" >Create My Account</button>

        </div>

      </div>
    </form>
      </div>
    </div>
    <?php
	}
}


?>