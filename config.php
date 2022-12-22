<?
//BD
define("HOST", "localhost");
define("USER","root");
define("PASS","");
define("BD","spy");

https://catalog.wb.ru/catalog/men_shoes/catalog?appType=1&couponsGeo=2,12,3,18,15,21,101&curr=rub&dest=-1029256,-51490,-1703097,123585791&emp=0&f4=10124&kind=1&lang=ru&locale=ru&page=1&pricemarginCoeff=1.0&reg=0&regions=80,64,83,4,38,33,70,69,86,75,30,40,48,1,22,66,31,68,71&sort=newly&spp=0&subject=94;2956

$Uid = 111; //Янын ID пока не сделал многопользовательскую
//Разница между минимальной ценой из истории товара и настоящей ценой, при которой придет оповещение
define("BEST_PRICE", "1000");
//Ссылка парсинг карточки товара
define ("WLINK", "https://card.wb.ru/cards/detail?spp=0&regions=80,64,83,4,38,33,70,82,69,68,86,75,30,40,48,1,22,66,31,71&pricemarginCoeff=1.0&reg=0&appType=1&emp=0&locale=ru&lang=ru&curr=rub&couponsGeo=2,12,3,18,15,21,101&dest=-1029256,-51490,-1703097,123585791&nm=");