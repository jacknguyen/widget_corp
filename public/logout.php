<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/functions.php"); ?>

<?php
    // simple logout version
    $_SESSION["admin_id"] = null;
    $_SESSION["username"] = null;
    redirect_to("login");
?>

<?php
    // // version 2
    // // more aggressive

    // // starts session
    // session_start();

    // // sets the session to an empty array
    // $_SESSION = array();

    // // checks to see if the cookie with the session name exists
    // if (isset($_COOKIE[session_name()])) {
    //     // if cookie exist then the cookie name is set to empty and expire
    //     setcookie(session_name(), '', time()-1000, '/');
    // }
    // // also delete session on server
    // session_destroy();
    // redirect_to('login');
?>