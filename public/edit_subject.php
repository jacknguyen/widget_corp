<?php
	require_once('../inc/session.php');
	$page_title = "Edit Subject";
	require_once('../inc/db_connection.php');
	require_once('../inc/functions.php');
	require_once('../inc/validation_functions.php');
?>

<?php find_selected(); ?>

<?php
	if (isset($_POST["submit"])) {
		// validations
		$required_fields = ["menu_name", "position", "visible"];
		validate_presences($required_fields);

		$fields_with_max_length = ["menu_name" => 30];
		validate_max_lengths($fields_with_max_length);

		if(empty($errors)) {
			// If validation passed Perform Update
			$id = $current_subject["id"];
			$menu_name = mysql_prep($_POST["menu_name"]);
			$position = (int) $_POST["position"];
			$visible = (bool) $_POST["visible"];

			// query sent to mysql
			$query = "UPDATE subjects SET menu_name='{$menu_name}', position={$position}, visible={$visible} WHERE id={$id} LIMIT 1";
			$result = mysqli_query($connection, $query);

			if ($result && mysqli_affected_rows($connection) >= 0) {
				$_SESSION["message"] = "Subject successfully updated.";
				redirect_to("manage_content.php");
			} else {
				$message = "Subject update failed";
			}
		}
	} else {

	}
?>

<?php
	if (!$current_subject){
		// subject ID was missing or invalid or
		// subject couldn't be found in database
		redirect_to("manage_content.php");
	}
?>

<?php include('../inc/layouts/header.php'); ?>

<div class="container-fluid" id="main">
	<div id="navigation" class="col-xs-12 col-md-2">
		<?php echo navigation($current_subject, $current_page); ?>
	</div>

	<div class="col-xs-12 col-md-10" id="page">
		<h4>
		<?php
			if (!empty($message)) {
				echo htmlentities($message);
			}
			echo form_errors($errors);
		?>
		</h4>
		<h2>Edit Subject: <?php echo htmlentities($current_subject["menu_name"]); ?></h2>
		<form action="<?php echo $_SERVER['PHP_SELF'] . "?subject=" . urlencode($current_subject["id"]); ?>" method="post">
			<p>Menu name:
				<input type="text" name="menu_name" value="<?php echo htmlentities($current_subject["menu_name"]); ?>" placeholder="">
			</p>
			<p>Position:
				<select name="position">
					<?php
						$subject_count = subject_count();
						for($count=1; $count <= ($subject_count); $count++) {
							$output = "<option value=\"$count\" ";
							if ($current_subject["position"] == $count) {
								$output .= "selected ";
							}
							$output .= ">{$count}</option>";
							echo $output;
						}
					?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0"
					<?php if($current_subject["visible"] == 0) { echo "checked"; }?>
					> No &nbsp;
				<input type="radio" name="visible" value="1"
					<?php if($current_subject["visible"] == 1) { echo "checked"; }?>
					> Yes &nbsp;
			</p>
			<input type="submit" name="submit" value="Edit Subject">
		</form>
		<br>
		<a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include('../inc/layouts/footer.php'); ?>