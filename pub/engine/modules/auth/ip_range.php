<?php

function isLocalIp($ipAddress) {
    // Define the local IP range (192.168.0.0 to 192.168.225.255)
    $localIpStart = ip2long('192.168.0.0');
    $localIpEnd = ip2long('192.168.225.255');

    // Convert the IP address to a long integer
    $ipToCheck = ip2long($ipAddress);

    // Check if the IP is within the local range
    return ($ipToCheck >= $localIpStart && $ipToCheck <= $localIpEnd);
}

// Get the user's IP address from $_SERVER['REMOTE_ADDR']
$userIpAddress = $_SERVER['REMOTE_ADDR'];

// Check if the IP is in the local range
$isLocal = isLocalIp($userIpAddress);

// Output the result
if ($isLocal) {
    echo "The IP address {$userIpAddress} is in the local range (192.168.0.0 to 192.168.225.255).";
} else {
    echo "The IP address {$userIpAddress} is NOT in the local range (192.168.0.0 to 192.168.225.255).";
}

?>
