<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require_once __CI__ . "yamlReader.php";
$file_path = __CM__ . 'configs/config.inc.yaml';


    $yaml_data = read_yaml($file_path);
   
    $discord = $yaml_data['discord'];
    $clientId = $discord['client_id'];
    $redirectUri = $discord['redirect_url'];
    $scope = $discord['scopes'];
    function gen_state() {
        return bin2hex(random_bytes(16));
    }
    $state = gen_state();
    $authorizeUri = 'https://discordapp.com/oauth2/authorize?response_type=code&client_id=' . $clientId . '&redirect_uri=' . $redirectUri . '&scope=' . $scope . '&state=' . $state;
    header('Location: ' . $authorizeUri);
    exit;
