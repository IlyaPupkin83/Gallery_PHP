<?php

session_start();

// Функция для генерации случайной строки
function generateCode($length = 6)
{
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
	$code = "";
	$clen = strlen($chars) - 1;
	while (strlen($code) < $length) {
		$code .= $chars[mt_rand(0, $clen)];
	}
	return $code;
}

if (isset($_POST['login_btn'])) {
	include "include/config.php";
	// Получаем из БД запись, у которой логин равняется введенному
	$query = mysqli_query($conn, "SELECT user_id, user_password FROM users WHERE user_login='" . mysqli_real_escape_string($conn, $_POST['username']) . "' LIMIT 1");
	$data = mysqli_fetch_assoc($query);
	// Сравниваем пароли
	if ($data['user_password'] === md5(md5($_POST['password']))) {
		// Генерируем случайное число и шифруем его
		$hash = md5(generateCode(10));

		if (!empty($_POST['not_attach_ip'])) {
			// Если пользователь выбрал привязку к IP
			// Переводим IP в строку
			$insip = ", user_ip=INET_ATON('" . $_SERVER['REMOTE_ADDR'] . "')";
		}
		// Записываем в БД новый хеш авторизации и IP
		mysqli_query($conn, "UPDATE users SET user_hash='" . $hash . "' " . $insip . " WHERE user_id='" . $data['user_id'] . "'");
		// Ставим куки
		setcookie("id", $data['user_id'], time() + 60 * 60 * 24 * 30, "/");
		setcookie("hash", $hash, time() + 60 * 60 * 24 * 30, "/", null, null, true);

		//Записываем в переменные сессии
		$_SESSION['message'] = 'Вы вошли';
		$_SESSION['login'] = true;
		$_SESSION['username'] = $username;

		// Переадресовываем браузер на страницу проверки нашего скрипта
		header("Location: include/checklogin.php");
		header('Location: index2.php');
		exit();
	} else {
		print "Вы ввели неправильный логин/пароль";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="">
	<meta name="author" content="">

	<title>Вход</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<link href="css/cover.css" rel="stylesheet">

</head>

<body>

	<div class="site-wrapper">

		<div class="site-wrapper-inner">

			<div class="cover-container">

				<div class="masthead clearfix">
					<div class="inner">

						<nav>
							<ul class="nav masthead-nav">
								<li class="active"><a href="./login.php">Вход</a></li>
								<li><a href="./index.php">На главную</a></li>
								<li><a href="./register.php">Регистрация</a></li>
							</ul>
						</nav>
					</div>
				</div>

				<?php
				include "include/messages.php";
				?>



				<form method="post" action="login.php" class="form-horizontal">
					<div class="form-group">
						<label for="inputName" class="col-sm-2 control-label">Логин: </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputName" name="username" placeholder="Логин">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Пароль: </label>
						<div class="col-sm-10">
							<input type="password" name="password" class="form-control" id="inputPassword" placeholder="Пароль">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button name="login_btn" type="submit" class="btn btn-default">Войти</button>
						</div>
					</div>
				</form>
				<div class="mastfoot">
					<div class="inner">

						<p>IMG gallery</p>
					</div>
				</div>
			</div>
		</div>

	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

</body>

</html>