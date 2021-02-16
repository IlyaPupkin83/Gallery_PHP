<?php

session_start();

// Соединяемся с БД
include "include/config.php";

if (isset($_POST['signup_btn'])) {
	$err = [];
	// проверяем логин
	if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['username'])) {
		$err[] = "Логин может состоять только из букв английского алфавита и цифр";
	}
	if (strlen($_POST['username']) < 3 or strlen($_POST['username']) > 30) {
		$err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
	}
	// проверяем, не существует ли пользователя с таким именем
	$query = mysqli_query($conn, "SELECT user_id FROM users WHERE user_login='" . mysqli_real_escape_string($conn, $_POST['username']) . "'");
	if (mysqli_num_rows($query) > 0) {
		$err[] = "Пользователь с таким логином уже существует";
	}
	// Если нет ошибок, то добавляем в БД нового пользователя
	if (count($err) == 0) {
		$login = $_POST['username'];
		// Убираем лишние пробелы и делаем двойное хэширование
		$password = md5(md5(trim($_POST['password'])));
		mysqli_query($conn, "INSERT INTO users SET user_login='" . $login . "', user_password='" . $password . "'");
		header("Location: login.php");
		exit();
	} else {
		print "<b>При регистрации произошли следующие ошибки:</b><br>";
		foreach ($err as $error) {
			print $error . "<br>";
		}
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

	<title>Регистрация</title>

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
								<li class="active"><a href="./register.php">Регистрация</a></li>
								<li><a href="./login.php"><span class="glyphicon glyphicon-log-in"></span> Вход</a></li>
								<li><a href="./index.php">На главную</a></li>
							</ul>
						</nav>
					</div>
				</div>


				<?php
				include "include/messages.php";
				?>
				<form method="post" action="register.php" class="form-horizontal">
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">E-mail:</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
						</div>
					</div>
					<div class="form-group">
						<label for="inputName" class="col-sm-2 control-label">Логин:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputName" name="username" placeholder="Логин">
						</div>
					</div>
					<div class="form-group">
						<label for="password1" class="col-sm-2 control-label">Пароль:</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
						</div>
					</div>
					<div class="form-group">
						<label for="password2" class="col-sm-2 control-label">Повторите пароль</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="password2" name="password2" placeholder="Повторите пароль">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button name="signup_btn" type="submit" class="btn btn-default">Регистрация</button>
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