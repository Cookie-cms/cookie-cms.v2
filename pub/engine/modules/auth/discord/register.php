<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
include __CM__ . "inc/mysql.php";
require __CM__ . "inc/webhook.php";
require_once __CI__ . "yamlReader.php";

$file_path = __CM__ . 'configs/config.inc.yaml';
$yaml_data = read_yaml($file_path);

$mail = $yaml_data['basic']['registerTypes']['basic'];

$logschat = $yaml_data['logs']['accounts'];
if (isset($_SESSION['user_data']['email'])) {
    $dsmail = $_SESSION['user_data']['email'];
    // Additional code if needed
} else {
    $dsmail = NULL;
}
$ip = $_SERVER['REMOTE_ADDR'];

$dsid = $_SESSION['user_data']['id'];

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

try {
    // Check if mail or discord ID is already in use
    $stmt = $conn->prepare("SELECT * FROM users WHERE dsid = :dsid OR mail = :dmail");
    $stmt->bindParam(':dsid', $dsid);
    $stmt->bindParam(':dmail', $dsmail);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        die("This mail/discord is already in use. Please choose another.");
    }

    // Check if the user has already registered based on IP
    $stmt = $conn->prepare("SELECT * FROM users WHERE ip = :ip");
    $stmt->bindParam(':ip', $ip);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        die("You already registered.");
    }

    // Check if form data is complete
    if (!isset($_POST['password']) || !isset($_POST['re_password'])) {
        die("Form data incomplete.");
    }

    // Validate and hash password
    $pass = validate($_POST['password']);
    $re_pass = validate($_POST['re_password']);

    if ($pass !== $re_pass) {
        die("Passwords do not match.");
    }

    $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
    $length = 16;
    $id = mt_rand(100000000000000000, 999999999999999999);

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (id, password, dsid, mail, ip) VALUES (:id, :pass, :dsid, :mail, :ip)");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':pass', $hashed_password);
    $stmt->bindParam(':dsid', $dsid);
    $stmt->bindParam(':mail', $dsmail);
    $stmt->bindParam(':ip', $ip);
    $stmt->execute();

    $webhookUrl = $yaml_data['logs']['accounts']['token'] . "?thread_id=1209531443626119178";

    $embedData = [
        "embed" => [
            "title" => "created account",
            "description" => "ip: ``$ip``\nid: ``$id`` \nStatus:",
            "color" => hexdec("00b0f4"),
            "timestamp" => date('c')
        ]
    ];

    sendDiscordEmbed($webhookUrl, $embedData);

    $user = [
        'id' => $conn->lastInsertId(),
    ];

    if ($user) {
        http_response_code(200);
        $_SESSION['id'] = $id;
        echo "Request successful";
        return;
    }
} catch (PDOException $e) {
    // echo "An error occurred during registration. Please try again later.";
    // error_log("PDOException: " . $e->getMessage(), 0);
    // exit();
}
?>
