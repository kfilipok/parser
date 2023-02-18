<?
include 'functions.php';
// Скрипт проверки

// Соединямся с БД
//$link=mysqli_connect("localhost", "root", "root", "arm");

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
    //получаем данные пользователя
    $userdata = get_userdata($_COOKIE['id'], $link);
    //print"check is".var_dump($userdata)." \n";
    if(($userdata['hash'] !== $_COOKIE['hash']) or ($userdata['id'] !== $_COOKIE['id']))
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
        print "Хм, что-то не получилось";
    }
    else
    {
       // print "Привет, ".$userdata['user_login'].". Всё работает!<br>";
        header("Location: index.php"); exit();
    }
}
else
{
    print "Включите куки";
}