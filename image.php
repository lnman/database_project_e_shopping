<?php
	$image = file_get_contents($_FILES['image_field_name']['tmp_name']);
	$sql = "INSERT INTO table (id, image) VALUES(1, empty_blob()) RETURNING image INTO :image";
	$result = oci_parse($connection, $sql);
	$blob = oci_new_descriptor($connection, OCI_D_LOB);
	oci_bind_by_name($result, ":image", $blob, -1, OCI_B_BLOB);
	oci_execute($result, OCI_DEFAULT) or die ("Unable to execute query");

	if(!$blob->save($image)) {
	    oci_rollback($connection);
	}
	else {
	    oci_commit($connection);
	}

	oci_free_statement($result);
	$blob->free();

?>