<?php
	require_once('../inc/session.php');
	require_once('../inc/db_connection.php');
	$page_title = "Manage Content";
	require_once('../inc/functions.php');
?>

<?php $is_public = false; ?>
<?php include('../inc/layouts/header.php'); ?>
<?php find_selected(); ?>

<div class="container-fluid" id="main">
	<div id="navigation" class="col-xs-12 col-md-2">
		<?php echo navigation($current_subject, $current_page, false); ?>
		<br>
		<a href="new_subject.php" class="btn btn-primary btn-block">Add A New Subject</a>
	</div>

	<div class="col-xs-12 col-md-10" id="page">
		<?php echo message(); ?>
		<?php echo errors(); ?>
		<?php if ($current_subject) { ?>
			<h2>Manage Subject</h2>
			<p><strong>Menu name: </strong><?php echo htmlentities($current_subject["menu_name"]); ?></p>
			<p><strong>Position: </strong><?php echo htmlentities($current_subject["position"]); ?></p>
			<p><strong>Visible: </strong><?php echo htmlentities($current_subject["visible"] == 1 ? "Yes" : "No"); ?></p>
			<a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" class="btn btn-primary">Edit Subject</a>
			<a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Subject</a>
			<hr>
			<div class="container-fluid">
				<h3>Pages in this subject: </h3>
				<div class="row">
					<div class="col-md-3">
						<ul class="nav nav-pills nav-stacked">
							<?php
								$page_set = find_pages_for_subjects($current_subject["id"], false);
								while ($page = mysqli_fetch_assoc($page_set)) {
									$result = "<li><a href=\"";
									$result .= $_SERVER["PHP_SELF"];
									$result .= "?page=";
									$result .= urlencode($page["id"]);
									$result .= "\">";
									$result .= htmlentities($page["menu_name"]);
									$result .= "</a></li>";
									echo $result;
								}
							?>
						</ul>
					</div>
				</div>
				<a href="new_page.php" class="btn btn-primary" onclick="<?php $_SESSION['subject_id'] = $current_subject['id']; ?>">Add A New Page</a>
			</div>
		<?php } elseif ($current_page) { ?>
			<h2>Manage Page</h2>
			<p><strong>Menu name: </strong><?php echo htmlentities($current_page["menu_name"]); ?></p>
			<p><strong>Position: </strong><?php echo htmlentities($current_page["position"]); ?></p>
			<p><strong>Visible: </strong><?php echo htmlentities($current_page["visible"] == 1 ? "Yes" : "No"); ?></p>
			<p><strong>Content: </strong></p>
			<p class="bg-info"><?php echo nl2br(htmlentities($current_page["content"])); ?></p>

			<a href="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>" class="btn btn-primary">Edit Page</a>
			<a href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Page</a>
		<?php } else { ?>
			<?php if(!isset($_SESSION["message"]) || !isset($_SESSION["errors"])) { ?>
				<br>
				<h4>Please select a subject or page.</h4>
			<?php } ?>
		<?php } ?>

	</div>
</div>

<?php include('../inc/layouts/footer.php'); ?>