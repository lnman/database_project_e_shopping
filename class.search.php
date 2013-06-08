<?php

/**
* 
*/
class Search
{
	private $keyword,$time,$price_range,$manufacturer,$shipping_region,$product_type,$searched,$search_result;
	function __construct($keyword,$product_type,$time,$price_range,$manufacturer,$shipping_region)
	{
		# code...
		if($keyword!=""){$this->keyword=$keyword;}
		if($product_type!=""){$this->product_type=$product_type;}
		if($time!=""){$this->time=$time;}
		if($price_range!=""){$this->price_range=$price_range;}
		if($manufacturer!=""){$this->manufacturer=$manufacturer;}
		if($shipping_region!=""){$this->shipping_region=$shipping_region;}
	}

	public function show_search_bar()
	{
		?>
		<div class="container-fluid">
		  <div class="row-fluid">
		    <div class="span2">
		      <!--Sidebar content-->
		      	<div class="well sidebar-nav">
		            <ul class="nav nav-list">
		            	<li class="nav-header">Top Categories</li>
		              	<?php
		              	$sidemenu = array('People','Model','Electronics');
		              	foreach ($sidemenu as $value) 
						{
							if(strcmp($_SERVER['PHP_SELF'],'/search.php?type='.$value)==0)
							{
								echo '<li class="active">';
							}else{echo '<li class="">';}
							echo '<a href="./search.php?type='.$value.'">'.$value.'</a></li>';
						}
		              	?>
		            </ul>
          		</div>
		    </div>
		    <div class="span10">
		      	<form class="search pull-left" method="POST" action="./search.php">
					<div class="span9">
		                <div class='input-prepend'>
		                    <select>
		                    	<?php
		                    	$category = array('All Category','People','Model','Electronics');
		                    	foreach ($category as $value) {
		                    		echo '<option>'.$value.'</option>';
		                    	}
		                    	?>
		                    </select>
		                    <input type="text" class="input-xlarge" id="search" name="search" placeholder="Search">
		                    <button type="submit" class="btn">Search</button>
		                </div>
		            </div>
		            <table class="table">
		            	<tr>
			            	<td class="control-group">
						      <label class="control-label">User type</label>
						      <div class="controls">
						          <select name='time'>
						            <?php
			                    	$time = array('Forever','1 day Old','1 week Old','1 month Old','6 month Old');
			                    	foreach ($time as $value) {
			                    		echo '<option value="'.$value.'">'.$value.'</option>';
			                    	}
			                    	?>
						          </select>
						        </div>
						    </td>

						    <td class="control-group">
						          <label class="control-label">Manufacturer</label>
						      <div class="controls">
						          <div class="input-prepend">
						        <span class="add-on"><i class="icon-user"></i></span>
						          <input type="text" class="input" id="manufacturer" name="manufacturer" placeholder="manufacturer">
						        </div>
						      </td>
						      <td class="control-group">
						          <label class="control-label">Price From</label>
						      <div class="controls">
						          <div class="input">
						          <input type="number" class="input-small" id="price_from" name="price_from">
						        </div>
						      </td>
						      <td class="control-group">
						          <label class="control-label">Price To</label>
						      <div class="controls">
						          <div class="input">
						          <input type="number" class="input-small" id="price to" name="price_to">
						        </div>
						      </td>
						    <td class="column-fluid control-group">
						      <label class="control-label">Shipping Area</label>
						      <div class="controls">
						          <select name='shipping_region'>
						            <?php
			                    	$time = array('global','local');
			                    	foreach ($time as $value) {
			                    		echo '<option value="'.$value.'">'.$value.'</option>';
			                    	}
			                    	?>
						          </select>
						        </div>
					        </td>
					    </tr>
		            	
		            </table>
	        	</form>
	        	<?php
	        	if(isset($this->searched)&&$this->searched==1)show_search_result();
	        	?>
		    </div>
		  </div>
		</div>
		<?php
	}

	public function show_search_result()
	{

	}

	public function search()
	{

	}
}


?>