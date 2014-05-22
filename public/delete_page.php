<?php require_once('../inc/session.php'); ?>
<?php require_once('../inc/db_connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>

<?php
	$current_page = find_page_by_id($_GET["page"]);

	if (!$current_page) {
		redirect_to("manage_content.php");
	}

	$id = $current_page["id"];
	$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($connection, $query);

	if ($result && mysqli_affected_rows($connection) == 1) {
		$_SESSION["message"] = "Page successfully removed.";
		redirect_to('manage_content.php');
	} else {
		$_SESSION["errors"] = "Page deletion failed.";
		redirect_to("manage_content.php?page={$id}");
	}
?>