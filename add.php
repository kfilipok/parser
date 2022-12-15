<?
// require_once 'header.html';
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
        

            <form action="db.php" method="POST">
                <div class="mb-5">
                    <label for="addr" class="form-label">Введите адрес товара</label>
                    <textarea <? echo $disabled ?> <? echo $placeholder ?> class="form-control" name="adress" id="addr" rows="2"   required></textarea>
                </div>
                <label for="alertPrice" class="form-label">Введите стоимость, при достижении которой вы получите уведомление</label>
                <div class="input-group mb-3">
                   
                    <input <? echo $disabled ?> type="number" class="form-control" name="alertPrice" aria-label="Amount (to the nearest dollar)" required>
                    <span class="input-group-text">руб.</span>
                </div>
                <button <? echo $disabled ?> name="addr_submit" value="Отправить" type="submit" class="btn btn-primary mb-3">Отправить</button>
            </form>
        </div>
        <div class="col">
        
        </div>
    </div>
    </div>



<? //require_once 'footer.html' ?>