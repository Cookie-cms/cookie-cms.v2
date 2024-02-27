<?php

function sendDiscordEmbed($webhookUrl, $embedData) {
    // Convert data to JSON format
    $jsonData = json_encode([
        "embeds" => [$embedData['embed']]
    ]);

    // Set up cURL
    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    // Execute cURL session
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        // echo 'Curl error: ' . curl_error($ch);
    } else {
        // echo 'Message sent successfully!';
    }

    // Close cURL session
    curl_close($ch);
}