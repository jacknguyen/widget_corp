<?php
	require_once('../inc/session.php');
	$page_title = "New Subject";
	require_once('../inc/db_connection.php');
	require_once('../inc/functions.php');
?>

<?php $is_public = false; ?>
<?php include('../inc/layouts/header.php'); ?>
<?php find_selected(); ?>

<div class="container-fluid" id="main">
	<div id="navigation" class="col-xs-12 col-md-2">
		<?php echo navigation($current_subject, $current_page); ?>
	</div>

	<div class="col-xs-12 col-md-10" id="page">
		<?php
			$errors = $_SESSION["errors"];
			echo form_errors($errors);
		?>
		<h2>Create Subject</h2>

		<form action="create_subject.php" method="post">
			<p>Menu name:
				<input type="text" name="menu_name" value="" >
			</p>
			<p>Position:
				<select name="position">
					<?php
						$subject_count = subject_count();
						for($count=1; $count <= ($subject_count + 1); $count++) {
							echo "<option value=\"$count\" selected=\"\">{$count}</option>";
						}
					?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0"> No &nbsp;
				<input type="radio" name="visible" value="1"> Yes &nbsp;
			</p>
			<input type="submit" name="submit" value="Create Subject">
		</form>
		<br>
		<a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include('../inc/layouts/footer.php'); ?>