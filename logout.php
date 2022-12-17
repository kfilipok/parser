<?
// if (isset($_COOKIE['id']) and isset ($_COOKIE['hash']))
// {
	setcookie ("id", "", time() - 7000000);
	setcookie ("hash", "", time() - 7000000);
	header("HTTP/1.1 301 Moved Permanently");
	header("Refresh:0");
	header("Location: http://".$_SERVER['SERVER_NAME']."".$_SERVER['REQUEST_URI']);
    // header("Location: index.php");
	exit();
// }

