<?php

function getGroupPermissions($userID, $conn) {
    try {
        // Query to get user's group ID
        $userGroupQuery = "SELECT u.perms
                           FROM users u
                           WHERE u.id = :userID";

        $stmtUserGroup = $conn->prepare($userGroupQuery);
        $stmtUserGroup->bindParam(':userID', $userID, PDO::PARAM_STR);
        $stmtUserGroup->execute();

        if ($stmtUserGroup->rowCount() > 0) {
            // Fetch the user's group ID
            $userGroupID = $stmtUserGroup->fetch(PDO::FETCH_ASSOC)['perms'];

            // Query to get all permissions for the group
            $groupPermissionsQuery = "SELECT perm FROM groups_perms WHERE idgroup = :userGroupID";

            $stmtGroupPermissions = $conn->prepare($groupPermissionsQuery);
            $stmtGroupPermissions->bindParam(':userGroupID', $userGroupID, PDO::PARAM_INT);
            $stmtGroupPermissions->execute();

            if ($stmtGroupPermissions->rowCount() > 0) {
                // Fetch the group's permissions
                $groupPermissions = $stmtGroupPermissions->fetchAll(PDO::FETCH_COLUMN);

                return $groupPermissions;
            } else {
                return []; // Group permissions not found
            }
        } else {
            return false; // User not found
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?> 