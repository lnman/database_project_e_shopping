<?php

/**
* 
*/
class Search
{
	private $keyword,$time,$price_range,$manufacturer,$shipping_region,$product_type,$searched,$search_result,$page;
	function __construct($keyword,$product_type,$time,$price_range,$manufacturer,$shipping_region)
	{
		# code...
		if($keyword!=""){$this->keyword='%'.$keyword.'%';}
		if($product_type!=""){$this->product_type=$product_type;}
		if($time!=""){$this->time=$time;}
		if($price_range!=""){$this->price_range=$price_range;}
		if($manufacturer!=""){$this->manufacturer=$manufacturer;}
		if($shipping_region!=""){$this->shipping_region=$shipping_region;}
	}


	public function set_search_and_page($value=0)
	{
		$this->searched=true;
		$this->page=$value;
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
		                    <select name="category">
		                    	<?php
		                    	$category = array('All Category','People','Model','Electronics');
		                    	foreach ($category as $value) {
		                    		echo '<option value="'.$value.'">'.$value.'</option>';
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
						          <input type="number" class="input-small" id="price_to" name="price_to">
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
	        	if(isset($this->searched)&&$this->searched){
	        		if(isset($this->page))$this->search($this->page);
	        	}
	        	?>
		    </div>
		  </div>
		</div>
		<?php
	}


	public function search($page=0)
	{
		echo '<table class="table">';
	    require("database_config.inc.php");
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT dname,fname,iblob from pdm where fname like :keyword';
	      /*if(isset($this->time))$q.='and add_date<:time';
	      if(isset($this->price_range))$q.='and price>:from and price<:to';
	      if(isset($this->manufacturer))$q.='and manufacturer=:manufacturer';
	      if(isset($this->type))$q.='and type=:product_type';
	      if(isset($this->shipping_region))$q.='and region=:shipping_region';*/
	      $query = oci_parse($conn, $q);
	      oci_bind_by_name($query, ':keyword', $this->keyword);
	      /*if(isset($this->time))oci_bind_by_name($query, ':time', $this->time);
	      if(isset($this->price_range)){oci_bind_by_name($query, ':from', $this->price_range[0]);oci_bind_by_name($query, ':to', $this->price_range[1]);}
	      if(isset($this->manufacturer))oci_bind_by_name($query, ':manufacturer', $this->manufacturer);
	      if(isset($this->type))oci_bind_by_name($query, ':product_type', $this->product_type);
	      if(isset($this->shipping_region))oci_bind_by_name($query, ':shipping_region', $this->shipping_region);*/
	      oci_execute($query);
	      $x=0+20*$page;
	      $pp=0;
	      while($pp<$x&&$db_data=oci_fetch_array($query)){$pp++;}
	      $beau=0;
	      while($db_data=oci_fetch_array($query)){
	        if($beau!==0 and $beau%3==0){echo '</tr>';}
	        if($beau%3==0){echo '<tr>';}
	        $name=$db_data[0];
	        $price=$db_data[1];
	        $lob=$db_data[2]->load();
	        echo '<td><img style="height :500px;width: 300px;"src="data:image/jpeg;base64,'.base64_encode($lob).'" alt=""/>';
	        echo '<label>'.$name.'</label>'.'<label class="pull-left">'.$price.'</label></td>';
	        $pp++;
	        $beau++;
	        if($pp>$x+20)break;
	      }
	      if($beau%3!==0){echo '</tr>';}
	      oci_close($conn);
	      echo '</table>';
	  }
	}
}


?>