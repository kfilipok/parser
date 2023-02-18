<?
// require_once 'header.html';
require_once 'functions.php';
error_reporting(0);
?>

<?
// echo ('<pre>');

$query = mysqli_query($link, "SELECT * FROM `products` WHERE `uid`='" . $_COOKIE['id'] . "'");
while ($temp = mysqli_fetch_assoc($query)) {
    if ($temp['uid'] == $_COOKIE['id']) {
        $obj = GetObjById($temp['pwid']);
        // echo "<pre>";
        // print_r($obj);
        //Артикул товара (ай ди в системе вайлберриз)
        $data['wid'] = $temp['pwid'];
        //id товара в системе
        $data['id'] = $temp['id'];
        //Намиенование товара
        $data['name'] = $obj->data->products[0]->name;
        //Статус товара
        if ($temp['status'] == '1')
            $data['status'] = "<a class=\"btn  btn-outline-light \" href=db.php?action=untrack&id=".$temp['id'].">Отклчить слежение</a>";
        else 
            $data['status'] = "<a class=\"btn  btn-outline-light \" href=db.php?action=track&id=".$temp['id'].">Включить слежение</a>";
        //Кнопка удаления товара
        $data['del'] = "<a class=\"btn  btn-outline-light btn-danger\" href=db.php?action=del&id=".$temp['id'].">Удалить</a>";
        //График изменения цены
        $data['graph'] = "<a class=\"btn  btn-outline-light \" target=\"_blank\" href=graph.php?wid=".$temp['pwid']."&brand=".urlencode($obj->data->products[0]->brand)."&name=".urlencode($obj->data->products[0]->name).">График цены</a>";
        //Фирма товара
        $data['brand'] = $obj->data->products[0]->brand;
        //Реальная цена товара
        $data['salePrice'] = substr($obj->data->products[0]->salePriceU, 0, strlen($obj->data->products[0]->salePriceU) - 2);
        //Самая низкая цена товара за всю историю
        // $data['lowestPrise'] = substr($obj->data->products[0]->averagePrice, 0, strlen($obj->data->products[0]->averagePrice) - 2);
        $data['lowestPrise'] = AveragePrice($temp['pwid']);
        //Отслеживаемая цена
        $data['alertPrise'] = $temp['alert_price'];
        //Ссылка на вайлдберриз
        $data['link'] = 'https://www.wildberries.ru/catalog/'.$temp['pwid'].'/detail.aspx';

        $products[] = $data;
    }
}
// echo '<pre>';
// print_r($data);
function ShowCard(array $arr){
    echo "
        <hr>
        <h5>" . $arr['name'] . "</h5>
        <p>                     
                                <strong>Цена до скидок:</strong> " . $arr['salePrice'] . "<br>
                                <strong>Средняя цена:</strong> " . $arr['lowestPrise'] . "<br>
                                <strong>Ваша цена:</strong> " . $arr['alertPrise'] . "<br>
                                <strong>Бренд:</strong> " . $arr['brand'] . "<br>
        </p>
        <a class=\"btn  btn-outline-light btn-secondary\" target=\"_blank\" href=\"" . $arr['link'] . "\">Перейти на WB</a>
        ".$arr['status']."  ".$arr['graph']."  ".$arr['del']." 
        <hr>
        ";
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


