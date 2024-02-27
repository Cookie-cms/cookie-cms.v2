<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
// $yamlFilePath = __CM__ . 'configs/config.inc.yml';
require_once __CI__ . "yamlReader.php";

$file_path = __CM__ . 'configs/template.yaml';
$yaml_data = read_yaml($file_path);


$projectname = $yaml_data['projectname'];
$icon = $yaml_data['icon'];
$bootstrapcss = $yaml_data['bootstrapcss'];
$bootstrapjs = $yaml_data['bootstrapjs'];
$bootstrapicons = $yaml_data['bootstrapicons'];
$jquery = $yaml_data['icon'];
$t = $requestUri;
$indexdescription = $yaml_data['indexdescription'];

?>
