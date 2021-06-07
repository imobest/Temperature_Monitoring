<?php
session_start();
require_once 'connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sensors - Lenz</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400" rel="stylesheet">
</head>
<body>
<div class="przesun">
<p><a href="http://jakublenz.pl/projekt/wykres1.php" target="_blank">Sensor1</a></p>   
<p><a href="http://jakublenz.pl/projekt/wykres2.php" target="_blank">Sensor2</a></p>
<p><a href="http://jakublenz.pl/projekt/wykres3.php" target="_blank">Sensor3</a></p>   
<p><a href="http://jakublenz.pl/projekt/wykres4.php" target="_blank">Sensor4</a></p>   
<p><a href="http://jakublenz.pl/projekt/wykres5.php" target="_blank">Sensor5</a></p>  
<p><a href="http://jakublenz.pl/projekt/wykreswszystkie.php" target="_blank">Suma</a></p> 
<p><a href="http://jakublenz.pl/projekt/index.php" target="">Powrót</a></p>  
</div>        
<div class="container">
	<table>
		<thead>
			<tr>
				<th>Nr sensora</th>
				<th>Nazwa</th>
				<th>Adres</th>
				<th>Data aktualizacji</th>
			</tr>
		</thead>
		<tbody>
            <?php
                $q = mysqli_query($polaczenie, "SELECT * FROM sensors");
                if (mysqli_num_rows($q) >= 1) {
                    while ($wiersz = mysqli_fetch_array($q)) {
                        $ids = $wiersz[0];
                        $name = $wiersz[1];                        
                        $address = $wiersz[2];
                        $date = $wiersz[3];                        
                        print "<tr>
                        <td>$ids</td>
                        <td>$name</td>
                        <td>$address</td>
                        <td>$date</td>
                    </tr>";
                    }
                }
            ?>
		</tbody>
    </table>

    <table>
		<thead>
			<tr>
				<th>Średnia temperatura ostatniego pomiaru z każdego czujnika</th>
			</tr>
		</thead>
		<tbody>
            <?php
                $q = mysqli_query($polaczenie, "SELECT idt, ROUND(AVG(temp),2) as avg_temp FROM (SELECT idt, temp FROM temperature ORDER BY idt DESC LIMIT 5) as cos");
                if (mysqli_num_rows($q) >= 1) {
                    while ($wiersz = mysqli_fetch_array($q)) {
                        $srednia = $wiersz[1];                       
                        print "<tr>
                        <td>$srednia</td>
                    </tr>";
                    }
                }
            ?>
		</tbody>
    </table>
    
</div>
</body>
</html>