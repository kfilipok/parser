<? require_once 'header.html'?>


    <div class="container">
    <div class="row gx-5">
        <div class="col">
        <a href="add.php" class="btn btn-primary btn-lg " tabindex="-1" role="button" aria-disabled="true">Добавить товар в слежение</a>
        </div>
        <div class="col">
        <a href="delete.php" class="btn btn-primary btn-lg " tabindex="-1" role="button" aria-disabled="true">Удалить товар</a>
        </div>
        <div class="col">
        <a href="view.php" class="btn btn-primary btn-lg " tabindex="-1" role="button" aria-disabled="true">Посмотреть товары</a>
        </div>
    </div>
    </div>
   

<?
require_once 'footer.html';


// $result = file_get_contents('https://card.wb.ru/cards/detail?spp=0&regions=80,64,83,4,38,33,70,82,69,68,86,75,30,40,48,1,22,66,31,71&pricemarginCoeff=1.0&reg=0&appType=1&emp=0&locale=ru&lang=ru&curr=rub&couponsGeo=2,12,3,18,15,21,101&dest=-1029256,-51490,-1703097,123585791&nm='.$id);
// $obj = json_decode($result);

// //Наименование товара
// echo $obj->data->products[0]->name;
// echo '<br>';
// //Фирма товара
// echo $obj->data->products[0]->brand;
// echo '<br>';
// //Реальная цена товара
//  $obj->data->products[0]->salePriceU;

// echo $realPrice = substr($obj->data->products[0]->salePriceU, 0, strlen($str) - 2);
// echo '<br>';
// //Самая низкая цена товара
// echo $lowestPrise = substr($obj->data->products[0]->averagePrice, 0, strlen($str) - 2);
// echo '<br>';
// print_r($obj);

