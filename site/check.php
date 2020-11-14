<?php
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);


if (mb_strlen($login) < 5 || mb_strlen($login) > 10) {
    echo "Недопустимая длина логина(от 5 до 10 символов)";
    exit();
} elseif (mb_strlen($name) < 2 || mb_strlen($name) > 15) {
    echo "Недопустимая длина имени(от 2 до 10 символов)";
    exit();
} elseif (mb_strlen($pass) < 6 || mb_strlen($pass) > 20) {
    echo "Недопустимая длина пароля (от 6 до 20 символов)";
    exit();
}

$pass = md5($pass . 'qweeqwweqweqweewq1123');
$mysql = new mysqli('a0481790.xsph.ru', 'a0481790_mail', 'kj19sj3n', 'a0481790_mail');
$mysql->query("INSERT INTO `main` (`login` , `pass` , `name`)
VALUES('$login','$pass','$name') ");
$mysql->close();

header('Location:/login.php');
