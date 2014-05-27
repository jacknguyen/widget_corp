<?php
	require_once('../inc/session.php');
	$page_title = "Edit Page";
	require_once('../inc/db_connection.php');
	require_once('../inc/functions.php');
	require_once('../inc/validation_functions.php');
?>

<?php find_selected(); ?>

<?php
	if (isset($_POST["submit"])) {
		// validations
		$required_fields = ["menu_name", "position", "visible", "content"];
		validate_presences($required_fields);

		$fields_with_max_length = ["menu_name" => 30, "content" => 140];
		validate_max_lengths($fields_with_max_length);

		if(empty($errors)) {
			// If validation passed Perform Update
			$id = $current_page["id"];
			$menu_name = mysql_prep($_POST["menu_name"]);
			$position = (int) $_POST["position"];
			$visible = (int) $_POST["visible"];
			$content = mysql_prep($_POST["content"]);

			// query sent to mysql
			$query = "UPDATE pages SET menu_name='{$menu_name}', position={$position}, visible={$visible}, content='{$content}' WHERE id={$id} LIMIT 1";
			$result = mysqli_query($connection, $query);

			if ($result && mysqli_affected_rows($connection) >= 0) {
				$_SESSION["message"] = "Page successfully updated.";
				redirect_to("manage_content.php?page=" . urlencode($id));
			} else {
				$errors[] = "Subject update failed";
			}
		}
	} else {

	}
?>

<?php
	if (!$current_page){
		// subject ID was missing or invalid or
		// subject couldn't be found in database
		redirect_to("manage_content.php");
	}
?>

<?php $is_public = false; ?>
<?php include('../inc/layouts/header.php'); ?>

<div class="container-fluid" id="main">
	<div id="navigation" class="col-xs-12 col-md-2">
		<?php echo navigation($current_subject, $current_page, false); ?>
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
		<h2>Edit Subject: <?php echo htmlentities($current_page["menu_name"]); ?></h2>
		<form action="<?php echo $_SERVER['PHP_SELF'] . "?page=" . urlencode($current_page["id"]); ?>" method="post">
			<p><strong>Menu name:</strong>
				<input type="text" name="menu_name" value="<?php echo htmlentities($current_page["menu_name"]); ?>" autofocus>
			</p>
			<p><strong>Position:</strong>
				<select name="position">
					<?php
						$page_count = page_count($current_page["subject_id"]);
						for($count=1; $count <= ($page_count); $count++) {
							$output = "<option value=\"$count\" ";
							if ($current_page["position"] == $count) {
								$output .= "selected ";
							}
							$output .= ">{$count}</option>";
							echo $output;
						}
					?>
				</select>
			</p>
			<p><strong>Visible:</strong>
				<input type="radio" name="visible" value="0"
					<?php if($current_page["visible"] == 0) { echo "checked"; }?>
					> No &nbsp;
				<input type="radio" name="visible" value="1"
					<?php if($current_page["visible"] == 1) { echo "checked"; }?>
					> Yes &nbsp;
			</p>
			<p><strong>Content:</strong></p>
			<p><textarea name="content" rows="10" cols="50"><?php echo htmlentities($current_page['content']); ?></textarea></p>

			<input type="submit" name="submit" value="Save">
		</form>
		<br>
		<a href="manage_content.php?page=<?php echo urlencode($current_page["id"]); ?>">Cancel</a>
	</div>
</div>

<?php include('../inc/layouts/footer.php'); ?>