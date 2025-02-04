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
session_start();

if (isset($_SESSION['user_data'])) {
    $user_data = $_SESSION['user_data'];

    // Вывод содержимого массива
    echo '<pre>';
    print_r($user_data);
    echo '</pre>';
} else {
    echo 'Ошибка: Нет данных о пользователе в сессии.';
}

$avatar_url = "https://cdn.discordapp.com/avatars/".$_SESSION['id']."/".$_SESSION['avatar'];

?>