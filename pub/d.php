<?php
// error_reporting(E_ALL);
// ini_set('display_errors', true);

// $nagrada = 100; // Награда за 1 голос
// $conf['host'] = 'localhost'; // IP сервера (чаще всего это localhost)
// $conf['user'] = 'admin'; // Пользователь базы данных
// $conf['pass'] = ''; // Пароль к базе данных
// $conf['name'] = 't'; // Название базы данных
// $conf['table'] = 'users'; // Таблица, в которую будут начисляться деньги
// $money = 'money'; // Столбец, в который выдается награда
// $nikname = 'test'; // Столбец, в котором записываются ники игроков
// $topcraft_key = 'test'; // Set your secret key here
// $mctop_key = 'cdf152bff48782b673b0bc660be56929';
// $mcrate_key = '';
// // Validate username and token
// $top = $_GET['top'];


// if ($top == "mctop") {
//         // $nickname = $_GET['nickname'];
//         // $token = $_GET['token'];

//         // if($token == md5($nickname.$mctop_key)) {
//             $connect = mysqli_connect($conf['host'], $conf['user'], $conf['pass'], $conf['name']) or die('Failed to connect to database');
//             mysqli_select_db($connect, $conf['name']) or die('Failed to select database');
    
//             // Escape the username to prevent SQL injection
//             $sql_username = mysqli_real_escape_string($connect, $nickname);
    
//             // Update user's money
//             $query = "UPDATE {$conf['table']} SET $money = $money + $nagrada WHERE $nikname='{$sql_username}'";
//             $result = mysqli_query($connect, $query);
//             if($result) {
//                 echo 'OK';
//             } else {
//                 echo 'Failed to update user\'s money';
//             }
//             mysqli_close($connect);
//         // }else {
//         //     echo 'error';
//         // }
// }
// if ($top == "topccraft") {
//     if(isset($_GET['nickname']) && isset($_GET['token'])) {
//         $username = htmlspecialchars($_POST['username']); //Передает Имя проголосовавшего за проект
 
//         mysql_connect($conf['host'], $conf['user'], $conf['pass']) or die('error connect');
//         mysql_select_db($conf['name']) or die('error select');
        
//         if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) die("Bad login");
        
//         if ($_POST['signature'] != sha1($username.$timestamp.$conf['secretkey'])) die("hash mismatch");
//          $sql_username = strtolower($username);
//          mysql_query("UPDATE $table SET `balance`=`balance`+'$iconomy' WHERE `username`='$sql_username'") or die (mysql_error());
//          echo 'OK';
//          mysql_query($sql);
//     }
// }
phpinfo();
?>
