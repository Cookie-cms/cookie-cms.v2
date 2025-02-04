<?php
# This file is part of CookieCMS Open.
#
# CookieCMS Open is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# CookieCMS Open is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with CookieCMS Open. If not, see <http://www.gnu.org/licenses/>.
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
