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