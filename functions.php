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
