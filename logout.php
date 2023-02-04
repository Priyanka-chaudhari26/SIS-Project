<?php
session_start();
unset($_SESSION['email']); // to remove/logout particular user active session
 //session_destroy(); //to remove all active sessions
// session_destroy() or unset anyone can be used.
header("location: index.php");
?>