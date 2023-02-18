<?
require_once 'functions.php';

$query = mysqli_query($link, "SELECT * FROM `products` WHERE `status` = '1'");
while ($temp = mysqli_fetch_assoc($query)) {
    //Проверяем сайт по ай ди товара
    $obj = GetObjById($temp['pwid']);
    //сохраняем ай ди порльзователя
    $userId = $temp['uid'];
    //Цена, последний раз полученная на сайте вайлдберриз
    // $lastPrice = $temp['last_price'];
    //Отслеживаемая цена
    $data['alertPrice'] = $temp['alert_price'];
    //цена товара в данный момент
    $data['salePrice'] = substr($obj->data->products[0]->salePriceU, 0, strlen($obj->data->products[0]->salePriceU) - 2);
    //Бренд
    $data['brand'] = $obj->data->products[0]->brand;
    //Средняя ценна (примерно равна цене с личной скидкой)
    //$data['averagePrice'] = substr($obj->data->products[0]->averagePrice, 0, strlen($obj->data->products[0]->salePriceU) - 2);

    //Если цена товара изменилась
    // var_dump($data['salePrice']);
 
    // var_dump($temp['last_price']);
    // echo '<br>';
    if($data['salePrice'] != $temp['last_price']){
        //Если примерная цена товара  приблизилась к отслеживаемой цене ближе чем на BEST_PRICE, собираем данные в массив $product
        //или примерная цена товара стала ниже или равна отслеживаемой цене, собираем данные в массив $product
       // if ($data['averagePrice'] - $data['alertPrice'] <= BEST_PRICE || $data['averagePrice'] <= $data['alertPrice']) {
            $data['alertType'] = 'minAveragePrice';
            $data['lastPrice'] = $temp['last_price'];
            $data['name'] = $obj->data->products[0]->name;
            $data['link'] = 'https://www.wildberries.ru/catalog/'.$temp['pwid'].'/detail.aspx';
            $data['graph'] = 'http://bcost.ru/graph.php?wid=' . $temp['pwid'] . '&brand=' . $data['brand'] . '&name='. urlencode($data['name']);
            $product[$userId][] = $data;
        //}
        
        // //Если 
        // if () {
        //     $data['alertType'] = 'minAlertPrice';
        //     $data['name'] = $obj->data->products[0]->name;
        //     $data['link'] = 'https://www.wildberries.ru/catalog/'.$temp['pwid'].'/detail.aspx';
        //     $product[$userId][] = $data;
        // }
        //Сохраняем salePrice в БД для последующей корректировки
        mysqli_query($link, "UPDATE `products` SET `last_price` = '" . $data['salePrice'] . "', `tstamp` = '". date("Y-m-d H:i:s") ."' WHERE `id` = '" . $temp['id'] . "'");
    }

}
echo ('<pre>');
print_r($product);

if (!isset($product))
    die();
    
foreach ($product as $uId => $values) {
    $goods = '<hr>';
    foreach ($values as $data) {
        
        $goods .= '<a href='.$data['link'].'><strong>' . $data['name'] . '</strong></a><br>';
        $goods .= 'Брэнд: ' . $data['brand'] . '<br>';
        $goods .= '<strong>Стоимость (без скидок)</strong> - ' . $data['salePrice'] . ' руб.<br>';
        $goods .= 'Прежняя стоимость - ' . $data['lastPrice'] . ' руб.<br>';
        //$goods .= 'Средняя цена - '. $data['averagePrice'] . ' руб.<br>';
        $goods .= '<a href=' . $data['graph'] . '>График изменения цены</a><br><hr>';

        print_r($goods);
        
        $message = '
                    <html>
                    <head>
                    <title>Товары для покупки</title>
                    </head>
                    <body>
                    <p>Цены на следующие товары изменились</p>
                    '. $goods .'
                    </body>
                    </html>
                    ';
    }
    $to = get_userdata($uId, $link)['email'];
    $subject = 'Уведомление об изменении цен';
    // Для отправки HTML-письма должен быть установлен заголовок Content-type
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: Best Cost <bcost@noreply.ru>' . "\r\n";
    mail($to, $subject, $message,  $headers);
    sleep(1);
}
// $goods = '<hr>';
// foreach ($product as $key => $data) {
//     $goods .= '<a href='.$data['link'].'><strong>' . $data['name'] . '</strong></a><br>';
//     $goods .= '<strong>Стоимость (без скидок)</strong> - ' . $data['salePrice'] . ' руб.<br>';
//     $goods .= 'Средняя цена - '. $data['averagePrice'] . ' руб.<br>';
//     $goods .= '<a href='.$data['link'].'>Перейти и купить </a><br><hr>';
// }
// print_r($goods);
// $message = '
// <html>
// <head>
//   <title>Товары для покупки</title>
// </head>
// <body>
//   <p>Цены на следующие товары изменились</p>
//   '. $goods .'
// </body>
// </html>
// ';
// несколько получателей
// $to = 'kfilipenko@yandex.ru'; // обратите внимание на запятую

// тема письма
// $subject = 'Уведомление об изменении цен';
// // Для отправки HTML-письма должен быть установлен заголовок Content-type
// $headers  = 'MIME-Version: 1.0' . "\r\n";
// $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
// $headers .= 'From: Best Cost <bcost@noreply.ru>' . "\r\n";
// $headers[] = 'From: Best Price <bestprice@noreply.ru>';
// $headers[] = 'Cc: birthdayarchive@example.com';
// $headers[] = 'Bcc: birthdaycheck@example.com';

// mail($to, $subject, $message,  $headers);

//Ссылка для контроля товаров по низким ценам

//https://catalog.wb.ru/catalog/men_clothes1/catalog?appType=1&couponsGeo=2,12,3,18,15,21,101&curr=rub&dest=-1029256,-51490,-1703097,123585791&emp=0&kind=1&lang=ru&locale=ru&page=1&pricemarginCoeff=1.0&reg=0&regions=80,64,83,4,38,33,70,82,69,68,86,75,30,40,48,1,22,66,31,71&sort=priceup&spp=0&subject=11;147;216;2287;4575