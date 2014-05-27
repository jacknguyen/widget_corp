<?php
    require_once('../inc/session.php');
    require_once('../inc/db_connection.php');
    $page_title = "Admin";
    require_once('../inc/functions.php');
?>

<?php $is_public = false; ?>
<?php include('../inc/layouts/header.php'); ?>

<div class="container-fluid" id="main">
    <div class="col-xs-12 col-md-offset-2 col-md-6" id="page">
        <?php echo message(); ?>
        <?php echo errors(); ?>
        <h2>Manage Admins</h2>
        <div class="col-md-8">
            <table class="table table-hover">
                <th>Username</th>
                <th>Actions</th>
                <?php $admins = find_all_admins(); ?>
                <?php while ($admin = mysqli_fetch_assoc ($admins)) { ?>
                    <tr>
                        <td><?php echo $admin['user_name']; ?></td>
                        <td>
                            <a href="edit_admin.php?admin_id=<?php echo $admin["id"]; ?>" class="btn btn-default">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <a href="delete_admin.php?admin_id=<?php echo $admin["id"]; ?>" class="btn btn-default btn-danger" onclick="return confirm('Are you sure?')">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <div>
                <a href="new_admin.php" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span></a>
            </div>
        </div>
    </div>
</div>

<?php include('../inc/layouts/footer.php'); ?>