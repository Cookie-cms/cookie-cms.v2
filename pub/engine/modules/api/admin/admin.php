<?php
// session_start();

error_reporting(E_ALL);
ini_set('display_errors', true);

$type = __URL__[1];
echo $type;

if (isset(__URL__[2])) {
    if (__URL__[2] == 'st') {
        // Get the URI parameters
        $type2 = __URL__[2];
        echo $type2;

        $uriParameters = http_build_query($_GET);

        // Use absolute path for inclusion with URI parameters
        $moduleFilePath = __CD__ . "modules/api/admin/st_engine.php";

        // Check if the file exists before including
        if (file_exists($moduleFilePath)) {
            include $moduleFilePath;
        } else {
            // Handle the case where the file doesn't exist
            die("Module file not found.");
        }
    }
}
?>
