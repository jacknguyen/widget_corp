<?php
	require_once('../inc/session.php');
	$page_title = "New Page";
	require_once('../inc/db_connection.php');
	require_once('../inc/functions.php');
	require_once('../inc/validation_functions.php');
?>

<?php include('../inc/layouts/header.php'); ?>
<?php find_selected(); ?>

<?php
	if (isset($_POST["submit"])) {
		$subject_id = (int) $_SESSION["subject_id"];
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position = (int) $_POST["position"];
		$visible = (bool) $_POST["visible"];
		$content = mysql_prep($_POST["content"]);

		// validations
		$required_fields = ["subject_id", "menu_name", "position", "visible", "content"];
		validate_presences($required_fields);

		$fields_with_max_length = ["menu_name" => 30, "content" => 140];
		validate_max_lengths($fields_with_max_length);

		if(!empty($errors)) {
			$_SESSION["errors"] = $errors;
			redirect_to($_SERVER["PHP_SELF"]);
		}

		// query sent to mysql
		$query = "INSERT INTO pages SET subject_id={$subject_id}, menu_name='{$menu_name}', position={$position}, visible={$visible}, content='{$content}'";
		$result = mysqli_query($connection, $query);

		if ($result) {
			$_SESSION["message"] = "Subject successfully created.";
			$_SESSION["subject_id"] = null;
			redirect_to("manage_content.php");
		} else {
			$errors[] = "Subject creation failed";
		}
	} else {

	}
?>

<div class="container-fluid" id="main">
	<div id="navigation" class="col-xs-12 col-md-2">
		<?php echo navigation($current_subject, $current_page); ?>
	</div>

	<div class="col-xs-12 col-md-10" id="page">
		<?php
			$errors = $_SESSION["errors"];
			echo form_errors($errors);
		?>
		<h2>Create Page</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="number" name="subject_id" value="<?php echo htmlentities($_SESSION["subject_id"]); ?>" hidden>
			<p><strong>Menu name:</strong>
				<input type="text" name="menu_name" autofocus="true">
			</p>
			<p><strong>Position:</strong>
				<select name="position">
					<?php
						$page_count = page_count($_SESSION["subject_id"]);
						for($count=1; $count <= ($page_count + 1); $count++) {
							echo "<option value=\"$count\" selected=\"\">{$count}</option>";
						}
					?>
				</select>
			</p>
			<p><strong>Visible:</strong>
				<input type="radio" name="visible" value="0"> No &nbsp;
				<input type="radio" name="visible" value="1"> Yes &nbsp;
			</p>
			<p><strong>Content:</strong></p>
			<p>
				<textarea name="content" rows="10" cols="50"></textarea>
			</p>


			<input type="submit" name="submit" value="Create Page">
		</form>
		<br>
		<a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include('../inc/layouts/footer.php'); ?>