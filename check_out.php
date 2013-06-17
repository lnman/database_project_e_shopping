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
	<?php
	$head->show_footer("checkout.js");
}
else {
	header('Location: login.php');
	die();
}
?>