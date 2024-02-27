<?php

function read_yaml($file_path) {
    if (!file_exists($file_path)) {
        throw new Exception("File not found: $file_path");
    }

    $yaml_content = file_get_contents($file_path);

    if ($yaml_content === false) {
        throw new Exception("Error reading file: $file_path");
    }

    $data = yaml_parse($yaml_content);

    if ($data === false) {
        throw new Exception("Error parsing YAML in file: $file_path");
    }

    return $data;
}

?>
