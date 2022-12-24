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
                <br><h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Восстановление пароля</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>            
            <!-- Register Section Form-->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7">

<?
require_once 'functions.php';

if (isset($_POST['restore'])){
    $email = $_POST['email'];
    // Проверяем есть ли такой адрес электронной почты в базе, если есть, высылаем новый пароль
    $query = mysqli_query($link, "SELECT * from `users` WHERE `email` = '".$email."'");
    $user_data = mysqli_fetch_assoc($query);
    if(isset($user_data)) {
        // echo "На ваш email ". $user_data['user_login'] ." выслано письмо с новым паролем<br>";
        //Генерируем token
        $token = generateCode();
        // Пишем token в базу....
        //Если таблица еще не создана...
        $query = mysqli_query($link, "SELECT 1 FROM information_schema.tables WHERE table_schema = database() AND table_name = 'restore'");
        $table = mysqli_fetch_assoc($query);
        // Если таблица в БД еще не зоздана
        if(!isset($table)) {
            mysqli_query($link, "CREATE TABLE `restore` ( `token` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `id` INT NOT NULL , `is_used` INT NOT NULL , `date` DATE NOT NULL ) ENGINE = InnoDB;");
        }
        mysqli_query($link, "INSERT INTO restore SET `token` = '".$token."', `id` = '".$user_data['id']."', is_used = '0', date = '".date("Y-m-d")."'");
        // Подготовка и отсылка письма
        $message = "
                    <html>
                        <head>
                            <title>Восстановление пароля</title>
                        </head>
                    <body>
                    Кто-то пытается изменить пароль от вашего аккаунта  на bcost.ru.<br> 
                    Если это не вы, проигнорируйте это письмо<br> 
                    Для смены пароля пеерйдите по ссылке <br>
                   <a href=\"http://bcost.ru/restore.php?id=".$user_data['id']."&token=".$token."\">ССЫЛКА</a>
                    </body>
                    </html>";
            // Для отправки HTML-письма должен быть установлен заголовок Content-type
            $headers = 'From: Best Cost <bcost@noreply.ru>' . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        mail($_POST['email'], 'Восстановление пароля', $message, $headers);
        //Шифруем пароль для базы данных
        // $passmd5 = md5(md5(trim($pass));
        // обновляем базу новым паролем
        // mysqli_query($link, "UPDATE users SET `user_password` = '".$passmd5."' WHERE user_id = '".$user_data['user_id']."'");
        //Редиректим на страницу входа
        header("Location: login.php?ref=restore"); exit();
    }else echo "Данная электронная почта не зарегистрирована";
    // Отправляем письмо клиенту
    /*$message = "Вы запросили смену пароля. Ваш новый пароль ".$pass;
    mail($_POST['email'], 'Password recovery', $message);*/
    // echo "done<br> email". $_POST['email'];

}else if(isset($_GET['token'])){
    echo "                
                        <h3>Введите новый пароль</h3>
                        <form method=\"POST\" action = \"newpass.php\">
                            <div class=\"form-group\">
                                <label for=\"password\">Пароль</label>
                                <input type=\"password\" name=\"password\" class=\"form-control\" id=\"password\" aria-describedby=\"emailHelp\" placeholder=\"Введите пароль\">
                            </div>
                             <input type=\"hidden\" name=\"id\" value=\"".$_GET['id']."\">
                             <input type=\"hidden\" name=\"token\" value=\"".$_GET['token']."\">
                            <br><button name=\"submitpass\" type=\"submit\" class=\"btn btn-success\">Отправить новый пароль</button>
                        </form>";
} else echo "
                        <form method=\"POST\">
                            <div class=\"form-group\">
                                <label for=\"Emaill\">Введите адрес электронной почты, на нее будет выслан новый пароль</label>
                                <input type=\"email\" name=\"email\" class=\"form-control\" id=\"Emaill\" aria-describedby=\"emailHelp\" placeholder=\"Введите email\">
                            </div>
                            <br><button name=\"restore\" type=\"submit\" class=\"btn btn-success\">Отправить новый пароль</button>
                        </form>";
// Очищаем старые токены, которые не были использованы для смены пароля, срок очистки - сутки
// $query = mysqli_query($link, "DELETE FROM `restore` WHERE `is_used` = 0 AND `date` < '".date("Y-m-d")."'");
?>


                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- * * SB Forms Contact Form * *-->
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- This form is pre-integrated with SB Forms.-->
                        <!-- To make this form functional, sign up at-->
                        <!-- https://startbootstrap.com/solution/contact-forms-->
                        <!-- to get an API token!-->
                        <!-- <form method="POST">
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" name="email" class="form-control" id="Email1" aria-describedby="emailHelp" placeholder="Введите email">
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль</label>
                                <input type="password" name="password" class="form-control" id="password" aria-describedby="emailHelp" placeholder="Введите пароль">
                            </div>
                            <div class="form-group">
                                <br><button name="submit" type="submit" class="btn btn-success">Авторизоваться</button>
                                <a href="restore.php" class="btn btn-secondary active" role="button" aria-pressed="true">Восстановить пароль</a>
                            </div>
                        </form> -->
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