<!-- Kani ang Code nga dili na ma back kung maka log out na -->
<?php
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();
 unset($_SESSION['id']); 
// Unset all of the session variables.
$_SESSION = array();
// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

header("location:index.php");
?>

