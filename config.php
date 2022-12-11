<?
//BD
define("HOST", "localhost");
define("USER","root");
define("PASS","");
define("BD","spy");

$Uid = 111; //Янын ID пока не сделал многопользовательскую
//Разница между минимальной ценой из истории товара и настоящей ценой, при которой придет оповещение
define("BEST_PRICE", "1000");
//Ссылка парсинг карточки товара
define ("WLINK", "https://card.wb.ru/cards/detail?spp=0&regions=80,64,83,4,38,33,70,82,69,68,86,75,30,40,48,1,22,66,31,71&pricemarginCoeff=1.0&reg=0&appType=1&emp=0&locale=ru&lang=ru&curr=rub&couponsGeo=2,12,3,18,15,21,101&dest=-1029256,-51490,-1703097,123585791&nm=");