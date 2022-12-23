<?
error_reporting(0);
//скрипт рисует график цены товара
require_once 'functions.php';

if (isset($_GET["wid"])) 
  $wid = $_GET['wid'];
//Получаем историю цен (цены на сегодня нет, ее получаем отдельно)
$tempArr = PriceHistory($wid);
//Получаем цену на сегодня:
$obj = GetObjById($wid);
$temp['price'] = substr($obj->data->products[0]->salePriceU, 0, strlen($obj->data->products[0]->salePriceU) - 2);
//Получаем сегодняшнюю дату
$temp['date'] = date("d.m.y");
//Сохраняем текущую цену в архив истории цен
$tempArr[] = $temp;
//Готовим данные на перевод в JS
$data = json_encode($tempArr);
?>

<!-- Подключаем JQuery и Chart.js -->
<script type="text/javascript" 
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" 
 src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>


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
                            echo"<li class=\"nav-item mx-0 mx-lg-1\"><a class=\"nav-link py-3 px-0 px-lg-3 rounded\" href=\"#\" onclick=\"closeWindow(); return false;\">Закрыть</a></li>";
                          //  echo "<a href=\"#\" onclick=\"closeWindow(); return false;\">Закрыть</a>";
                            
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
        <br><h2 class=" text-center text-secondary mb-0"><?echo $_GET['name'] ?></h2>
        </section>

<!-- Готовим контейнер для диаграммы -->
<div id="content" align="center">
 <canvas id="myChart" width="628" height="400"></canvas>
</div>


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

<script type="text/javascript">
// alert($.parseJSON('<?= $data ?>'));   
phpArr = $.parseJSON('<?= $data ?>'); 
 //Готовим диаграмму
 function Diagram () {
  var ctx = document.getElementById("myChart");
  var myChart = new Chart (ctx, {
   type: 'line',
   data: {
    labels: [], //Подписи оси x
    datasets: [
     {
      label: 'Цена', //Метка
      data: [], //Данные
      borderColor: 'blue', //Цвет
      borderWidth: 3, //Толщина линии
      fill: true, //Не заполнять под графиком
    //   backgroundColor: 'rgb(255, 99, 132)' // Цвет закраски
     }
     //Можно добавить другие графики
    ]
   },
   options: {
    responsive: false, //Вписывать в размер canvas
    scales: {
     xAxes: [{
      display: true
     }],
     yAxes: [{
      display: true
     }]
    }
   }
  });
  //Заполняем данными
  for (var x = 0; x< phpArr.length; x++) {
   myChart.data.labels.push(''+phpArr[x]['date']);
   myChart.data.datasets[0].data.push(phpArr[x]['price']);
  }
  //Обновляем
  myChart.update();

  function f(x) { //Вычисление нужной функции
   return Math.sin(x);
  }
 }

 //Ставим загрузку диаграммы на событие загрузки страницы
 window.addEventListener("load", Diagram); 

//Закрытие окна вкладки
 function closeWindow(){
	// if (confirm('Вы действительно хотите закрыть страницу?')) {
		window.close();
	// }
}
</script>

<noscript>
 <div align="center">
  Извините, для работы приложения нужен включённый Javascript
 </div>
</noscript>