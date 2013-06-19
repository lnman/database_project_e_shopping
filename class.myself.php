<?php
/**
* 
*/
class Myself
{
	
	function __construct()
	{
		# code...
	}
	public function get_myinfo()
	{
		require_once "database_config.inc.php";
		require_once 'class.login.php';
		$user=Login::getUser();
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT * from user_list where username=:username';
	      $query = oci_parse($conn, $q);
	      oci_bind_by_name($query, ':username',$user);
	      oci_execute($query);
	      if($db_data=oci_fetch_array($query)){
	      	$this->show_myinfo($db_data);}
	      oci_close($conn);
	    }
	    else {exit ('DB Connection failed contact Administrator');}
	}
	public function show_myinfo($v)
	{
		?>
		<div class="row-fluid">
      <div class="span9 offset2">
      <form id="acc_up" class="form-horizontal" method="post">
    <legend>Update My info</legend>
    <div class="control-group">
          <label class="control-label">First Name</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-user"></i></span>
          <input type="text" class="input-xlarge" id="name" name="name" value=<?php echo '"'.$v[2].'"';?>>
        </div>
      </div>
    </div>
    <div class="control-group">
          <label class="control-label">Email</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-envelope"></i></span>
          <input type="text" class="input-xlarge" id="email" name="email" value=<?php echo '"'.$v[9].'"';?>>
        </div>
      </div>
    </div>
    <div class="control-group">
          <label class="control-label">Phone No</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-envelope"></i></span>
          <input type="text" class="input-xlarge" id="phone" name="phone" value=<?php echo '"'.$v[8].'"';?>>
        </div>
      </div>
    </div>
    <div class="control-group">
          <label class="control-label">Secret Question</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-user"></i></span>
          <input type="text" class="input-xlarge" id="sq" name="sq" value=<?php echo '"'.$v[10].'"';?>>
        </div>
      </div>
      <div class="control-group">
          <label class="control-label">Question Answer</label>
      <div class="controls">
          <div class="input-prepend">
        <span class="add-on"><i class="icon-user"></i></span>
          <input type="text" class="input-xlarge" id="sa" name="sa" value=<?php echo '"'.$v[11].'"';?>>
        </div>
      </div>

      <div class="control-group">
    <label class="control-label"></label>
        <div class="controls">
         <button type="submit" class="btn btn-success" >Update Account</button>

        </div>

      </div>
    </form>
      </div>
    </div>
		<?php
	}

	public function update_myinfo($name,$mail,$phone,$sq,$sa)
	{
		# code...
		require_once "database_config.inc.php";
		require_once 'class.login.php';
		$user=Login::getUser();
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'update user_list set name=:name ';
	      if($mail!=='')$q.=' , email=:mail';
	      if($phone!=='')$q.=' , phone_no=:phone';
	      if($sq!=='')$q.=' , secret_q=:sq';
	      if($sa!=='')$q.=' , secret_a=:sa';
	      $q.=' where username=:username';
	      $query = oci_parse($conn, $q);
	      oci_bind_by_name($query, ':username',$user);
	      oci_bind_by_name($query, ':name',$name);
	      if($mail!=='')oci_bind_by_name($query, ':mail',$mail);
	      if($phone!=='')oci_bind_by_name($query, ':phone',$phone);
	      if($sq!=='')oci_bind_by_name($query, ':sq',$sq);
	      if($sa!=='')oci_bind_by_name($query, ':sa',$sa);
	      oci_execute($query);
	      oci_close($conn);
	    }
	    else {exit ('DB Connection failed contact Administrator');}

	}
}

?>