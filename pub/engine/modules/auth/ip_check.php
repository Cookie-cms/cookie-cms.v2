<?php
function checkIpDetails($ipAddress) {
    // Construct the API URL
    $apiUrl = "http://ip-api.com/json/$ipAddress?fields=status,message,country,regionName,city,mobile,proxy,hosting,query";

    // Make the API request
    $response = file_get_contents($apiUrl);

    // Decode JSON response
    $ipDetails = json_decode($response, true);

    // Display IP details
    var_dump($ipDetails);
    // echo "IP Address: {$ipDetails['query']}\n";
    // echo "Country: {$ipDetails['country']}\n";
    // echo "Region: {$ipDetails['regionName']}\n";
    // echo "City: {$ipDetails['city']}\n";
    // echo "ISP: {$ipDetails['isp']}\n";

    // You can display more details based on your requirements
}
$ipToCheck = '24.48.0.1';

// Call the function
checkIpDetails($ipToCheck);
?>