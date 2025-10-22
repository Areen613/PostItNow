<?php
session_start();
session_unset();   // Clear all session variables
session_destroy(); // Destroy the session

// Adjust redirect path based on your actual project directory structure
header("Location: /PostItNow_MultiLayered_Base/index.php");
exit();
