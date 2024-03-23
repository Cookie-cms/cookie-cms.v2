<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require __CM__ . "inc/mysql.php";

function getUserPermissions($userId, $accountId = 0, $conn) {
    // Получить разрешения, назначенные напрямую учетной записи пользователя
    // и разрешения, которые применяются ко всем учетным записям пользователя
    $query = "SELECT perm
              FROM users_perms
              WHERE iduser = :userId AND (account = :accountId OR account = 0)";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
    $stmt->bindParam(':accountId', $accountId, PDO::PARAM_INT);
    $stmt->execute();

    $accountPermissions = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Получить разрешения, назначенные группам, к которым принадлежит пользователь
    $query = "SELECT gp.permission
              FROM group_perms gp
              JOIN user_group ug ON gp.idgroup = ug.group_id
              WHERE ug.user_id = :userId";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
    $stmt->execute();

    $groupPermissions = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Объединить разрешения учетной записи и группы
    $permissions = array_merge($accountPermissions, $groupPermissions);

    return $permissions;
}

function getUserPermissionsByUUID($uuid, $conn) {
    // Получить id пользователя и id учетной записи по UUID профиля
    $query = "SELECT owner, id
              FROM users_profiles
              WHERE uuid = :uuid";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR);
    $stmt->execute();

    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($profile === false) {
        // Профиль не найден
        return false;
    }

    $userId = $profile['owner'];
    $accountId = $profile['id'];

    // Получить разрешения, назначенные напрямую учетной записи пользователя
    // и разрешения, которые применяются ко всем учетным записям пользователя
    $query = "SELECT perm
              FROM users_perms
              WHERE iduser = :userId AND (account = :accountId OR account = 0)";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
    $stmt->bindParam(':accountId', $accountId, PDO::PARAM_INT);
    $stmt->execute();

    $accountPermissions = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Получить разрешения, назначенные группам, к которым принадлежит пользователь
    $query = "SELECT gp.permission
              FROM group_perms gp
              JOIN user_group ug ON gp.idgroup = ug.group_id
              WHERE ug.user_id = :userId";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
    $stmt->execute();

    $groupPermissions = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Объединить разрешения учетной записи и группы
    $permissions = array_merge($accountPermissions, $groupPermissions);

    return $permissions;
}
