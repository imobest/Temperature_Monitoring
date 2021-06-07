<?php
$i=0; //zmienna dla osi X

require_once 'connect.php';
$rezultat = mysqli_query($polaczenie, "SELECT ids FROM sensors") or die ("Błąd zapytania do bazy: $dbname");
$rezultat = mysqli_query($polaczenie, "SELECT idt,temp, time FROM temperature WHERE ids=3 ORDER BY idt DESC LIMIT 10") or die ("Błąd zapytania do bazy: $dbname");	
while ($i<=$wiersz = mysqli_fetch_array ($rezultat)) 
		{ 	
			 $X1=$wiersz[1];
             $data=$wiersz[2];
             
			 //wartosci dla osi Y
             $dane[] = array($data,9-$i,$X1);	
			$i++;
		}			
require_once 'phplot.php';
$plot = new PHPlot(1200, 600);
$plot -> SetDataValues($dane);
$plot -> SetImageBorderType('plain');
$plot -> SetPlotType('lines');
$plot -> SetDataType('data-data');
# Tytuł głównego wykresu:
$plot -> SetTitle('Dane');
$plot -> setYLabel('Temperatura');
$plot -> setXLabel('Czas');

$plot -> SetPlotAreaWorld(NULL, 0, NULL, NULL);
$plot -> DrawGraph();
?>