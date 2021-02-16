<?php

session_start();

include "include/checklogin.php";
print "Привет, " . $userdata['user_login'] . ". Добро пожаловать!";

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="">
	<meta name="author" content="">

	<title>Галерея изображений</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<link href="css/cover.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

</head>

<body>

	<div class="site-wrapper">

		<div class="site-wrapper-inner">

			<div class="cover-container">

				<div class="masthead clearfix">
					<div class="inner">
						<nav>
							<ul class="nav masthead-nav">
								<li class="active"><a href="./index2.php">На главную</a></li>
								<li><a href="./gallery.php">Галерея</a></li>
								<li><a href="./logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbspВыйти</a></li>
							</ul>
						</nav>
					</div>
				</div>

				<?php
				include "include/messages.php";
				?>

				<div class="inner cover">
					<h1 class="cover-heading">Галерея изображений</h1>
					<p class="lead">Поделись своими изображениями с окружающими</p>
				</div>

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