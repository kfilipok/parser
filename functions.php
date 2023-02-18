<?
require_once 'config.php';
// Соединямся с БД
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$link = mysqli_connect(HOST, USER, PASS, BD);
mysqli_set_charset($link, "utf8");

//Функция из ссылки вайлдберриз на товар получает id товара
function GetIdByAddr($adresString){
    $addrArr = explode('/', $adresString);
    return $addrArr[4];
}
//Функция из ссылки получает маркетплейс
function GetMarketplace($adresString){
    $addrArr = explode('/', $adresString);
    return $addrArr[2];
}
//Функция из id товара получает ссылку на вайлюерриз с товаром, Wlink - ссылка для парсинга, она неизменна
function GetObjById($pwid){
    $result = file_get_contents(WLINK . $pwid);
    $obj = json_decode($result);
    return $obj;
}
//Функция получает историю изменения цены товара (актуальная цена не учитывается)
//     [0] => Array
//         (
//             [date] => 07.08
//             [price] => 8607
//         )

//     [1] => Array
//         (
//             [date] => 14.08
//             [price] => 8547
//         )

//     [2] => Array
//         (
//             [date] => 21.08
//             [price] => 8230
//         )
//  и т.д.
function PriceHistory($art)
{

    for ($busketNum = 1; $busketNum < 10; $busketNum++) {
        $result = file_get_contents('https://basket-0' . $busketNum . '.wb.ru/vol' . substr($art, 0, -5) . '/part' . substr($art, 0, -3) . '/' . $art . '/info/price-history.json');
        if (!$result)
            continue;
        else
            break;
    }
    $obj = json_decode($result);
    // return $obj;
    foreach ($obj as $value) {
        // echo date("d-m-Y", $value->dt) . ' - ' . substr($value->price->RUB, 0, -2).'<br>';
        $temp['date'] = date("d.m.y", $value->dt);
        $temp['price'] = substr($value->price->RUB, 0, -2);
        $tempArr[] = $temp;
    }
    return $tempArr;
}
//Функция вычисляет среднюю цену товара по id (артикулу)
function AveragePrice($wid)
{
    //Получаем историю цен (цены на сегодня нет, ее получаем отдельно)
    $priceHistoryArr = PriceHistory($wid);
    //Получаем цену на сегодня:
    $obj = GetObjById($wid);
    $today['price'] = substr($obj->data->products[0]->salePriceU, 0, strlen($obj->data->products[0]->salePriceU) - 2);
    //Получаем сегодняшнюю дату
    $today['date'] = date("d.m.y");
    //Сохраняем текущую цену в архив истории цен
    $priceHistoryArr[] = $today;
    // echo ('<pre>');
// print_r($priceHistoryArr);
    foreach ($priceHistoryArr as $day) {
        $summPrice += $day['price'];
    }
    $average = $summPrice / count($priceHistoryArr);
    $average = intval(round($average, 0, PHP_ROUND_HALF_UP));
    return $average;
}
//// Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}
//Функция для получения данных пользователя из таблицы users
function get_userdata ($user_id, $link)
{
    $query = mysqli_query($link, "SELECT *,INET_NTOA(ip) AS ip FROM users WHERE id = '".$user_id."' LIMIT 1");
    $result = mysqli_fetch_assoc($query);
   // print"function is".var_dump($result)." \n";
    return $result;
}
