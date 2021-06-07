<?php
session_start();
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lenz</title>
    <!-- stylizacja formularza za pomocą boostrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ display: inline-block;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    width: 400px;
    height: 400px;
    margin: auto;}
    </style>
</head>
<body>
<!-- formularz logowania -->
    <div class="wrapper">
        <h2>Zaloguj się jako admin!</h2>
        <p>Podaj swoje dane logowania, aby się zalogować.</p>
        <form method="post" action = 'weryfikuj.php'>
            <div class="form-group">
                <label>Username</label>
                <!-- przekazanie ciasteczek do loginu -->
                <input type="text" name="user" class="form-control" value = '<?php echo $_COOKIE['nick'] ?>'>
                <span class="help-block"></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="pass" class="form-control">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="przycisk" value="Zaloguj">
            </div>
           <?php echo $_SESSION['resp']; ?>
        </form>
    </div>    
</body>
</html>