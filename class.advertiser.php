<?php
/**
* 
*/
class advertiser
{
	
	function __construct()
	{
		# code...
	}

	public function show_my_advertisement($page=0)
	{
		echo '<table class="table">';
	    require_once "database_config.inc.php";
	    require_once 'class.login.php';

	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT id,name from advertisement where userid=:use';
	      $query = oci_parse($conn, $q);
	      $user=Login::getUser();
	      oci_bind_by_name($query, ':use',$user);
	      oci_execute($query);
	      $x=0+20*$page;
	      while($db_data=oci_fetch_array($query)){
	        $id=$db_data[0];
	        $name=$db_data[1];
	        echo '<form action="edit_advertisement.php" method="POST"><tr class="my_advertisement"><td class="pull-right">'.$name.'</td><td><input type="hidden" name="id" value='.$id.'><button type="submit" class="btn btn-success">Update this</button></td></tr></form>';
	        $x++;
	        if($x>20*($page+1))break;
	      }
	      oci_close($conn);
	      echo '</table>';
	    }
	    else {exit ('DB Connection failed contact Administrator');}
	}

	public function add_advertisement($name,$description,$tags,$image)
	{
	    require_once "database_config.inc.php";
	    require_once 'class.login.php';
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	    	$q = 'SELECT max(id) from advertisement';
			$query = oci_parse($conn, $q);
			oci_execute($query);
			$db_data=oci_fetch_array($query);
			if(!$db_data)$db_data[0]=0;
			$db_data[0]=$db_data[0]+1;
	    	$q = "INSERT INTO advertisement VALUES(:id,:name,:description,:tags,:userid,empty_blob()) RETURNING image INTO :image";
			$query = oci_parse($conn, $q);
			$user=Login::getUser();
			oci_bind_by_name($query, ':id', $db_data[0]);
			oci_bind_by_name($query, ':name', $name);
			oci_bind_by_name($query, ':description', $description);
			oci_bind_by_name($query, ':tags', $tags);
			oci_bind_by_name($query, ':userid', $user);
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
			oci_close($conn);
	    }
		else {exit ('DB Connection failed contact Administrator');}
	}

	public function update_advertisement($id,$name,$desc,$tag,$image)
	{
	    require_once "database_config.inc.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	    	$q = "Update advertisement set ";
	    	if($name!=="")$q.=" name=:aname,";
	    	if($desc!=="")$q.=" description=:adesc,";
	    	if($tag!=="")$q.=" tags=:atag,";
	    	$q=substr($q, 0,-1);
	    	$q.=" where id=:aid";
			$query = oci_parse($conn, $q);
			oci_bind_by_name($query, ':aid', $id);
			if($name!=="")oci_bind_by_name($query, ':aname', $name);
			if($desc!=="")oci_bind_by_name($query, ':adesc', $desc);
			if($tag!=="")oci_bind_by_name($query, ':atag', $tag);
			oci_execute($query) or die ("Unable to execute query");
			if($image!=="")
			{
				$q = "Update advertisement set image= empty_blob() where id=:aid RETURNING image INTO :image";
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

	public function show_edit_advertisement($id)
	{
	    require_once "database_config.inc.php";
	    $conn = oci_connect(db_user, db_pass,db_service);
	    if($conn) {
	      $q = 'SELECT name,description,tags,image from advertisement where id=:id';
	      $query = oci_parse($conn, $q);
	      oci_bind_by_name($query, ':id',$id);
	      oci_execute($query);
	      if($db_data=oci_fetch_array($query)){
	      	$name=$db_data[0];
	      	$desc=$db_data[1];
	      	$tags=$db_data[2];
	      	$image=$db_data[3]->load();
	      	$this->show_add_advertisement($name,$desc,$tags,$image,$id);}
	      oci_close($conn);
	    }
	    else {exit ('DB Connection failed contact Administrator');}
		
	}

	public function show_add_advertisement($name=0,$description=0,$tags=0,$image=0,$id=0)
	{
		?>
		<!-- add fileupload css and js to work it properly -->
		<div class="row-fluid">
		    <div class="span9 offset2">
		      <form id="show_add_advertisement" class="form-horizontal" method="post" enctype="multipart/form-data">
			    <legend><?php if($id==0)echo "Add Advertisement";else echo "Edit Advertisement"; ?></legend>
			    <div class="control-group">
			          <label class="control-label">Name</label>
			      <div class="controls">
			          <div class="input">
			          <?php if($id!==0)echo '<input type="text" class="input-xlarge" id="name" name="name" value="'.$name.'">';else echo '<input type="text" class="input-xlarge" id="name" name="name" placeholder="Advertisement name">'; ?>
			        </div>
			      </div>
			    </div>
			    <div class="control-group ">
			          <label class="control-label">Description</label>
			      <div class="controls">
			          <div class="input">
			          <?php if($id==0)echo '<textarea class="input-xlarge" rows="3" id="desc" name="desc" placeholder="Description"></textarea>';else echo '<textarea class="input-xlarge" rows="3" id="desc" name="desc">'.$description.'</textarea>'; ?>
			        </div>
			      </div>
			    </div>
			    <div class="control-group ">
			          <label class="control-label">Tags</label>
			      <div class="controls">
			          <div class="input">
			          <?php if($id==0)echo '<input type="text" class="input-xlarge" id="tag" name="tag" placeholder="Tags">';else echo '<input type="text" class="input-xlarge" id="tag" name="tag" value="'.$tags.'">'; ?>
			        </div>
			      </div>
			    </div>
			    <?php
			    if($id!==0)
			    {
			    	?>
			    	<div class="control-group ">
			          <label class="control-label">Used Image</label>
			      		<div class="controls">
			    	<?php
			    	echo '<table class="table"><td></td>';
			    	echo '<td><img style="height :300px;width: 200px;"src="data:image/jpeg;base64,'.base64_encode($image).'" alt=""/></td>';
			    	echo '</table></div></div>';
			    }
			    ?>
			    <div class="control-group ">
			          <label class="control-label">File name</label>
			      <div class="controls">
			          <div class="fileupload fileupload-new" data-provides="fileupload">
						  <span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="file" id="file"/></span>
						  <span class="fileupload-preview"></span>
						  <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
						</div>
			      </div>
			    </div>
			    <?php if($id!==0){echo '<input type="hidden" name="id" value="'.$id.'">';echo '<input type="hidden" name="update" value=1>';}?>
			    <div class="control-group">
			    <label class="control-label"></label>
			        <div class="controls">
			         <button type="submit" class="btn btn-success" ><?php if($id!==0)echo 'Update Advertisement';else echo 'Add Advertisement';?></button>
			        </div>
			     </div>
		    </form>
	      </div>
	    </div>

		<?php

	}
}


?>