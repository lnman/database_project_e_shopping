<?php
require_once 'class.login.php';
require_once 'class.header.php';
$head=new Header();
$head->show_header("Check Out");
if(Login::isLoggedIn())
{
	?>
	<div class="row-fluid">
		<legend>Check out</legend>
		<div class="span10 offset2">
			<table class="table ">
				<thead class="test"><tr><th>Product name</th><th>Price</th><th>No of Product</th><th >Price * No of Product</th><th >Action</th></tr></thead>
			</table>
		</div>
	</div>
	<div class="span12">
		<div class="span4 offset2"></div>
		<div class="span6"></div>
	</div>
 
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Shipping info</h3>
  </div>
  <div class="modal-body">
  	<div class="row-fluid"> 
  		<div class="span12">
    <div class="control-group">
	    <label class="control-label span2" for="City">Address</label>
	    <div class="controls">
	        <input class="input-large span10" id="city" name="City" type="text" placeholder="Kaysville">
	    </div>
	</div>
	<div class="control-group">
	    <label class="control-label span2" for="State">City</label>
	    <div class="controls">
	        <input class="input-large span4" id="state" name="State" type="text" placeholder="UT">
	    </div>
	</div>
	<div class="control-group">
	    <label class="control-label span2" for="PostalCode">Zip</label>
	    <div class="controls">
	        <input class="input-large span4" id="postalCode" name="PostalCode" type="number" placeholder="12345">
	    </div>
	</div>
	</div>
	</div>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id= "check_and_out">Finish</button>
  </div>
</div>
	<?php
	$head->show_footer("checkout.js");
}
else {
	header('Location: login.php');
	die();
}
?>