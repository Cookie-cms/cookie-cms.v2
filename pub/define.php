<?php
// error_reporting(E_ALL);
// ini_set('display_errors', true);
define('__RD__', '/');
define('__RDS__', $_SERVER['DOCUMENT_ROOT']);
define('__UD__', __RD__ . 'uploads/');
define('__TD__', __RDS__ . "/template/");
define('__TDS__', __RD__ . "template/");
define('__CM__', __RDS__ . '/engine/modules/');
define('__CML__', __RD__ . 'engine/modules/');
define('__CD__', __RDS__ . '/engine/');
define('__CDL__', __RD__ . '/engine/');
define('__CF__', __CD__ . 'configs/');
define('__CI__', __CM__ . 'inc/');
define('__CIL__', __CML__ . 'inc/');
define('__CSS__', __TDS__ . 'css/');
define('__JS__', __TD__ . 'js/');
define('__AS__', __TD__ . 'assets/');
define('__INT__', __TD__ . 'inc/');

require_once __CI__ . "TemplateEngine.php";
// require_once __CI__ . "yamlReader.php";
require_once __CI__ . "mail.php";
include  __CD__ . "pages/global.php";
