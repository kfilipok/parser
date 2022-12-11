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

//Функция из id товара получает ссылку на вайлюерриз с товаром
function GetObjById($pwid, $Wlink){
    $result = file_get_contents($Wlink . $pwid);
    $obj = json_decode($result);
    return $obj;
}
