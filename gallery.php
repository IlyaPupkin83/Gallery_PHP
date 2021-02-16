<?php

include "include/checklogin.php";

require 'config.php';

$errors = [];
$messages = [];

// Если файл был отправлен
if (!empty($_FILES)) {

	// Проходим в цикле по файлам
	for ($i = 0; $i < count($_FILES['files']['name']); $i++) {

		$fileName = $_FILES['files']['name'][$i];

		// Проверяем размер
		if ($_FILES['files']['size'][$i] > UPLOAD_MAX_SIZE) {
			$errors[] = 'Недопостимый размер файла ' . $fileName;
			continue;
		}

		// Проверяем формат
		if (!in_array($_FILES['files']['type'][$i], ALLOWED_TYPES)) {
			$errors[] = 'Недопустимый формат файла ' . $fileName;
			continue;
		}

		$filePath = UPLOAD_DIR . '/' . basename($fileName);

		// Пытаемся загрузить файл
		if (!move_uploaded_file($_FILES['files']['tmp_name'][$i], $filePath)) {
			$errors[] = 'Ошибка загрузки файла ' . $fileName;
			continue;
		}
	}

	if (empty($errors)) {
		$messages[] = 'Файлы были загружены';
	}
}

// Если файл был удален
if (!empty($_POST['name'])) {

	$filePath = UPLOAD_DIR . '/' . $_POST['name'];
	$commentPath = COMMENT_DIR . '/' . $_POST['name'] . '.txt';

	// Удаляем изображение
	unlink($filePath);

	// Удаляем файл комментариев, если он существует
	if (file_exists($commentPath)) {
		unlink($commentPath);
	}

	$messages[] = 'Файл был удален';
}

// Получаем список файлов, исключаем системные
$files = scandir(UPLOAD_DIR);
$files = array_filter($files, function ($file) {
	return !in_array($file, ['.', '..', '.gitkeep']);
});

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="">
	<meta name="author" content="">

	<title>Галерея изображений | Список файлов</title>

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
					<div class="inner container pt-4">
						<nav>
							<ul class="nav masthead-nav">
								<li><a href="./index2.php">На главную</a></li>
								<li class="active"><a href="./gallery.php">Галерея</a></li>
								<li><a href="./logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbspВыйти</a></li>
							</ul>
						</nav>
					</div>
				</div>
				<div class="container pt-4">
					<h1 class="mb-4"><a href="<?php echo URL; ?>">Галерея изображений</a></h1>

					<!-- Вывод сообщений об успехе/ошибке -->
					<?php foreach ($errors as $error) : ?>
						<div class="alert alert-danger"><?php echo $error; ?></div>
					<?php endforeach; ?>

					<?php foreach ($messages as $message) : ?>
						<div class="alert alert-success"><?php echo $message; ?></div>
					<?php endforeach; ?>

					<h2>Список файлов</h2>

					<!-- Вывод изображений -->
					<div class="mb-4">
						<?php if (!empty($files)) : ?>
							<div class="row">
								<?php foreach ($files as $file) : ?>

									<div class="col-12 col-sm-3 mb-4">
										<form method="post">
											<input type="hidden" name="name" value="<?php echo $file; ?>">
											<button type="submit" class="close" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</form>
										<a href="<?php echo URL . '/file2.php?name=' . $file; ?>" title="Просмотр полного изображения">
											<img src="<?php echo URL . '/' . UPLOAD_DIR . '/' . $file ?>" class="img-thumbnail" alt="<?php echo $file; ?>">
										</a>
									</div>

								<?php endforeach; ?>
							</div><!-- /.row -->
						<?php else : ?>
							<div class="alert alert-secondary">Нет загруженных изображений</div>
						<?php endif; ?>
					</div>
					<hr>
					<!-- Форма загрузки файлов -->
					<form method="post" enctype="multipart/form-data">
						<div class="custom-file">
							<input type="file" class="custom-file-input" name="files[]" id="customFile" multiple required>
							<label class="custom-file-label" for="customFile" data-browse="Выбрать">Выберите файлы</label>
							<small class="form-text text-muted">
								Максимальный размер файла: <?php echo UPLOAD_MAX_SIZE / 1000000; ?>Мб.
								Допустимые форматы: <?php echo implode(', ', ALLOWED_TYPES) ?>.
							</small>
							<hr>
						</div>
						<button type="submit" class="btn btn-primary">Загрузить</button>
					</form>
				</div><!-- /.container -->

			</div>
		</div>


		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input@1.3.4/dist/bs-custom-file-input.min.js"></script>
		<!-- LightBox -->
		<!--<script src="src/js/lightbox-plus-jquery.min.js"></script>-->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<script>
			$(() => {
				bsCustomFileInput.init();
			});
		</script>
</body>

</html>