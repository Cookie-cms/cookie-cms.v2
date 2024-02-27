<?php

// Your access token
$accessToken = "1111-1121";

// URL of your PHP page
$phpPageUrl = "http://192.168.1.85/api/service/g";

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $phpPageUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer $accessToken",
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute cURL session
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Display the response from your PHP page
echo $response;
