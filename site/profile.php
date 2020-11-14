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
            <?php  session_start(); if (isset($_COOKIE['user'])): ?>
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
        <div class="ml-auto mr-auto mt-4"style="padding: 0 15px;">
            <?php
            if (isset($_SESSION['okp'])) {
                echo 'Файл загружен!';
                unset($_SESSION['okp']);
            }?>
            <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($_FILES['upfile']['error'] == 0){
                    $tmpName = $_FILES['upfile']['tmp_name'];

                    if($_FILES['upfile']['type'] == 'application/vnd.ms-excel'){
                        if(move_uploaded_file($tmpName, 'uploads/cvs/'.$_FILES['upfile']['name'])){
                            $_SESSION['okp'] = 'true';

                            $filename = $_FILES['upfile']['name'];
                            $username = $_COOKIE['user'];

                            $path = 'uploads/cvs/';

                            $mysql = new mysqli('a0481790.xsph.ru', 'a0481790_mail', 'kj19sj3n', 'a0481790_mail');

                            $result = $mysql->query("SELECT id FROM `main` WHERE `name` = '$username'");
                            $user_array = $result->fetch_assoc();
                            $user_id = $user_array['id'];
                            $mysql->close();

                            $mysql = new mysqli('a0481790.xsph.ru', 'a0481790_mail', 'kj19sj3n', 'a0481790_mail');
                            $mysql->query("INSERT INTO `tables` (`name` , `path` , `user_id`)
								VALUES ('$filename','$path','$user_id') ");
                            $mysql->close();
                            header('Location: /profile.php');
                        }else{
                            echo 'Не удалось загрузить файл!';
                        }
                    }
                    else{
                        if(move_uploaded_file($tmpName, 'uploads/xls/'.$_FILES['upfile']['name'])){
                            $_SESSION['okp'] = 'true';

                            $filename = $_FILES['upfile']['name'];
                            $username = $_COOKIE['user'];

                            $path = 'uploads/xls/';

                            $mysql = new mysqli('a0481790.xsph.ru', 'a0481790_mail', 'kj19sj3n', 'a0481790_mail');

                            $result = $mysql->query("SELECT id FROM `main` WHERE `name` = '$username'");
                            $user_array = $result->fetch_assoc();
                            $user_id = $user_array['id'];
                            $mysql->close();

                            $mysql = new mysqli('a0481790.xsph.ru', 'a0481790_mail', 'kj19sj3n', 'a0481790_mail');
                            $mysql->query("INSERT INTO `tables` (`name` , `path` , `user_id`)
								VALUES ('$filename','$path','$user_id') ");
                            $mysql->close();
                            header('Location: /profile.php');
                        }else{
                            echo 'Не удалось загрузить файл!';
                        }
                    }
                }
                else{
                    echo 'Ошибка загрузки! Код: '.$_FILES['upfile']['error'];
                }
            }



            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group d-inline-block float-left mr-4">
                    <input type="file" name="upfile" class="form-control-file prof-load">
                </div>
                <button class="lolp btn btn-success d-inline-block float-left">Загрузить</button>
            </form>
        </div>
        <div class="prof-pag">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Файл</th>
                    <th scope="col">Статус</th>
                    <th scope="col" class="text-center">Ссылка</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $mysql = new mysqli('a0481790.xsph.ru', 'a0481790_mail', 'kj19sj3n', 'a0481790_mail');
                $usr_id = $_COOKIE['id'];

                $result = $mysql->query("SELECT * FROM `tables` WHERE `user_id` = $usr_id");

                while($files = $result->fetch_assoc()){
                    ?>
                    <tr>
                        <td width="60%"><?php echo $files['name'] ?></td>
                        <td width="25%">
                            <?php
                            if($files['status'] == 0){echo 'В очереди';}
                            if($files['status'] == 1){echo 'Обрабатывается';}
                            if($files['status'] == 2){echo 'Готов';}
                            ?>
                        </td>
                        <td width="15%" class="text-center">
                            <?php
                            if($files['status'] == 2 )
                            {?>

                                <a href ="<?php
                            $loh = substr($files['name'],strlen($files['name']) - 4);
                            if ($loh == 'xlsx')
                                echo $files['path'].'done'.substr($files['name'], 0,strlen($files['name']) - 4).'csv';
                            else
                                echo $files['path'].'done'.$files['name'];
                            ?>"><?php echo 'Скачать';?></a><?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>

</body>
</html>
