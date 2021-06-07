<?
// utrata danych związanych z sesją i ciasteczkami
session_start();
session_unset();
session_destroy();
ob_start();
setcookie('user', $_POST['user'], time() - (864000 * 3000));
header("location: http://www.jakublenz.pl/projekt/zaloguj.php");

?>