<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pl">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Wykresy</title>
</head>

<body>
     <img src="plot.php?i=10" alt="wykres">
     <input type="range" id="range"> 
     <script>
     
     const range = document.querySelector('#range');
     range.addEventListener('change',()=>{
          const img = document.querySelector('img');
          img.src=`plot.php?i=${range.value}`; 
          })
     </script>

</body>

</html>