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


        if(empty($errors)) {
            // Attempt Login
            $username = $_POST['user_name'];
            $password = $_POST['password'];

            $found_admin = attempt_login($username, $password);

            if ($found_admin) {
                // Success
                // Mark user as logged in
                $_SESSION["admin_id"] = $found_admin["id"];
                $_SESSION["username"] = $found_admin["user_name"];
                redirect_to("admin");
            } else {
                $_SESSION['message'] = "Login failed";
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
                <h2>Log In</h2>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form">
                    <div class="form-group">
                        <label for="user_name">Username</label>
                        <input type="text" class="form-control" id="user_name" placeholder="Username" autofocus name="user_name" value="<?php if(isset($_POST['user_name'])) { echo htmlentities($_POST['user_name']); } ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                    </div>
                    <button type="submit" class="btn btn-success btn-block" name="submit"><span class="glyphicon glyphicon-log-in"></span></button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include('../inc/layouts/footer.php'); ?>