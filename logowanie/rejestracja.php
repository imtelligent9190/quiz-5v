<?php
include_once '../db/connect.php';
session_start();
unset($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="I
    E=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            width: 100%;
            height: 100%;
        }
        form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            height: auto;
            width: 400px;
            text-align: center;
        }
        form .input{
            margin: 5px 0px;
            border: none;
            border-bottom: 2px solid;
            width: 200px;
        }

    </style>
</head>
<body>
    <form action="procesreg.php" method="post">
        <h1>Rejestracja</h1>
        <p>Login: <input class="input" type="text" name="login"></p>
        <p>Haslo: <input class="input" type="text" name="haslo"></p>
        <p>Klasa: <input class="input" list='name-quiz' name="klasa" autocomplete="off" required="required"></p>
 
        <p>Grupa: <input class="input" type="number" min='1' max='2' value='1'name="grupa"></p>
        <p>Imie: <input class="input" type="text" name="imie"></p>
        <p>Nazwisko: <input class="input" type="text" name="nazwisko"></p>
        <?php
            if(isset($_SESSION['bladreg'])){
                echo "<p style='color: red;'>".$_SESSION['bladreg']."</p>";
                unset($_SESSION['bladreg']);
            }
        ?>
        <input type="submit" name='submit' value="Register">
    </form>
    <datalist id="name-quiz">
      <?php
    $sql="SELECT * FROM klasa";
    $rezultat=$mysqli->query($sql);
    while($row=$rezultat->fetch_assoc()){
        echo "<option value='".$row['klasa']."'>";
    }
    ?>
  </datalist>
</body>
</html>
 