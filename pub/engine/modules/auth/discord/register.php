<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
include __CM__ . "inc/mysql.php";
require __CM__ . "inc/webhook.php";
require_once __CI__ . "yamlReader.php";

require __CM__ . "mail/sendmail.php";
require __CM__ . "mail/gencode.php";
$file_path = __CM__ . 'configs/config.inc.yaml';
$yaml_data = read_yaml($file_path);

$mail = $yaml_data['basic']['registerTypes']['basic'];
$AccountsPerIP = $yaml_data['basic']['registerTypes']['AccountsPerIP'];
$logschat = $yaml_data['logs']['accounts'];
if (isset($_SESSION['user_data']['email'])) {
    $dsmail = $_SESSION['user_data']['email'];
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
        header('Content-Type: application/json');
        $responseData = array(
            'error' => true,
            'msg' => 'This mail/discord is already in use. Please choose another.'
        );
        die(json_encode($responseData, JSON_PRETTY_PRINT));
    }

    // Check if the user has already registered based on IP
    $stmt = $conn->prepare("SELECT * FROM users WHERE ip = :ip");
    $stmt->bindParam(':ip', $ip);
    $stmt->execute();

    if ($stmt->rowCount() > (int)$AccountsPerIP) {
        header('Content-Type: application/json');
        $responseData = array(
            'error' => true,
            'msg' => 'You already registered.'
        );
        die(json_encode($responseData, JSON_PRETTY_PRINT));
    }

    // Check if form data is complete
    if (!isset($_POST['password']) || !isset($_POST['re_password'])) {
        header('Content-Type: application/json');
        $responseData = array(
            'error' => true,
            'msg' => 'Form data incomplete.'
        );
        die(json_encode($responseData, JSON_PRETTY_PRINT));

    }

    // Validate and hash password
    $pass = validate($_POST['password']);
    $re_pass = validate($_POST['re_password']);

    if ($pass !== $re_pass) {
        header('Content-Type: application/json');
        $responseData = array(
            'error' => true,
            'msg' => 'Passwords do not match.'
        );
        die(json_encode($responseData, JSON_PRETTY_PRINT));
    }

    $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
    $length = 16;
    $id = mt_rand(000000000000000000, 999999999999999999);

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (id, password, dsid, mail, ip) VALUES (:id, :pass, :dsid, :mail, :ip)");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':pass', $hashed_password);
    $stmt->bindParam(':dsid', $dsid);
    $stmt->bindParam(':mail', $dsmail);
    $stmt->bindParam(':ip', $ip);
    $stmt->execute();
    if ($dsmail) {
        $email = $dsmail;
        $username = $_SESSION['user_data']['username'];
        // function send welcome email
        // function send verification email
        $date = time();
        // welcomemsg($email, $id, $date, $username);
        $code = generatecode($id);
        // echo $code;
        verificationmsg($email, $username, $code, $id);

    }   
    $webhookUrl = $yaml_data['logs']['accounts']['token'];

    $embedData = [
        "embed" => [
            "title" => "created account",
            "description" => "ip: ``$ip``\nid: ``$id`` \nStatus:",
            "color" => hexdec("00b0f4"),
            "timestamp" => date('c')
        ]
    ];

    sendDiscordEmbed($webhookUrl, $embedData);

    if ($user) {
        http_response_code(200);
        $_SESSION['id'] = $id;
        header('Content-Type: application/json');
        $responseData = array(
            'error' => false,
            'msg' => 'success'
        );

        return(json_encode($responseData, JSON_PRETTY_PRINT));
    }
} catch (PDOException $e) {
    // echo "An error occurred during registration. Please try again later.";
    // error_log("PDOException: " . $e->getMessage(), 0);
    // exit();
}
?>
