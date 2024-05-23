<?php

function msgdisplay($error, $msg) {
    $error = isset($error) ? (bool)$error : false; // Set $error to true if $error is provided and not null
    $msg = htmlspecialchars($msg);
    header('Content-Type: application/json');
    $responseData = array(
        'error' => $error,
        'msg' => $msg
    );
    return json_encode($responseData, JSON_PRETTY_PRINT);
}
