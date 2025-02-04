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
error_reporting(E_ALL);
ini_set('display_errors', true);

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
define('__DEF__', $_SERVER['DOCUMENT_ROOT'] . '/define.php');
$links = require_once "define_links.php";
$file_path = __CM__ . 'configs/config.inc.yaml';
$links_path = __CM__ . 'configs/links.yaml';
$pageing_path = __CM__ . 'configs/pages.yaml';


$main_data = read_yaml($file_path);
$links_data = read_yaml($links_path);
$pages_data = read_yaml($pageing_path);

$maintenance = $main_data['maintenance'];
$debuger = $main_data['debug'];
$maintenanceStatus = $maintenance['enabled'];
$requestUri = $_SERVER['REQUEST_URI'];
$debug = $debuger['debug'];
// var_dump($yaml_data);


$uriPath = parse_url($requestUri, PHP_URL_PATH);
$uriSegments = explode('/', trim($uriPath, '/'));
$page = isset($uriSegments[0]) && $uriSegments[0] !== '' ? $uriSegments[0] : 'index';
define('__URI__', strstr($_SERVER['REQUEST_URI'], '?', true) ? strstr($_SERVER['REQUEST_URI'], '?', true) : $_SERVER['REQUEST_URI']);
define('__URL__', array_slice(explode('/', substr(__URI__, 1)), 0, 3));
$templatePath = '';
$variablesPath = __DIR__ . "/engine/pages/{$page}.php";
$queryParams = $_GET;



$templateDir = __DIR__ . "/template/pages/";
$engineDir = __DIR__ . "/engine/pages/";

if (isset($pages_data[$page]) && $page === $pages_data[$page]['uri']) {
    $template = $pages_data[$page]['template'];
    $variablesPath = $pages_data[$page]['variablesPath'];
    $default = $pages_data[$page]['default'];
    $url = isset(__URL__[1]) ? __URL__[1] : '';

    if ($pages_data[$page]['maintenance'] == "false" && $maintenanceStatus) {
        $templatePath = $templateDir . "maintenance.html";
        $variablesPath = $engineDir . "index.php";
    } else if ($pages_data[$page]['category'] == "true") {
        $templatePath = $templateDir . "$template/" . ($url ? "$url.html" : "$default.html");
        $variablesPath = $engineDir . "$variablesPath/" . ($url ? "$url.php" : "$default.php");
    } else {
        $templatePath = $templateDir . "$template.html";
        $variablesPath = $engineDir . "$variablesPath.php";
    }
}



// if ($maintenanceStatus) {
//     $templatePath = __DIR__ . "/template/pages/maintenance.html";        
// } else {
//     $templatePath = __DIR__ . "/template/pages/{$page}.html";
// }

// $templatePath = __DIR__ . "/template/pages/{$pages_data[$page]['template']}/{$pages_data[$page]['default']}.html";
// $variablesPath = __DIR__ . "/engine/pages/{$pages_data[$page]['variablesPath']}/{$pages_data[$page]['default']}.php";

// $templatePath = __DIR__ . "/template/pages/{$pages_data[$page]['uri']}/$url.html";
// $variablesPath = __DIR__ . "/engine/pages/{$pages_data[$page]['variablesPath']}/$url.php";

// $templatePath = __DIR__ . "/template/pages/{$pages_data[$page]['template']}.html";
// $variablesPath = __DIR__ . "/engine/pages/{$pages_data[$page]['variablesPath']}.php";

if ($debug) {
    echo '<p style="font-size: 20px;">Template Path: ' . $templatePath . '</p>';
echo '<p style="font-size: 20px;">Core Page Path: ' . $variablesPath . '</p>';
echo '<p style="font-size: 20px;">Requested URI: ' . $requestUri . '</p>';
    // $debugphp = __DIR__ . "/engine/modules/inc/debug.php";
    // $debughtml = __DIR__ . '/template/inc/debug.html';
    // if (file_exists($debugphp)) {
    //     include $debugphp;
    //     $debugshow = new TemplateEngine();
    //     foreach ($variables as $key => $value) {
    //         $debugshow->assign($key, $value);
    //     }
    //     $debugshow->assignHeader('headerVar', 'Header Variable');
    //     $debugshow->assign('queryParams', $queryParams);
    //     $output = $debugshow->render($debughtml);
    //     echo $output;
    // } else {
    //     echo "Debug file not found.";
    // }
}

$redirectTo = null;

foreach ($links_data as $key => $link) {
    if (isset($link) && strpos($_SERVER['REQUEST_URI'], $key) !== false) {
        $redirectTo = $link;
        break;
    }
}
if ($redirectTo) {
    header("Location: " . $redirectTo);
    exit();
} else {
    if (file_exists($templatePath)) {
        if (file_exists($variablesPath)) {
            include $variablesPath;
        }
        $templateEngine = new TemplateEngine();
        if (isset($variables)) {
            foreach ($variables as $key => $value) {
                $templateEngine->assign($key, $value);
            }        
        } else {
            $variables = [];
        }
        
        $templateEngine->assignHeader('headerVar', 'Header Variable');
        $templateEngine->assign('queryParams', $queryParams);
        $output = $templateEngine->render($templatePath);
        echo $output;
    } else {
        include ('../errors/404.html');
    }
}
?>
