<?php
session_start();
require_once 'connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Temp - Lenz</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400" rel="stylesheet">
</head>
<body>
<p><a href="http://jakublenz.pl/projekt/sensors.php" target="" id="kierdosen">Sensory</a></p>   
<div class="container">

	<table>
		<thead>
			<tr>
				<th>Nr sensora</th>
				<th>Temperatura</th>
				<th>Data pomiaru</th>
				<th>Adres sensora</th>
			</tr>
		</thead>
		<tbody>
            <?php
                $q = mysqli_query($polaczenie, "SELECT temperature.ids, temp, temperature.time, sensors.address FROM
                 temperature INNER JOIN sensors ON temperature.ids = sensors.ids ORDER BY time DESC LIMIT 10");
                if (mysqli_num_rows($q) >= 1) {
                    while ($wiersz = mysqli_fetch_array($q)) {
                        $ids = $wiersz[0];
                        $temp = $wiersz[1];                        
                        $time = $wiersz[2];
                        $address = $wiersz[3];                        
                        print "<tr>
                        <td>$ids</td>
                        <td>$temp</td>
                        <td>$time</td>
                        <td>$address</td>
                    </tr>";
                    }
                }
            ?>
		</tbody>
    </table>
    
</div>
<p><a href="http://jakublenz.pl/projekt/logout.php" target="" id="wyloguj">Wyloguj</a></p> 
</body>
</html>