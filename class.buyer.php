<?php

/**
* 
*/
class Buyer
{
	
	function __construct()
	{
		# code...
	}


	public function get_product_data($id)
	{
		require_once "database_config.inc.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT name,Manufacturer,CATEGORY,Price,No_of_product,Technical_detail,Pic_1,Pic_2,Pic_3 from product where id=:id';
	      $query = oci_parse($conn, $q);
	      oci_bind_by_name($query, ':id',$id);
	      oci_execute($query);
	      if($db_data=oci_fetch_array($query)){
	      	$name=$db_data[0];
	      	$Manufacturer=$db_data[1];
	      	$CATEGORY=$db_data[2];
	      	$Price=$db_data[3];
	      	$No_of_product=$db_data[4];
	      	$Technical_detail=$db_data[5];
	      	$Pic_1=$db_data[6]->load();
	      	$Pic_2=$db_data[7]->load();
	      	$Pic_3=$db_data[8]->load();
	      	$this->show_product_view($name,$Manufacturer,$CATEGORY,$Price,$No_of_product,$Technical_detail,$Pic_1,$Pic_2,$Pic_3,$id);}
	      oci_close($conn);
	    }
	    else {exit ('DB Connection failed contact Administrator');}
		
	}

	public function show_product_view($name,$Manufacturer,$CATEGORY,$Price,$No_of_product,$Technical_detail,$Pic_1,$Pic_2,$Pic_3,$id)
	{
		# code...
		?>

		<div class="row-fluid">
			<legend>Product View</legend>
			<div class="span12 row-fluid" >
				<div class="span4 offset2">
					<div class="carousel slide carousel-fade" id="myCarousel">
			            <div class="carousel-inner">
			              <?php
			              $num=0;
			              $aa = array($Pic_1 => 'First Thumbnail',$Pic_2 => 'Second Thumbnail',$Pic_3 => 'Third Thumbnail' );
			              foreach ($aa as $key => $value) {
			                # code...
			                echo '<div class="item ';
			                if($num==1)echo 'active';
			                echo '">';
			                echo '<img alt="" src="data:image/jpeg;base64,'.base64_encode($key).'" />">';
			                echo '<div class="carousel-caption">';
			                echo '<h4>'.$value.'</h4>';
			                echo '</div>';
			                echo '</div>';
			                $num++;
			              }
			              ?>
			            </div>
			            <a data-slide="prev" href="#myCarousel" class="left carousel-control">‹</a>
			            <a data-slide="next" href="#myCarousel" class="right carousel-control">›</a>
			          </div>
				</div >
				<div class="span6">
					<label class="item_id" value=<?php echo '"'.$id.'"'; ?> hidden><label>

				    <h2 class="name" value=<?php echo '"'.$name.'"'; ?> > <?php echo $name; ?> </h2>
				    <label for="item_Quantity">Number of item</label>
				    <input type="text" value="1" class="item_Quantity" id="item_Quantity">
				    <label for="price">Price</label>
				    <span class="price" id="price" value=<?php echo '"'.$Price.'"'; ?>><?php echo $Price; ?></span></br>
					<button class="item_add btn-success"> Add to Cart </button>
					<button class="bookmark btn-success"> Bookmark </button>
					<button class="book btn-success"> Book </button>
				</div>
			</div>
			<div class="span12 row-fluid">
				<div class="span4 offset2">Manufacturer</div>
				<div class="span6"><?php echo $Manufacturer; ?></div>
			</div>
			<div class="span12">
				<div class="span4 offset2">No of product</div>
				<div class="span6"><?php echo $No_of_product; ?></div>
			</div>
			<div class="span12">
				<div class="span4 offset2">Technical Detail</div>
				<div class="span6"><?php echo $Technical_detail; ?></div>
			</div>
			<div class="span12">
				<div class="span4 offset2"></div>
				<div class="span6"></div>
			</div>
		</div>
		<?php
	}
}

?>