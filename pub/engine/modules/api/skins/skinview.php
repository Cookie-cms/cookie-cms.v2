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
    ini_set('display_errors', true);// Функции с плащами пока вырезаны
    require_once __CI__ . "yamlReader.php";

    $file_path = __CM__ . 'configs/config.inc.yaml';
    $yaml_data = read_yaml($file_path);
    $domain = $yaml_data['basic']['domain'];

require __CM__ . "inc/mysql.php";



if (__URL__[2] == "extra") {
    // Include the file with corrected parameters
    $uuid = __URL__[3];
    $size = $_GET['size'];
    $mode = $_GET['mode'];
    $skin = [
		'dir_skins' => __RDS__ .'/uploads/skins/', // Путь до папки скинов от текущего каталога
		'dir_cloaks' => '/uploads/capes/', // Путь до папки плащей от текущего каталога
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


if (__URL__[2] == "skin") {
	$uuid = __URL__[3];
	$skin = __RDS__.'/uploads/skins/'.$uuid.'.png';

	// Check if the file exists
	if (!file_exists($skin)) {
		die("File not found: $skin");
	}

	// Set the content type header
	header('Content-Type: image/png');

	// Read and output the file contents
	readfile($skin);

	exit();
}

if (__URL__[2] == "cape") {
        // Assuming you have already defined $conn (PDO connection) and $uuid
	$uuid = __URL__[3];

    // SQL query with a parameter placeholder
	$sql = 'SELECT c.`cloak`
		FROM `skins` s
		LEFT JOIN `cloaks` c
		ON c.`id` = s.`cape`
		WHERE s.`uuid` = :uuid';
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
	if (empty($cloakName)) {
		header('Content-Type: application/json');

		$responseData = array(
			'error' => true,
			'msg' => 'No cloak found for this user'
		);
		die(json_encode($responseData, JSON_PRETTY_PRINT));
	}
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


if (__URL__[2] == "cloakview") {
	$CLOAK = __RDS__.'/uploads/capes/'.__URL__[3].'.png';
	$skin['mode'] = __URL__[4];
	$skin['size'] = __URL__[5];

	$skin['skif'] = getimagesize($CLOAK);
	$skin['h'] = $skin['skif']['0'];
	$skin['w'] = $skin['skif']['1'];
	$skin['r'] = $skin['h']/64;
	header ("Content-type: image/png");
	$skin['c'] = imagecreatefrompng($CLOAK);
	$skin['p'] = imagecreatetruecolor(10*$skin['r'], 16*$skin['r']);
	$skin['t'] = imagecolorallocatealpha($skin['p'], 255, 255, 255, 127);
	imagefill($skin['p'], 0, 0, $skin['t']);
	if ($skin['mode'] == '1') {
		imagecopy($skin['p'], $skin['c'], 0, 0, 12*$skin['r'], 1*$skin['r'], 10*$skin['r'], 16*$skin['r']);
	} elseif ($skin['mode'] == '2') {
		imagecopy($skin['p'], $skin['c'], 0, 0, 1*$skin['r'], 1*$skin['r'], 10*$skin['r'], 16*$skin['r']);
	}
	$skin['fs'] = imagecreatetruecolor($skin['size'], (int)($skin['size']*1.6));
	imagesavealpha($skin['fs'], true);
	$skin['t'] = imagecolorallocatealpha($skin['fs'], 255, 255, 255, 127);
	imagefill($skin['fs'], 0, 0, $skin['t']);
	imagecopyresized($skin['fs'], $skin['p'], 0, 0, 0, 0, imagesx($skin['fs']), imagesy($skin['fs']), imagesx($skin['p']), imagesy($skin['p']));
	imagepng($skin['fs']);
	imagedestroy($skin['fs']);
	imagedestroy($skin['p']);
	imagedestroy($skin['c']);

    exit();
}

if (__URL__[2] == "") {
	header('Content-Type: application/json');
	$response = json_encode(['error' => 'No modules found for this request']);
	echo $response;
}