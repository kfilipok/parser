<a href="index.php">На главную</a>
<?
if (isset($_COOKIE['id']) and isset ($_COOKIE['hash']))
{
	setcookie ("id", "", time() - 3600);
	setcookie ("hash", "", time() - 3600);
	header("HTTP/1.1 301 Moved Permanently");
	// header("Location: http://".$_SERVER['SERVER_NAME']."".$_SERVER['REQUEST_URI']);
    // header("Location: index.php");
	exit();
}

