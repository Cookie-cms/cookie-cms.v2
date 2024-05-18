<?php
function checkIpDetails($ipAddress) {
    // Construct the API URL
    $apiUrl = "http://ip-api.com/json/$ipAddress?fields=status,message,country,regionName,city,mobile,proxy,hosting,query";

    $response = file_get_contents($apiUrl);

    $ipDetails = json_decode($response, true);

    return $ipDetails;
}

function isLocalIp($ipAddress) {
    // Define the local IP range (192.168.0.0 to 192.168.225.255)
    $localIpStart = ip2long('192.168.0.0');
    $localIpEnd = ip2long('192.168.225.255');

    // Convert the IP address to a long integer
    $ipToCheck = ip2long($ipAddress);

    // Check if the IP is within the local range
    return ($ipToCheck >= $localIpStart && $ipToCheck <= $localIpEnd);
}

?>