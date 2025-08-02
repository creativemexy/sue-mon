<?php
// Error handler to catch HTTP 500 errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Custom error handler
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 10px; border-radius: 5px;'>";
    echo "<h3>PHP Error</h3>";
    echo "<p><strong>Error:</strong> $errstr</p>";
    echo "<p><strong>File:</strong> $errfile</p>";
    echo "<p><strong>Line:</strong> $errline</p>";
    echo "<p><strong>Error Type:</strong> ";
    
    switch ($errno) {
        case E_ERROR:
            echo "E_ERROR";
            break;
        case E_WARNING:
            echo "E_WARNING";
            break;
        case E_PARSE:
            echo "E_PARSE";
            break;
        case E_NOTICE:
            echo "E_NOTICE";
            break;
        default:
            echo "Unknown";
    }
    echo "</p></div>";
    
    return true; // Don't execute PHP internal error handler
}

// Set the custom error handler
set_error_handler("customErrorHandler");

// Fatal error handler
function fatalErrorHandler() {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 10px; border-radius: 5px;'>";
        echo "<h3>Fatal Error</h3>";
        echo "<p><strong>Error:</strong> " . $error['message'] . "</p>";
        echo "<p><strong>File:</strong> " . $error['file'] . "</p>";
        echo "<p><strong>Line:</strong> " . $error['line'] . "</p>";
        echo "</div>";
    }
}

register_shutdown_function("fatalErrorHandler");

// Test the error handler
echo "<h2>Error Handler Test</h2>";
echo "<p>If you see this message, the error handler is working.</p>";

// Test with a non-fatal error
trigger_error("This is a test error", E_USER_WARNING);

echo "<h3>Testing Application Files...</h3>";

// Test each file individually
$files_to_test = [
    'config/config.php',
    'config/supabase_client.php',
    'includes/functions.php',
    'includes/auth.php',
    'index.php'
];

foreach ($files_to_test as $file) {
    echo "<h4>Testing $file</h4>";
    try {
        if (file_exists($file)) {
            include_once $file;
            echo "<p style='color: green;'>✅ $file loaded successfully</p>";
        } else {
            echo "<p style='color: red;'>❌ $file not found</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Error in $file: " . $e->getMessage() . "</p>";
    } catch (Error $e) {
        echo "<p style='color: red;'>❌ Fatal error in $file: " . $e->getMessage() . "</p>";
    }
}

echo "<h3>Test Complete</h3>";
echo "<p>If you see any errors above, those are likely causing your HTTP 500 error.</p>";
?> 