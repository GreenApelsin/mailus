<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,inital-sacle=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" />
    <title>SITEFLOW</title>
  </head>
  <body>	
  <div id="header">
		<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-primary"">
		  <a class="navbar-brand" href="index.php"><img src="img/logo.svg" alt="logo" /></a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
			  <li class="nav-item active"><a class="nav-link" href="index.php">Главная <span class="sr-only">(current)</span></a></li>
			  <?php if (isset($_COOKIE['user'])): ?>
			  <li class="nav-item"><a class="nav-link" href="profile.php">Нормализация</a></li>
			  <?php else:?>
			  <li class="nav-item"><a class="nav-link" href="reg.php">Регистрация</a></li>
			  <li class="nav-item"><a class="nav-link" href="login.php">Вход</a></li>
			  <?php endif;?>
			</ul>
		  </div>
		  <?php if (isset($_COOKIE['user'])): ?>
		  <form class="nav-toggler" action="exit.php" method="post">
		  <?=$_COOKIE['user']?>
          <button class="btn btn-success" type="submit">Выйти</button>
          </form>
		  <?php endif;?>
		</nav>
	</div>
	<br /><br /><br />
    <div class="conteiner mt-4">
    	<div class="row">
		<div class="col" style="max-width: 1200px;">
        		<h3 class="text-center">Сервис нормализации адресов</h3>
			<div class="text-justify" style="font-size:22px;">Наш сервис позволяет быстро и качественно проверить точность и достоверность каждого адреса и преобразовать к специализированному формату адресных баз данных представленных в виде файлов csv или xlsx. Это позволяет снизить риск ошибок в логистике, соответственно уменьшить срок доставки. Вы можете загрузить к нам на сайт свои документы в указанном формате и получите файлы с проверенными и актуальными данными в базах. После проверки можете быть уверены, что ваш груз будет доставлен по указанному вами адресу.</div>
			<hr>
			<h3 class="text-center">Инструкция по работе с сайтом</h3><img src="/img/info.png" style="width: 100%;">
		</div>
    	</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
  </body>
</html>
