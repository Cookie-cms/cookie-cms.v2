<?php

function GetUserPermissions($userId, $conn) {
    $query = "SELECT gp.perm
              FROM groups_perms gp
              JOIN groups_users gu ON gp.idgroup = gu.idgroup
              WHERE gu.iduser = :userId";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $permissions = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $permissions;
}

function GetProfilePermissions($profileId, $conn) {
    $query = "SELECT up.perm
              FROM users_perms up
              WHERE up.iduser = :userId";  // Corrected line

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $profileId, PDO::PARAM_INT);
    $stmt->execute();

    $permissions = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $permissions;
}