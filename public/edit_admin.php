<?php
    require_once('../inc/session.php');
    $page_title = "Edit Admin";
    require_once('../inc/db_connection.php');
    require_once('../inc/functions.php');
    require_once('../inc/validation_functions.php');
?>

<?php $is_public = false; ?>
<?php include('../inc/layouts/header.php'); ?>

<?php $current_admin = find_admin_by_id($_GET['admin_id']); ?>

<div class="container-fluid" id="main">
    <div class="col-xs-12 col-md-offset-2 col-md-6" id="page">
        <div class="row">
            <div class="col-md-6">
                <?php echo message(); ?>
                <?php echo errors(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h2>Edit Admin: <?php echo $current_admin['user_name']; ?></h2>

                <form action="<?php echo $_SERVER['PHP_SELF'] . '?admin_id=' . urlencode($current_admin['id']); ?>" method="post" role="form">
                    <div class="form-group">
                        <label for="user_name">User name</label>
                        <input type="text" class="form-control" id="user_name" placeholder="User name" autofocus value="<?php echo $current_admin['user_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-default" name="submit">Submit</button>
                    <a href="manage_admin.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include('../inc/layouts/footer.php'); ?>