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
<?
require_once 'functions.php';

$sucessMessage = '        
<section class="page-section" id="contact">
	<div class="container">
		<!-- Contact Section Heading-->
		<br><h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Пароль изменен</h2>
		<!-- Icon Divider-->
		<div class="divider-custom">
			<div class="divider-custom-line"></div>
			<div class="divider-custom-icon"><i class="fas fa-star"></i></div>
			<div class="divider-custom-line"></div>
		</div>
	</div>
	<div class="row justify-content-center">
	<div class="col-lg-8 col-xl-7">
	<a href="login.php" class="btn btn-success active" role="button" aria-pressed="true">Авторизоваться</a>
	</div>
	</div>
</section>
	';

if(isset($_POST['token'])){
	// echo "<pre>";
	// var_dump($_REQUEST);
	
	// Проверяем есть ли у нас в БД token, переданный в GET параметре
	$query = mysqli_query($link, "SELECT `token` from `restore` WHERE `id` = '".$_POST['id']."'");
	$rows = (mysqli_num_rows($query));
	// echo "<br>".$rows."<br>";
	$checked = false;
	for ($i = 0; $i < $rows; $i++) { 
		$tokens = mysqli_fetch_row($query);
		// Проверяем совпадает ли токен, переданный в параметре ссылки и токен из БД
		if($tokens[0] == $_POST['token']) $checked = true;
	}
	// Если совпадает, то... 
	if($checked){
		// Обновляем БД, указываем, что эта запись была использована (is_used = 1)
		$query = mysqli_query($link, "UPDATE restore SET `is_used` = '1' WHERE `id` = '".$_POST['id']."'");
		// ОБновляем пароль(сначала его шифруем как в register.php далее обновляем в БД)
        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['password'])));
        mysqli_query($link, "UPDATE `users` SET `password` = '".$password."' WHERE `id` = '".$_POST['id']."'");
		echo $sucessMessage;
	}
}
?>
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