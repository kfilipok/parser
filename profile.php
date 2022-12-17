<?
require_once 'functions.php';

$query = mysqli_query($link, "SELECT email FROM users WHERE id = '". $_COOKIE['id'] ."'");
$email = mysqli_fetch_assoc($query)['email'];

$goodsInTracking =  $goodsAdded = 0;
$query = mysqli_query($link, "SELECT status FROM products WHERE uid = '" . $_COOKIE['id'] . "'");
while ($temp = mysqli_fetch_assoc($query)) {
    if ($temp['status'] == 1) {
        $goodsInTracking++;
        $goodsAdded++;
    }else
        $goodsAdded++;
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
                <a class="navbar-brand" href="#page-top">bcost.ru</a>
                <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        
                        <!-- <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">Просмотр</a></li> -->
                        <?
                        if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
                            echo"<li class=\"nav-item mx-0 mx-lg-1\"><a class=\"nav-link py-3 px-0 px-lg-3 rounded\" href=\"index.php\">Главная</a></li>";
                            
                        }else{
                            echo"<li class=\"nav-item mx-0 mx-lg-1\"><a class=\"nav-link py-3 px-0 px-lg-3 rounded\" href=\"register.php\">Регистрация</a></li>";
                            echo"<li class=\"nav-item mx-0 mx-lg-1\"><a class=\"nav-link py-3 px-0 px-lg-3 rounded\" href=\"login.php\">Войти</a></li>";
                        }
                        ?>  
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Register Section-->
        <section class="page-section" id="contact">
            <div class="container">
                <!-- Contact Section Heading-->
                <br><h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Профиль</h2>
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
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Email:</strong> <? echo $email ?></li>
                            <li class="list-group-item"><strong>Уровень профиля:</strong> в разработке</li>
                            <li class="list-group-item"><strong>Товаров добавлено:</strong> <? echo $goodsAdded ?></li>
                            <li class="list-group-item"><strong>Товаров отслеживается:</strong> <? echo $goodsInTracking ?></li>
                            <a href="logout.php" class="btn btn-danger active" role="button" aria-pressed="true">Выйти</a>
                        </ul>
                        
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











