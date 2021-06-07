<?php
session_start();
// przypisanie danych z formularza do zmiennych
$user = $_POST['user']; 
$pass = $_POST['pass']; 
setcookie('nick', $user);
require_once 'connect.php';
$result = mysqli_query($polaczenie, "SELECT * FROM users WHERE user='$user'"); // pobranie z BD wiersza, w którym login=login z formularza
$rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
if (!$rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
{
    mysqli_close($polaczenie); // zamknięcie połączenia z BD
    $_SESSION['resp'] =  "Login lub hasło są nie poprawne"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
} else { // Jeśli $rekord istnieje
    if ($rekord['pass'] == $pass) {
        setcookie('user', $_POST['user'], time() + (86400 * 30));
        $_SESSION['user']=$user;
        header("Location: http://www.jakublenz.pl/projekt/index.php");
    } else {
        mysqli_close($polaczenie);
        $_SESSION['resp'] =  "Login lub hasło są nie poprawne"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
    }
}
// jeśli błędne hasło to pzekieruj do logowania
echo "<script>window.location = 'http://www.jakublenz.pl/projekt/zaloguj.php' </script>";
