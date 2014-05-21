<?php
	require_once('../inc/session.php');
	require_once('../inc/db_connection.php');
	require_once('../inc/functions.php');
	require_once('../inc/validation_functions.php');
?>

<?php
	if (isset($_POST["submit"])) {
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];

		// validations
		$required_fields = ["menu_name", "position", "visible"];
		validate_presences($required_fields);

		$fields_with_max_length = ["menu_name" => 30];
		validate_max_lengths($fields_with_max_length);

		if(!empty($errors)) {
			$_SESSION["errors"] = $errors;
			redirect_to("new_subject.php");
		}

		// query sent to mysql
		$query = "INSERT INTO subjects ( menu_name, position, visible) VALUES ( '{$menu_name}', {$position}, {$visible})";
		$result = mysqli_query($connection, $query);

		if ($result) {
			$_SESSION["message"] = "Subject successfully created.";
			redirect_to("manage_content.php");
		} else {
			$_SESSION["message"] = "Subject creation failed";
			redirect_to("admin.php");
		}
	} else {
		redirect_to("new_subject.php");
	}
?>

<?php if(isset($connection)) { mysqli_close($connection); } ?>