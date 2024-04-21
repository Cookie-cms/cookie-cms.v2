<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

// function customError($errno, $errstr) {
//     $errorMessage = "[$errno] $errstr";
//     return $errorMessage;
// }
// // echo $errorMessage;

// // Set error handler
// set_error_handler("customError");

// echo $es;
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

// echo "$url";
if ($page === $pages_data[$page]['uri'] && empty(__URL__[2])) {
    if ($pages_data[$page]['maintenance'] == "true") {
        if ($maintenanceStatus) {
            $templatePath = __DIR__ . "/template/pages/maintenance.tpl";
        } else {
            if (isset(__URL__[1])) {
                $url = __URL__[1];

                echo "e:$url";
                $templatePath = __DIR__ . "/template/pages/{$pages_data[$page]['uri']}/$url.html";
                $variablesPath = __DIR__ . "/engine/pages/{$pages_data[$page]['variablesPath']}/$url.php";
            } else {
                $templatePath = __DIR__ . "/template/pages/{$pages_data[$page]['template']}.html";
                $variablesPath = __DIR__ . "/engine/pages/{$pages_data[$page]['variablesPath']}.php";


            }
        }
    } else {

            if (isset(__URL__[1])) {
                $url = __URL__[1];
                $templatePath = __DIR__ . "/template/pages/{$pages_data[$page]['uri']}/$url.html";
                $variablesPath = __DIR__ . "/engine/pages/{$pages_data[$page]['variablesPath']}/$url.php";
            } else {
                $templatePath = __DIR__ . "/template/pages/{$pages_data[$page]['template']}.html";
                $variablesPath = __DIR__ . "/engine/pages/{$pages_data[$page]['variablesPath']}.php";
            }
        
    }
} else {
    if ($maintenanceStatus) {
        $templatePath = __DIR__ . "/template/pages/maintenance.html";        
    } else {
        $templatePath = __DIR__ . "/template/pages/{$page}.html";
    }
}

if ($debug) {
    $debugphp = __DIR__ . "/engine/modules/inc/debug.php";
    $debughtml = __DIR__ . '/template/inc/debug.html';
    if (file_exists($debugphp)) {
        include $debugphp;
        $debugshow = new TemplateEngine();
        foreach ($variables as $key => $value) {
            $debugshow->assign($key, $value);
        }
        $debugshow->assignHeader('headerVar', 'Header Variable');
        $debugshow->assign('queryParams', $queryParams);
        $output = $debugshow->render($debughtml);
        echo $output;
    } else {
        echo "Debug file not found.";
    }
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
        foreach ($variables as $key => $value) {
            $templateEngine->assign($key, $value);
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
