<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
define('__DEF__', $_SERVER['DOCUMENT_ROOT'] . '/define.php');
// require_once __CI__ . "yamlReader.php";

$file_path = __CM__ . 'configs/config.inc.yaml';
$yaml_data = read_yaml($file_path);

$pageing_path = __CM__ . 'configs/pages.yaml';
$page_data = read_yaml($pageing_path);

// echo($file_path);
// Access the 'database' section
$maintenance = $yaml_data['maintenance'];
$debuger = $yaml_data['debug'];

// var_dump($databaseConfig);
// Access specific values

$maintenanceStatus = $maintenance['enabled'];
$requestUri = $_SERVER['REQUEST_URI'];
$debug = $debuger['debug'];

// Extract the path part of the URI (excluding the query parameters)
$uriPath = parse_url($requestUri, PHP_URL_PATH);
$uriSegments = explode('/', trim($uriPath, '/'));
$page = isset($uriSegments[0]) && $uriSegments[0] !== '' ? $uriSegments[0] : 'index';
define('__URI__', strstr($_SERVER['REQUEST_URI'], '?', true) ? strstr($_SERVER['REQUEST_URI'], '?', true) : $_SERVER['REQUEST_URI']);
define('__URL__', array_slice(explode('/', substr(__URI__, 1)), 0, 3));
$templatePath = '';
$variablesPath = __DIR__ . "/engine/pages/{$page}.php";

// Check if there are additional URI segments for dynamic query parameters
// if (count($uriSegments) > 1) {
//     // Construct additional URI segments as part of the file name
//     for ($i = 1; $i < count($uriSegments); $i++) {
//         $variablesPath .= '-' . $uriSegments[$i];
//     }
//     $variablesPath .= '.php';
// }
// Extract query parameters
$queryParams = $_GET;
// var_dump($page_data);
// Extract the first segment of the URL
// $p = $pageing[$page];
// echo $p;
// $page = "index";    
// $pages = 'index'; // Assign a default value to $pages
// $a = $page_data[$pages];
if ($page === $page_data[$page]['uri'] && empty(__URL__[2])) {
    // Set the template for the general home page
    if ($yaml_data['maintenance'] == "true") {
        if ($maintenanceStatus) {
            // Set the template for the maintenance page
            $templatePath = __DIR__ . "/template/pages/maintenance.tpl";
            echo "Maintenance Mode is Active!";
        } else {
            $templatePath = __DIR__ . "/template/pages/{$page_data[$page]['template']}.tpl";
            $variablesPath = __DIR__ . "/engine/pages/{$page_data[$page]['variablesPath']}.php";
            echo "Maintenance Mode is Inactive!";
        }
    } else {
        $templatePath = __DIR__ . "/template/pages/{$page_data[$page]['template']}.tpl";
        $variablesPath = __DIR__ . "/engine/pages/{$page_data[$page]['variablesPath']}.php";
        echo "Maintenance Mode is without!";
    }
} else {
    if ($maintenanceStatus) {
        $templatePath = __DIR__ . "/template/pages/maintenance.tpl";
        echo "Maintenance Mode is active!";
        
    } else {
        $templatePath = __DIR__ . "/template/pages/{$page}.tpl";
        echo "Maintenance Mode is Inactive!";

    }
}
// elseif ($page === 'admin' && empty(__URL__[2])) {
//     // Set the template for the admin index page
//     $templatePath = __DIR__ . "/template/pages/admin/index.tlp";
// } elseif ($page === 'admin' && !empty(__URL__[2])) {
//     // Set the template for admin pages
//     $adminPage = __URL__[2];
//     $templatePath = __DIR__ . "/template/pages/admin/{$adminPage}.tlp";
// } else {
//     if ($maintenanceStatus) {
//         // Set the template for the maintenance page
//         $templatePath = __DIR__ . "/template/pages/maintenance.tpl";
//     } else {
//         // Assuming $page is another variable representing the desired page
//         $templatePath = __DIR__ . "/template/pages/{$page}.tpl";
//     }
// }

// if ($page === $config["$page"]['uri'] && empty(__URL__[2])) {
//     if ($maintenanceStatus) {
//         $templatePath = __DIR__ . "/template/pages/maintenance.tpl";
//     } else {
//         $templatePath = __DIR__ . "/template/pages/" . $config[$page]['template'] . ".tpl";
//         $variablesPath = __DIR__ . "/engine/pages/" . $config[$page]['variablesPath'] . ".php";
//     }
// } else {
//         if ($maintenanceStatus) {
//             $templatePath = __DIR__ . "/template/pages/maintenance.tpl";
            
//         } else {
//             $templatePath = __DIR__ . "/template/pages/{$page}.tpl";
//         }
//     }


if ($debug) {
echo '<p style="font-size: 20px;">Template Path: ' . $templatePath . '</p>';
echo '<p style="font-size: 20px;">Core Page Path: ' . $variablesPath . '</p>';
echo '<p style="font-size: 20px;">Requested URI: ' . $requestUri . '</p>';
}

$links = [
    "discord" => "https://discord.gg/54PeQCNY",
    "github" => "/githubt",
    // Add more links as needed
];

$redirectTo = null;

foreach ($links as $key => $link) {
    // Check if the current URI contains the link as a segment
    if (isset($link) && strpos($_SERVER['REQUEST_URI'], $key) !== false) {
        $redirectTo = $link;
        break; // Stop the loop if a match is found
    }
}

if ($redirectTo) {
    // Redirect to the matched URI
    header("Location: " . $redirectTo);
    exit(); // Ensure script stops after redirect
} else {
    // Fallback logic if no match is found

    if (file_exists($templatePath)) {
        // Include the variables file
        if (file_exists($variablesPath)) {
            include $variablesPath;
        }

        // Instantiate the TemplateEngine class
        $templateEngine = new TemplateEngine();

        // Set variables for the main template
        foreach ($variables as $key => $value) {
            $templateEngine->assign($key, $value);
        }

        // Set variables for the header template
        $templateEngine->assignHeader('headerVar', 'Header Variable');

        // Pass query parameters to the template
        $templateEngine->assign('queryParams', $queryParams);

        // Render the template using the TemplateEngine class
        $output = $templateEngine->render($templatePath);

        // Output the rendered template
        echo $output;
    } else {
        include ('../errors/404.html');
    }
}
?>
