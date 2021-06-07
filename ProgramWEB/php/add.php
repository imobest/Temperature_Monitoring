<?php
require_once 'connect.php';


$temp = $_GET['temp'];
$adres = $_GET['adres'];

if ($temp && $adres) {
    // sprawdzamy czy nasz sensor jest w bazie
    $q="SELECT ids from sensors where address='$adres'";
    $resp = $polaczenie->query($q)or die("nie działa $q");

    if($resp->num_rows==0){
        // nie ma go więc go dodajemy :)
        $q = "INSERT INTO sensors(address,name,lastupdate) values('$adres','nowy',NOW())";
        $resp = $polaczenie->query($q)or die("nie działa $q");
    }else{
        // jest, więc updatujemy czas
        $q = "UPDATE sensors SET lastupdate=NOW() where address='$adres'";
        $resp = $polaczenie->query($q)or die("nie działa $q");
    }
    // dodajemy pomiar do rejestru przypisany do naszego sensora
    $q = "INSERT INTO temperature(temp,ids) values('$temp',(
        SELECT ids from sensors where address='$adres'
    ))";
    $polaczenie->query($q) or die("nie działa $q");


}

