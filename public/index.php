<?php
	require_once('../inc/session.php');
	require_once('../inc/db_connection.php');
	require_once('../inc/functions.php');
?>
<?php include('../inc/layouts/header.php'); ?>
<?php find_selected(true); ?>

<div class="container-fluid" id="main">
	<div id="navigation" class="col-xs-12 col-md-2">
		<?php echo navigation($current_subject, $current_page); ?>
	</div>

	<div class="col-xs-12 col-md-10" id="page">
		<?php if ($current_page) { ?>
			<h3><?php echo htmlentities($current_page['menu_name']); ?></h3>
			<p><?php echo nl2br(htmlentities($current_page["content"])); ?></p>
		<?php } else { ?>
			<?php if(!isset($_SESSION["message"]) || !isset($_SESSION["errors"])) { ?>
				<br>
				<h4>Welcome</h4>
			<?php } ?>
		<?php } ?>

	</div>
</div>

<?php include('../inc/layouts/footer.php'); ?>