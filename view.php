<?
// require_once 'header.html';
require_once 'functions.php';
?>

<?
// echo ('<pre>');

$query = mysqli_query($link, "SELECT * FROM `products` WHERE `uid`='" . $_COOKIE['id'] . "'");
while ($temp = mysqli_fetch_assoc($query)) {
    if ($temp['uid'] == $_COOKIE['id']) {
        $obj = GetObjById($temp['pwid']);
        //id товара в системе
        $data['id'] = $temp['id'];
        //Намиенование товара
        $data['name'] = $obj->data->products[0]->name;
        //Фирма товара
        $data['brand'] = $obj->data->products[0]->brand;
        //Реальная цена товара
        $data['salePrice'] = substr($obj->data->products[0]->salePriceU, 0, strlen($str) - 2);
        //Самая низкая цена товара за всю историю
        $data['lowestPrise'] = substr($obj->data->products[0]->averagePrice, 0, strlen($str) - 2);
        //Отслеживаемая цена
        $data['alertPrise'] = $temp['alert_price'];
        //Ссылка на вайлдберриз
        $data['link'] = 'https://www.wildberries.ru/catalog/'.$temp['pwid'].'/detail.aspx';

        $products[] = $data;
    }
}
function ShowCard(array $arr){
    echo "
        <hr>
        <h5>" . $arr['name'] . "</h5>
        <p><strong>Цена до скидок:</strong> " . $arr['salePrice'] . "<br>
                                <strong>Примерная цена:</strong> " . $arr['lowestPrise'] . "<br>
                                <strong>Приемлемая цена:</strong> " . $arr['alertPrise'] . "<br>
                                <strong>Бренд:</strong> " . $arr['brand'] . "<br>
        </p>
        <a class=\"btn btn-xl btn-outline-light\" target=\"_blank\" href=\"" . $arr['link'] . "\"><i class=\"fas fa-download me-2\"></i>
        Перейти на WB</a>
        <hr>";
    }

?>

<div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
        <?if(isset($products)) foreach ($products as $value) ShowCard($value);
         else
            echo ("Товары не добавлены");  
        ?>
    </div>
    <div class="col-sm-1">
    </div>
</div>
<?


