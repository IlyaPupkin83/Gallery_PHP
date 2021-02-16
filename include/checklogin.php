<?php

// Соединяемся с БД
include "config.php";

if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
	$query = mysqli_query($conn, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '" . intval($_COOKIE['id']) . "' LIMIT 1");
	$userdata = mysqli_fetch_assoc($query);

	if (($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])) {
		setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
		setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/", null, null, true);
		print "Что-то пошло не так...";
	}
} else {
	print "Включите куки в настройках вашего браузера";
}
