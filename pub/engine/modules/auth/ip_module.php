<?php
# This file is part of CookieCms.
#
# CookieCms is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# CookieCms is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with CookieCms. If not, see <http://www.gnu.org/licenses/>.
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