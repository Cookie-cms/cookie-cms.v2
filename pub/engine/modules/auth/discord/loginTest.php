// Include the login file
require_once '/home/misha/sites/var/www/cookiecms/pub/engine/modules/auth/discord/login.php';

// Test the session cookie lifetime
$expectedLifetime = 86400;
$actualLifetime = ini_get('session.cookie_lifetime');

if ($actualLifetime == $expectedLifetime) {
    echo "Test passed: session cookie lifetime is set correctly.\n";
} else {
    echo "Test failed: session cookie lifetime is not set correctly.\n";
    echo "Expected: $expectedLifetime\n";
    echo "Actual: $actualLifetime\n";
}