<?
require_once 'header.html';
require_once "functions.php";
?>


<div class="container">
    <div class="row gx-5">
        <div class="col">
        </div>
        <div class="col">
        

            <form action="db.php" method="POST">
                <div class="mb-5">
                    <label for="addr" class="form-label">Введите адрес товара</label>
                    <textarea class="form-control" name="adress" id="addr" rows="2"></textarea>
                </div>
                <button name="addr_submit" value="Отправить" type="submit" class="btn btn-primary mb-3">Отправить</button>
            </form>
        </div>
        <div class="col">
        
        </div>
    </div>
    </div>



<? require_once 'footer.html' ?>