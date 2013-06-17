<?php

/**
* 
*/
class Seller
{
	
	function __construct()
	{
		# code...
	}

	public function show_my_product($page=0)
	{
		echo '<table class="table">';
	    require_once "database_config.inc.php";
	    require_once 'class.login.php';

	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT id,name from product where userid=:use';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':use',$user);
	      oci_execute($query);
	      $x=0+20*$page;
	      while($db_data=oci_fetch_array($query)){
	        $id=$db_data[0];
	        $name=$db_data[1];
	        echo '<form action="edit_product.php" method="POST"><tr class="my_advertisement"><td class="pull-right">'.$name.'</td><td><input type="hidden" name="id" value='.$id.'><button type="submit" class="btn btn-success">Edit this</button></td></tr></form>';
	        $x++;
	        if($x>20*($page+1))break;
	      }
	      oci_close($conn);
	      echo '</table>';
	    }
	    else {exit ('DB Connection failed contact Administrator');}
	}

	public function add_product($name,$Manufacturer,$CATEGORY,$Price,$No_of_product,$Technical_detail,$Pic_1,$Pic_2,$Pic_3 )
	{
		require_once "database_config.inc.php";
	    require_once 'class.login.php';
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	    	$q = 'SELECT max(id) from product';
			$query = oci_parse($conn, $q);
			oci_execute($query);
			$db_data=oci_fetch_array($query);
			if(!$db_data)$db_data[0]=0;
			$db_data[0]=$db_data[0]+1;
	    	$q = "INSERT INTO product VALUES(:aid,:aname,:auserid,:amanufacturer,:acategory,:aprice,:ano_of_product,:atechnical_detail,sysdate,empty_blob(),empty_blob(),empty_blob()) RETURNING Pic_1 INTO :image";
			$query = oci_parse($conn, $q);
			$user=Login::getUser();
			oci_bind_by_name($query, ':aid', $db_data[0]);
			oci_bind_by_name($query, ':aname', $name);
			oci_bind_by_name($query, ':amanufacturer', $Manufacturer);
			oci_bind_by_name($query, ':acategory', $CATEGORY);
			oci_bind_by_name($query, ':aprice', $Price);
			oci_bind_by_name($query, ':ano_of_product', $No_of_product);
			oci_bind_by_name($query, ':atechnical_detail', $Technical_detail);
			oci_bind_by_name($query, ':auserid', $user);
			$blob = oci_new_descriptor($conn, OCI_D_LOB);
			oci_bind_by_name($query, ":image", $blob, -1, OCI_B_BLOB);
			oci_execute($query, OCI_DEFAULT) or die ("Unable to execute query");
			if(!$blob->save($Pic_1)) {
			    oci_rollback($conn);
			}
			else {
			    oci_commit($conn);
			}
			oci_free_statement($query);
			$blob->free();
			if($Pic_2!=="")
			{
				$q = "Update product set Pic_2= empty_blob() where id=:aid RETURNING Pic_2 INTO :image";
				$query = oci_parse($conn, $q);
				oci_bind_by_name($query, ':aid', $db_data[0]);
				$blob = oci_new_descriptor($conn, OCI_D_LOB);
				oci_bind_by_name($query, ":image", $blob, -1, OCI_B_BLOB);
				oci_execute($query, OCI_DEFAULT) or die ("Unable to execute query");
				if(!$blob->save($Pic_2)) {
				    oci_rollback($conn);
				}
				else {
				    oci_commit($conn);
				}
				oci_free_statement($query);
				$blob->free();
			}
			if($Pic_3!=="")
			{
				$q = "Update product set Pic_3= empty_blob() where id=:aid RETURNING Pic_3 INTO :image";
				$query = oci_parse($conn, $q);
				oci_bind_by_name($query, ':aid', $db_data[0]);
				$blob = oci_new_descriptor($conn, OCI_D_LOB);
				oci_bind_by_name($query, ":image", $blob, -1, OCI_B_BLOB);
				oci_execute($query, OCI_DEFAULT) or die ("Unable to execute query");
				if(!$blob->save($Pic_3)) {
				    oci_rollback($conn);
				}
				else {
				    oci_commit($conn);
				}
				oci_free_statement($query);
				$blob->free();
			}
			oci_close($conn);
	    }
		else {exit ('DB Connection failed contact Administrator');}
	}

	public function update_product($id,$name,$Manufacturer,$CATEGORY,$Price,$No_of_product,$Technical_detail,$Pic_1,$Pic_2,$Pic_3)
	{
		require_once "database_config.inc.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	    	$q = "Update product set ";
	    	if($name!=="")$q.=" Name=:aname,";
	    	if($Manufacturer!=="")$q.=" Manufacturer=:amanufacturer,";
	    	if($CATEGORY!=="")$q.=" CATEGORY=:acategory,";
	    	if($Price!=="")$q.=" Price=:aprice,";
	    	if($No_of_product!=="")$q.=" No_of_product=:ano_of_product,";
	    	if($Technical_detail!=="")$q.=" Technical_detail=:atechnical_detail,";
	    	$q=substr($q, 0,-1);
	    	$q.=" where id=:aid";
			$query = oci_parse($conn, $q);
			oci_bind_by_name($query, ':aid', $id);
			if($name!=="")oci_bind_by_name($query, ':aname', $name);
			if($Manufacturer!=="")oci_bind_by_name($query, ':amanufacturer', $Manufacturer);
			if($CATEGORY!=="")oci_bind_by_name($query, ':acategory', $CATEGORY);
			if($Price!=="")oci_bind_by_name($query, ':aprice', $Price);
			if($No_of_product!=="")oci_bind_by_name($query, ':ano_of_product', $No_of_product);
			if($Technical_detail!=="")oci_bind_by_name($query, ':atechnical_detail', $Technical_detail);
			oci_execute($query) or die ("Unable to execute query");
			if($Pic_1!=="")
			{
				$q = "Update product set Pic_1= empty_blob() where id=:aid RETURNING Pic_1 INTO :image";
				$query = oci_parse($conn, $q);
				oci_bind_by_name($query, ':aid', $id);
				$blob = oci_new_descriptor($conn, OCI_D_LOB);
				oci_bind_by_name($query, ":image", $blob, -1, OCI_B_BLOB);
				oci_execute($query, OCI_DEFAULT) or die ("Unable to execute query");
				if(!$blob->save($image)) {
				    oci_rollback($conn);
				}
				else {
				    oci_commit($conn);
				}
				oci_free_statement($query);
				$blob->free();
			}
			if($Pic_2!=="")
			{
				$q = "Update product set Pic_2= empty_blob() where id=:aid RETURNING Pic_2 INTO :image";
				$query = oci_parse($conn, $q);
				oci_bind_by_name($query, ':aid', $id);
				$blob = oci_new_descriptor($conn, OCI_D_LOB);
				oci_bind_by_name($query, ":image", $blob, -1, OCI_B_BLOB);
				oci_execute($query, OCI_DEFAULT) or die ("Unable to execute query");
				if(!$blob->save($image)) {
				    oci_rollback($conn);
				}
				else {
				    oci_commit($conn);
				}
				oci_free_statement($query);
				$blob->free();
			}
			if($Pic_3!=="")
			{
				$q = "Update product set Pic_3= empty_blob() where id=:aid RETURNING Pic_3 INTO :image";
				$query = oci_parse($conn, $q);
				oci_bind_by_name($query, ':aid', $id);
				$blob = oci_new_descriptor($conn, OCI_D_LOB);
				oci_bind_by_name($query, ":image", $blob, -1, OCI_B_BLOB);
				oci_execute($query, OCI_DEFAULT) or die ("Unable to execute query");
				if(!$blob->save($image)) {
				    oci_rollback($conn);
				}
				else {
				    oci_commit($conn);
				}
				oci_free_statement($query);
				$blob->free();
			}
			oci_close($conn);
	    }
		else {exit ('DB Connection failed contact Administrator');}
	}


	public function show_edit_product($id)
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
	      	$this->show_add_product($name,$Manufacturer,$CATEGORY,$Price,$No_of_product,$Technical_detail,$Pic_1,$Pic_2,$Pic_3,$id);}
	      oci_close($conn);
	    }
	    else {exit ('DB Connection failed contact Administrator');}
		
	}

	public function show_add_product($name=0,$Manufacturer=0,$CATEGORY=0,$Price=0,$No_of_product=0,$Technical_detail=0,$Pic_1=0,$Pic_2=0,$Pic_3=0,$id=0)
	{
		?>
		<!-- add fileupload css and js to work it properly -->
		<div class="row-fluid">
		    <div class="span9 offset2">
		      <form id="show_add_product" class="form-horizontal" method="post" enctype="multipart/form-data">
			    <legend><?php if($id==0)echo "Add Product";else echo "Edit Product"; ?></legend>
			    <div class="control-group">
			          <label class="control-label">Name</label>
			      <div class="controls">
			          <div class="input">
			          <?php if($id!==0)echo '<input type="text" class="input-xlarge" id="name" name="name" value="'.$name.'">';else echo '<input type="text" class="input-xlarge" id="name" name="name" placeholder="Product name">'; ?>
			        </div>
			      </div>
			    </div>
			    <div class="control-group ">
			          <label class="control-label">Manufacturer</label>
			      <div class="controls">
			          <div class="input">
			          <?php if($id==0)echo '<input type="text" class="input-xlarge" id="manu" name="manu" placeholder="Manufacturer">';else echo '<input type="text" class="input-xlarge" id="manu" name="manu" value="'.$Manufacturer.'">'; ?>
			        </div>
			      </div>
			    </div>
			    <div class="control-group">
			          <label class="control-label">Category</label>
			      <div class="controls">
			          <select name='cat'>
			          	<?php
			          	$cat = array('Electronics' =>1 ,'Baby'=>2,'Car'=>3 );
			          	foreach ($cat as $key => $value) {
			          		if($id!==0&&$CATEGORY==$value)
			          		{
			          			echo '<option value="'.$value.'" active>'.$key.'</option>';
			          		}else echo '<option value='.$value.'>'.$key.'</option>';
			          	}
			          	?>
			          </select>
			        </div>
			      </div>
			    <div class="control-group ">
			          <label class="control-label">Price</label>
			      <div class="controls">
			          <div class="input">
			          <?php if($id==0)echo '<input type="number" class="input-xlarge" id="price" name="price" placeholder="0">';else echo '<input type="number" class="input-xlarge" id="price" name="price" value='.$Price.'>'; ?>
			        </div>
			      </div>
			    </div>
			    <div class="control-group ">
			          <label class="control-label">No of Product</label>
			      <div class="controls">
			          <div class="input">
			          <?php if($id==0)echo '<input type="number" class="input-xlarge" id="n_o_p" name="n_o_p" placeholder="0">';else echo '<input type="number" class="input-xlarge" id="n_o_p" name="n_o_p" value='.$No_of_product.'>'; ?>
			        </div>
			      </div>
			    </div>
			    <div class="control-group ">
			          <label class="control-label">Technical Detail</label>
			      <div class="controls">
			          <div class="input">
			          <?php if($id==0)echo '<textarea class="input-xlarge" rows="3" id="tech" name="tech" placeholder="Technical_detail"></textarea>';else echo '<textarea class="input-xlarge" rows="3" id="tech" name="tech">'.$Technical_detail.'</textarea>'; ?>
			        </div>
			      </div>
			    </div>
			    <?php
			    if($id!==0)
			    {
			    	?>
			    	<div class="control-group ">
			          <label class="control-label">Used Image1</label>
			      		<div class="controls">
			    	<?php
			    	echo '<table class="table"><td></td>';
			    	echo '<td><img style="height :300px;width: 200px;"src="data:image/jpeg;base64,'.base64_encode($Pic_1).'" alt=""/></td>';
			    	echo '</table></div></div>';
			    }
			    ?>
			    <div class="control-group ">
			          <label class="control-label">Image1</label>
			      <div class="controls">
			          <div class="fileupload fileupload-new" data-provides="fileupload">
						  <span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="file_1" id="file_1"/></span>
						  <span class="fileupload-preview"></span>
						  <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
						</div>
			      </div>
			    </div>
			    <?php
			    if($id!==0)
			    {
			    	?>
			    	<div class="control-group ">
			          <label class="control-label">Used Image2</label>
			      		<div class="controls">
			    	<?php
			    	echo '<table class="table"><td></td>';
			    	echo '<td><img style="height :300px;width: 200px;"src="data:image/jpeg;base64,'.base64_encode($Pic_2).'" alt=""/></td>';
			    	echo '</table></div></div>';
			    }
			    ?>
			    <div class="control-group ">
			          <label class="control-label">Image2</label>
			      <div class="controls">
			          <div class="fileupload fileupload-new" data-provides="fileupload">
						  <span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="file_2" id="file_2"/></span>
						  <span class="fileupload-preview"></span>
						  <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
						</div>
			      </div>
			    </div>
			    <?php
			    if($id!==0)
			    {
			    	?>
			    	<div class="control-group ">
			          <label class="control-label">Used Image3</label>
			      		<div class="controls">
			    	<?php
			    	echo '<table class="table"><td></td>';
			    	echo '<td><img style="height :300px;width: 200px;"src="data:image/jpeg;base64,'.base64_encode($Pic_3).'" alt=""/></td>';
			    	echo '</table></div></div>';
			    }
			    ?>
			    <div class="control-group ">
			          <label class="control-label">Image3</label>
			      <div class="controls">
			          <div class="fileupload fileupload-new" data-provides="fileupload">
						  <span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="file_3" id="file_3"/></span>
						  <span class="fileupload-preview"></span>
						  <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
						</div>
			      </div>
			    </div>
			    <?php if($id!==0){echo '<input type="hidden" name="id" value="'.$id.'">';echo '<input type="hidden" name="update" value=1>';}?>
			    <div class="control-group">
			    <label class="control-label"></label>
			        <div class="controls">
			         <button type="submit" class="btn btn-success" ><?php if($id!==0)echo 'Update Product';else echo 'Add Product';?></button>
			        </div>
			     </div>
		    </form>
	      </div>
	    </div>

		<?php

	}
}

?>