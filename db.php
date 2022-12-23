<?
require_once 'functions.php';
echo '<pre>';
print_r($_REQUEST);
//Добавление адреса для слежения
if(isset($_POST['addr_submit']) && $_POST['addr_submit'] == 'Отправить'){
    // $pwid = GetIdByAddr($_POST['adress']);
    $pwid = $_POST['wid'];
    // $marketPlace = GetMarketplace($_POST['adress']);
    $marketPlace = $_POST['marketplace'];
    //уходим от SQL injection
    $pwid = mysqli_real_escape_string($link, $pwid);
    $marketPlace = mysqli_real_escape_string($link, $marketPlace);
    $alertPrice = mysqli_real_escape_string($link, $_POST['alertPrice']);
    //Если таблица еще не создана...
    $query = mysqli_query($link, "SELECT 1 FROM information_schema.tables WHERE table_schema = database() AND table_name = 'products'");
    $table = mysqli_fetch_assoc($query);
    // Если таблица в БД еще не зоздана
    if(!isset($table)) {
        mysqli_query($link, "CREATE TABLE `products` ( `id` INT NOT NULL AUTO_INCREMENT , `marketplace` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `pwid` INT NOT NULL , `uid` INT NOT NULL , `status` INT NOT NULL , `alert_price` INT NOT NULL , `last_price` INT NOT NULL, `tstamp` TIMESTAMP NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    }
    //Проверка на наличие в базе данного товара
    $query = mysqli_query($link, "SELECT * FROM `products` WHERE pwid = '" . $pwid . "'");
    $pwdExists = false;
    $rows = mysqli_num_rows($query);
    if (mysqli_num_rows($query) > 0)
        $pwdExists = true;
    if (!$pwdExists) {
        mysqli_query($link, "INSERT INTO `products` (`marketplace`, `pwid`, `uid`, `status`, `alert_price`, `last_price`, `tstamp`) VALUES('" . $marketPlace . "', '" . $pwid . "', '" . $_COOKIE['id'] . "', '1', '" . $alertPrice . "', '0', '" . date("Y-m-d H:i:s") . "')");
        header('location: index.php');
    }else header('location: index.php?prod=exists');
//////Отключение слежения
}else if(isset($_GET['action']) && $_GET['action'] == 'untrack'){
    mysqli_query($link, "UPDATE `products` SET `status`='0'WHERE `id` = " . $_GET['id']);
    header('Location: index.php');
    //////Включение слежения
}else if(isset($_GET['action']) && $_GET['action'] == 'track'){
    mysqli_query($link, "UPDATE `products` SET `status`='1'WHERE `id` = " . $_GET['id']);
    header('Location: index.php');
///////////Удаление товара
}else if(isset($_GET['action']) && $_GET['action'] == 'del'){
    mysqli_query($link, "DELETE FROM `products` WHERE `id` = " . $_GET['id']);
    header('Location: index.php');
}
// 