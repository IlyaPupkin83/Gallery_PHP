<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "php_database";

// Соединяемся с БД
$conn = mysqli_connect($servername, $username, $password, $db);

// Проверка соединения
if (!$conn) {
	die("Не удалось соединиться: " . mysqli_connect_error());
}
