<?php
    require_once('../inc/session.php');
    $page_title = "Edit Admin";
    require_once('../inc/db_connection.php');
    require_once('../inc/functions.php');
    require_once('../inc/validation_functions.php');
?>

<?php $is_public = false; ?>
<?php include('../inc/layouts/header.php'); ?>

<?php
    if (isset($_POST["submit"])) {
        // validations
        $required_fields = ["user_name", "password"];
        validate_presences($required_fields);

        $fields_with_max_length = ["user_name" => 15];
        validate_max_lengths($fields_with_max_length);

        if(empty($errors)) {
            // If validation passes Perform Update
            $user_name = mysql_prep($_POST["user_name"]);
            $password = mysql_prep($_POST["password"]);

            // query sent to mysql
            $query = "INSERT INTO admins SET user_name='{$user_name}', hashed_password='{$password}'";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $_SESSION["message"] = "Admin successfully created.";
                redirect_to("manage_admins.php");
            } else {
                $_SESSION['message'] = "Admin creation failed";
            }
        }
    } else {

    }
?>

<div class="container-fluid" id="main">
    <div class="col-xs-12 col-md-offset-2 col-md-6" id="page">
        <div class="row">
            <div class="col-md-6">
                <?php echo message(); ?>
                <?php echo errors(); ?>
                <?php
                    if (!empty($message)) {
                        echo htmlentities($message);
                    }
                    echo form_errors($errors);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h2>New Admin</h2>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form">
                    <div class="form-group">
                        <label for="user_name">Username</label>
                        <input type="text" class="form-control" id="user_name" placeholder="Username" autofocus name="user_name" value="<?php if(isset($_POST['user_name'])) { echo htmlentities($_POST['user_name']); } ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                    </div>
                    <button type="submit" class="btn btn-success" name="submit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                    <a href="manage_admins.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include('../inc/layouts/footer.php'); ?>