<?php
    require_once('../inc/session.php');
    require_once('../inc/db_connection.php');
    require_once('../inc/functions.php');

    $current_admin = find_admin_by_id($_GET["admin_id"]);

    if (!$current_admin) {
        redirect_to("manage_admins.php");
    }

    $id = $current_admin['id'];
    $query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";
    $result = mysqli_query ($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
        $_SESSION["message"] = "Admin successfully removed.";
        redirect_to('manage_admins.php');
    } else {
        $_SESSION["errors"] = "Admin deletion failed.";
        redirect_to("manage_admins.php?page={$id}");
    }
