<?php
// Destroy the session
session_destroy();

// Redirect to home page
header('Location: ' . url());
exit;
?> 