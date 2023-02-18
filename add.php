<?
require_once "functions.php";

if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
    $disabled = "";
    $placeholder = "placeholder=\"Вставьте ссылку на товар вида: https://www.wildberries.ru/catalog/9379669/detail.aspx\"";
} else {
    $disabled = 'disabled';
    $placeholder = "placeholder=\"Отслеживание доступно только зарегистрированным пользователям\" ";
}
?>

<div class="container">
    <div class="row gx-5">
        <div class="col">
        </div>
        <div class="col-8">
        

            <form action="addhandler.php" method="POST">
                <div class="mb-5">
                    <label for="addr" class="form-label">Введите адрес товара или его артикул</label>
                    <textarea <? echo $disabled ?> <? echo $placeholder ?> class="form-control" name="adress" id="addr" rows="2"   required></textarea>
                </div>
                <button <? echo $disabled ?> name="addr_submit" value="Отправить" type="submit" class="btn btn-primary mb-3">Отправить</button>
            </form>
        </div>
        <div class="col">
        
        </div>
    </div>
    </div>