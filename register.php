<?php
$res="empty";
if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['fname'])&&isset($_POST['lname'])&&isset($_POST['dob'])&&isset($_POST['email'])&&isset($_POST['phone'])&&isset($_POST['gender'])&&isset($_POST['user_type'])&&isset($_POST['sq'])&&isset($_POST['sa'])&&isset($_POST['uname'])&&isset($_POST['passwd'])&&isset($_POST['conpasswd']))
{
  require_once 'class.register.php';
  $reg=new Register($_POST['uname'],$_POST['passwd'],$_POST['conpasswd'],$_POST['fname']." ".$_POST['lname'],$_POST['dob'],$_POST['gender'],$_POST['user_type'],$_POST['phone'],$_POST['email'],$_POST['sq'],$_POST['sa']);
  $res=$reg->check_and_insert();
  if($res=="Success"){die();}
}
require_once 'header.php';
$head=new header();
$head->show_header();
if($res!=="empty"){
  echo '<div class="row-fluid alert alert-error"><div class="span9 pagination-centered"><p>'.$res.'</p></div></div>';
}
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
$head->show_footer("register_validate.js");
?>