<?php
/**
 * PHP Information Page
 * 
 * Displays detailed PHP configuration information
 */

// Security check - only allow in development
if (isset($_ENV['ENVIRONMENT']) && $_ENV['ENVIRONMENT'] === 'production') {
    http_response_code(404);
    exit('Not found');
}

phpinfo();
?>