<?
require_once 'functions.php';

if(isset($_POST['submit']))
{
    //Если таблица users еще не создана...
    $query = mysqli_query($link, "SELECT 1 FROM information_schema.tables WHERE table_schema = database() AND table_name = 'users'");
    $table = mysqli_fetch_assoc($query);
    // Если таблица в БД еще не зоздана
    if(!isset($table)) {
        mysqli_query($link, "CREATE TABLE `users` ( `id` INT NOT NULL AUTO_INCREMENT , `email` VARCHAR(230) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `password` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `hash` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL , `ip` INT(10) NULL DEFAULT NULL , `last_visit` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
     }
    //уходим от SQL injection
    $email = mysqli_real_escape_string($link, $_POST['email']);
    
    $err = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $err[] = "email адрес указан неверно";
    }
    // проверяем, не сущестует ли пользователя с таким email
    $query = mysqli_query($link, "SELECT id FROM users WHERE email='". $email ."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким email уже существует в базе данных";
    }
    if($_POST['password'] != $_POST['password_confirm']){
        $err[] = "Пароль не совпадает с подтверждением";
    }
    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {

        // $login = $_POST['login'];

        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['password'])));
       //присваеваем переменной должность
        // $position = $_POST['position'];
        //присваем переменной филиал работника
        // $level = $_POST['level'];
        //присваеваем переменной ФИО
        // $fio = $_POST['fio'];

        mysqli_query($link,"INSERT INTO users SET email='".$email."', password='".$password."'");
        header("Location: login.php"); exit();
    }
    else
    {
        ?>
        <div class="container-fluid">
        <div class="alert alert-dismissible alert-warning">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4 class="alert-heading">Внимание!</h4>
        <p class="mb-0">
            <?
                print "<b>При регистрации произошли следующие ошибки:</b><br>";
                foreach($err AS $error)
                {
                    print $error."<br>";
                }
            ?>
        </p>
        </div>
        </div>
        <?
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>bcost.ru</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">  
            <a class="navbar-brand" href="index.php">bcost.ru</a>
                <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <!-- <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#portfolio">Добавить</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">Просмотр</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#contact">Contact</a></li> -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Register Section-->
        <section class="page-section" id="contact">
            <div class="container">
                <!-- Contact Section Heading-->
                <br><h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Регистрация</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>            
            <!-- Register Section Form-->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7">
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- * * SB Forms Contact Form * *-->
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- This form is pre-integrated with SB Forms.-->
                        <!-- To make this form functional, sign up at-->
                        <!-- https://startbootstrap.com/solution/contact-forms-->
                        <!-- to get an API token!-->
                        <form method="POST">
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" name="email" class="form-control" id="Email1" aria-describedby="emailHelp" placeholder="Введите email">
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль</label>
                                <input type="password" name="password" class="form-control" id="password" aria-describedby="emailHelp" placeholder="Введите пароль">
                            </div>
                            <div class="form-group">
                                <label for="password_confirm">Подтвердите пароль</label>
                                <input type="password" name="password_confirm" class="form-control" id="password" aria-describedby="emailHelp" placeholder="Введите пароль">
                            </div>
                            <div class="form-group">
                                <br><button name="submit" type="submit" class="btn btn-success">Зарегистрироваться</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

                <!-- Bootstrap core JS-->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>