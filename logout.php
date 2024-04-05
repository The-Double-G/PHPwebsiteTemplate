<?php
// start the session
session_start();

// destroy the session data
session_destroy();

// redirect the user to the index.php page
header("Location: index.php");

// stop executing the script
exit();
?>
