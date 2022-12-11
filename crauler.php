<?
require_once 'functions.php';

$query = mysqli_query($link, "SELECT * FROM `products` WHERE `uid` = $Uid AND `status` = '1'");
while ($temp = mysqli_fetch_assoc($query)) {
    $obj = GetObjById($temp['pwid']);
    //Отслеживаемая цена
    $data['alertPrice'] = $temp['alert_price'];
    //цена товара в данный момент
    $data['salePrice'] = substr($obj->data->products[0]->salePriceU, 0, strlen($str) - 2);
    //Самая низкая цена за всю историю
    $data['lowestPrise'] = substr($obj->data->products[0]->averagePrice, 0, strlen($str) - 2);
    
    //Если цена товара приблизилась к минимальной цене ближе чем на BEST_PRICE
    if ($data['salePrice'] - $data['lowestPrise'] <= BEST_PRICE) {
        $data['alertType'] = 'minLowestPrice';
        $data['name'] = $obj->data->products[0]->name;
        $data['link'] = 'https://www.wildberries.ru/catalog/'.$temp['pwid'].'/detail.aspx';
        $product[] = $data;
    }
    //Если цена товара ниже или равна отслеживаемой цене
    if ($data['salePrice'] <= $data['alertPrice']) {
        $data['alertType'] = 'minAlertPrice';
        $data['name'] = $obj->data->products[0]->name;
        $data['link'] = 'https://www.wildberries.ru/catalog/'.$temp['pwid'].'/detail.aspx';
        $product[] = $data;
    }
}
echo ('<pre>');
print_r($product);

if (!isset($product))
    die();
$goods = '<hr>';
foreach ($product as $key => $data) {
    $goods .= '<a href='.$data['link'].'><strong>' . $data['name'] . '</strong></a><br>';
    $goods .= '<strong>Стоимость</strong> - ' . $data['salePrice'] . ' руб.<br>';
    $goods .= 'Перейти и купить <br><hr>';
}
print_r($goods);
$message = '
<html>
<head>
  <title>Товары для покупки</title>
</head>
<body>
  <p>Товары для покупки!</p>
  '. $goods .'
</body>
</html>
';
// несколько получателей
$to = 'yafilipenko$yandex.ru, kfilipenko@yandex.ru'; // обратите внимание на запятую

// тема письма
$subject = 'Покупка';
// Для отправки HTML-письма должен быть установлен заголовок Content-type
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// $headers[] = 'From: Best Price <bestprice@noreply.ru>';
// $headers[] = 'Cc: birthdayarchive@example.com';
// $headers[] = 'Bcc: birthdaycheck@example.com';

mail($to, $subject, $message,  $headers);

//Ссылка для контроля товаров по низким ценам

//https://catalog.wb.ru/catalog/men_clothes1/catalog?appType=1&couponsGeo=2,12,3,18,15,21,101&curr=rub&dest=-1029256,-51490,-1703097,123585791&emp=0&kind=1&lang=ru&locale=ru&page=1&pricemarginCoeff=1.0&reg=0&regions=80,64,83,4,38,33,70,82,69,68,86,75,30,40,48,1,22,66,31,71&sort=priceup&spp=0&subject=11;147;216;2287;4575