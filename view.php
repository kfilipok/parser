<?
require_once 'header.html';
require_once 'functions.php';

// echo ('<pre>');

$query = mysqli_query($link, "SELECT * FROM `products` WHERE `uid`='" . $Uid . "'");
while ($temp = mysqli_fetch_assoc($query)) {
    if ($temp['uid'] == $Uid) {
        $obj = GetObjById($temp['pwid'], $Wlink);
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
        //Ссылка на вайлдберриз
        $data['link'] = 'https://www.wildberries.ru/catalog/'.$temp['pwid'].'/detail.aspx';

        $products[] = $data;
    }
}
function ShowCard(array $arr){
    echo "<div class=\"card\" >
      <img src=\"...\" class=\"card-img-top\" alt=\"...\">
      <div class=\"card-body\">
        <h5 class=\"card-title\">" . $arr['name'] . "</h5>
        <p class=\"card-text\"><strong>Реальная цена:</strong> " . $arr['salePrice'] . "<br>
                                <strong>Минимальная цена:</strong> " . $arr['lowestPrise'] . "<br>
                                <strong>Бренд:</strong> " . $arr['brand'] . "<br>
        </p>
        <a href=\"" . $arr['link'] . "\" class=\"btn btn-primary\">Перейти на WB</a>
      </div>
    </div>";
    }

?>

<div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
        <? foreach ($products as $value) ShowCard($value); ?>
    </div>
    <div class="col-sm-1">
    </div>
</div>
<?


