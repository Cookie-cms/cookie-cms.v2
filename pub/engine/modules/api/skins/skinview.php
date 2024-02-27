<?php
	error_reporting(E_ALL);
    ini_set('display_errors', true);// Функции с плащами пока вырезаны
    require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require __CM__ . "inc/mysql.php";

if (isset($_GET['type']) && $_GET['type'] == 'skin') {
    $uuid = $_GET['uuid'];

    // SQL query with a parameter placeholder
    $sql = 'SELECT c.`cloak`
            FROM `users_profiles` u
            LEFT JOIN `cape_users` uc
            ON uc.`uid` = u.`id`
            LEFT JOIN `cloaks` c
            ON c.`id` = uc.`cid`
            WHERE u.`uuid` = :uuid';

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind the parameter
    $stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $cloakQueryResult = $stmt->fetch(PDO::FETCH_OBJ);

    if ($cloakQueryResult !== false && isset($cloakQueryResult->cloak)) {
        // Continue with the rest of your code
        $cloakName = $cloakQueryResult->cloak;
        $cloakPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/capes/{$cloakName}.png";
        $sha256HashHexCloak = hash_file('sha256', $_SERVER['DOCUMENT_ROOT'] . "/uploads/capes/{$cloakName}.png");
        $cloakUrl = "http://192.168.1.85/uploads/capes/{$cloakName}.png";
        
        
        $responseData = array(
            "SKIN" => array(
                "url" => "http://192.168.1.85/uploads/skins/{$uuid}.png",
                "digest" => hash_file('sha256', $_SERVER['DOCUMENT_ROOT'] . "/uploads/skins/{$uuid}.png"),
                "metadata" => array(
                    "model" => "false"
                )
            ),
            "CAPE" => array(
                "url" => $cloakUrl,
                "digest" => $sha256HashHexCloak
            )
        );

        // Set the content type to JSON
        header('Content-Type: application/json');

        // Encode the data as JSON and echo it
        echo json_encode($responseData, JSON_PRETTY_PRINT);
    } else {
        // If no cloak is found, construct JSON response for SKIN only
        $skinData = array(
            "url" => "http://192.168.1.85/uploads/skins/{$uuid}.png",
            "digest" => hash_file('sha256', $_SERVER['DOCUMENT_ROOT'] . "/uploads/skins/{$uuid}.png"),
            "metadata" => array(
                "model" => "false"
            )
        );

        // Set the content type to JSON
        header('Content-Type: application/json');

        // Encode the data as JSON and echo it
        // echo json_encode(array("SKIN" => $skinData), JSON_PRETTY_PRINT);
    }

}


if (isset($_GET['type']) && $_GET['type'] == 'extra') {
    // Include the file with corrected parameters
    $uuid = $_GET['uuid'];
    $size = $_GET['size'];
    $mode = $_GET['mode'];
    $skin = [
		'dir_skins' => __RDS__ .'/uploads/skins/', // Путь до папки скинов от текущего каталога
		'dir_cloaks' => '/api?module=skin&type=cape&uuid=', // Путь до папки плащей от текущего каталога
		'default' => 'default', // Дефолтный скин
        'user' => $uuid,
        'size' => $size,
        'mode' => $mode,
	];
	// if (!is_dir($skin['dir_skins']) or !is_dir($skin['dir_cloaks'])) {
	// if (!is_dir($skin['dir_skins'])) {
	// 	exit('Путь к скинам или плащам не является папкой! Укажите правильный путь.');
	// }
	if (file_exists($skin['dir_skins'].$skin['user'].'.png')) {
		$skin['skin'] = $skin['dir_skins'].$skin['user'].'.png';
	} else {
		$skin['skin'] = $skin['dir_skins'].$skin['default'].'.png';
	}
	if (file_exists($skin['dir_cloaks'] . $skin['user'] . '.png')) {
    $skin['cloak'] = $skin['dir_cloaks'] . $skin['user'] . '.png';
    $skin['cloak_check'] = true;
} else {
    $skin['cloak_check'] = false;
}
	if (empty($skin['size'])) {
		$skin['size'] = '128';
	}
	if (empty($skin['mode'])) {
		$skin['mode'] = '1';
	}
	function imageturn($result, $img, $rx = 0, $ry = 0, $x = 0, $y = 0, $size_x = null, $size_y = null) {
		if ($size_x  < 1) {
			$size_x = imagesx($img);
		}
		if ($size_y  < 1) {
			$size_y = imagesy($img);
		}
		imagecopyresampled($result, $img, $rx, $ry, ($x + $size_x-1), $y, $size_x, $size_y, 0-$size_x, $size_y);
	}
	$skin['skif'] = getimagesize($skin['skin']);
	$skin['h'] = $skin['skif']['0'];
	$skin['w'] = $skin['skif']['1'];
	$skin['r'] = $skin['h']/64;
	header ("Content-type: image/png");
	$skin['s'] = imagecreatefrompng($skin['skin']);
    if ($skin['cloak_check']) {
        $skin['c'] = imagecreatefrompng($skin['cloak']);
    }
	$skin['p'] = imagecreatetruecolor(16*$skin['r'], 32*$skin['r']);
	$skin['t'] = imagecolorallocatealpha($skin['p'], 255, 255, 255, 127);
	imagefill($skin['p'], 0, 0, $skin['t']);
	if ($skin['mode'] == '1') {
		if ($skin['cloak_check']) {
			imagecopy($skin['p'], $skin['c'], 3*$skin['r'], 8*$skin['r'], 12*$skin['r'], 1*$skin['r'], 10*$skin['r'], 16*$skin['r']);
		}
		// Face
		imagecopy($skin['p'], $skin['s'], 4*$skin['r'], 0*$skin['r'], 8*$skin['r'], 8*$skin['r'], 8*$skin['r'], 8*$skin['r']);
		// Arms
		imagecopy($skin['p'], $skin['s'], 0*$skin['r'], 8*$skin['r'], 44*$skin['r'], 20*$skin['r'], 4*$skin['r'], 12*$skin['r']);
		imageturn($skin['p'], $skin['s'], 12*$skin['r'], 8*$skin['r'], 44*$skin['r'], 20*$skin['r'], 4*$skin['r'], 12*$skin['r']);
		// Chest
		imagecopy($skin['p'], $skin['s'], 4*$skin['r'], 8*$skin['r'], 20*$skin['r'], 20*$skin['r'], 8*$skin['r'], 12*$skin['r']);
		// Legs
		imagecopy($skin['p'], $skin['s'], 4*$skin['r'], 20*$skin['r'], 4*$skin['r'], 20*$skin['r'], 4*$skin['r'], 12*$skin['r']);
		imageturn($skin['p'], $skin['s'], 8*$skin['r'], 20*$skin['r'], 4*$skin['r'], 20*$skin['r'], 4*$skin['r'], 12*$skin['r']);
		// Hat
		imagecopy($skin['p'], $skin['s'], 4*$skin['r'], 0*$skin['r'], 40*$skin['r'], 8*$skin['r'], 8*$skin['r'], 8*$skin['r']);
	} elseif ($skin['mode'] == '2') {
		// Back body
		imagecopy($skin['p'], $skin['s'], 4*$skin['r'], 8*$skin['r'], 32*$skin['r'], 20*$skin['r'], 8*$skin['r'], 12*$skin['r']);
		// Head back
		imagecopy($skin['p'], $skin['s'], 4*$skin['r'], 0*$skin['r'], 24*$skin['r'], 8*$skin['r'], 8*$skin['r'], 8*$skin['r']);
		// Back arms
		imageturn($skin['p'], $skin['s'], 0*$skin['r'], 8*$skin['r'], 52*$skin['r'], 20*$skin['r'], 4*$skin['r'], 12*$skin['r']);
		imagecopy($skin['p'], $skin['s'], 12*$skin['r'], 8*$skin['r'], 52*$skin['r'], 20*$skin['r'], 4*$skin['r'], 12*$skin['r']);
		// Back legs
		imageturn($skin['p'], $skin['s'], 4*$skin['r'], 20*$skin['r'], 12*$skin['r'], 20*$skin['r'], 4*$skin['r'], 12*$skin['r']);
		imagecopy($skin['p'], $skin['s'], 8*$skin['r'], 20*$skin['r'], 12*$skin['r'], 20*$skin['r'], 4*$skin['r'], 12*$skin['r']);
		// Hat back
		imagecopy($skin['p'], $skin['s'], 4*$skin['r'], 0*$skin['r'], 56*$skin['r'], 8*$skin['r'], 8*$skin['r'], 8*$skin['r']);
		if ($skin['cloak_check']) {
			imagecopy($skin['p'], $skin['c'], 3*$skin['r'], 8*$skin['r'], 1*$skin['r'], 1*$skin['r'], 10*$skin['r'], 16*$skin['r']);
		}
	} elseif ($skin['mode'] == '3') {
		$skin['p'] = imagecreatetruecolor(8*$skin['r'], 8*$skin['r']);
		imagecopy($skin['p'], $skin['s'], 0, 0, 8*$skin['r'], 8*$skin['r'], 8*$skin['r'], 8*$skin['r']);
		imagecopy($skin['p'], $skin['s'], 0, 0, 40*$skin['r'], 8*$skin['r'], 8*$skin['r'], 8*$skin['r']);
	}
	if ($skin['mode'] == '3') {
		$skin['fs'] = imagecreatetruecolor($skin['size'],$skin['size']);
	} else {
		$skin['fs'] = imagecreatetruecolor($skin['size'],$skin['size']*2);
	}
	imagesavealpha($skin['fs'], true);
	$skin['t'] = imagecolorallocatealpha($skin['fs'], 255, 255, 255, 127);
	imagefill($skin['fs'], 0, 0, $skin['t']);
	imagecopyresized($skin['fs'], $skin['p'], 0, 0, 0, 0, imagesx($skin['fs']), imagesy($skin['fs']), imagesx($skin['p']), imagesy($skin['p']));
	imagepng($skin['fs']);
	imagedestroy($skin['fs']);
	imagedestroy($skin['p']);
	imagedestroy($skin['s']);
	if ($skin['cloak_check']) {
		imagedestroy($skin['c']);
	}

    exit();

}


if (isset($_GET['type']) && $_GET['type'] == 'cape') {
        // Assuming you have already defined $conn (PDO connection) and $uuid
        $uuid = $_GET['uuid'];

    // SQL query with a parameter placeholder
    $sql = 'SELECT c.`cloak`
            FROM `users_profiles` u
            LEFT JOIN `cape_users` uc
            ON uc.`uid` = u.`id`
            LEFT JOIN `cloaks` c
            ON c.`id` = uc.`cid`
            WHERE u.`uuid` = :uuid';

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind the parameter
    $stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $cloakQueryResult = $stmt->fetch(PDO::FETCH_OBJ);
        // Continue with the rest of your code
        $cloakName = $cloakQueryResult->cloak;
        $CLOAK = $_SERVER['DOCUMENT_ROOT'] . "/uploads/capes/{$cloakName}.png";
        

        // Set the content type to JSON
        header ("Content-type: image/png");
		$cloak = imagecreatefrompng($CLOAK);
		imagealphablending($cloak, false);
		imagesavealpha($cloak, true);
		imagepng($cloak);

        // echo($cloakUrl);

        // Encode the data as JSON and echo it
        // echo json_encode($responseData, JSON_PRETTY_PRINT);
    }
