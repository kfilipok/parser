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

<!-- Готовим контейнер для диаграммы -->
<div id="content" align="center">
 <canvas id="myChart" width="628" height="400"></canvas>
</div>

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
</script>

<noscript>
 <div align="center">
  Извините, для работы приложения нужен включённый Javascript
 </div>
</noscript>