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
define('__JS__', __TDS__ . 'js/');
define('__AS__', __TD__ . 'assets/');
define('__INT__', __TD__ . 'inc/');
define('__ven__', __RDS__ . '/../vendor/autoload.php');
define('__hub__', __RDS__ . '/../');
require_once __CI__ . "TemplateEngine.php";
require_once __CI__ . "yamlReader.php";
// require_once __CI__ . "mail.php";
include  __CD__ . "pages/global.php";
require_once 'templates.php';
