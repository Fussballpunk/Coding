<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

if(count($_GET)>0) {
	$conn = dbConnect();
	$sql = "
		DELETE FROM tbl_user
		WHERE(
			IDUser=" . $_GET["id"] . "
		)
	";
	//ta($sql);
	dbQuery($conn,$sql);
}

header("Location: 13_redaktionssystem02.php");
?>