<?php
include_once '../db/connect.php';
session_start();

?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <style>
        body{
            width:80%;
            margin-left: auto;
            margin-right: auto;
            border-bottom: 2px solid black;
        }
        form{
            display: grid;
            width:80%;
            margin-left: auto;
            margin-right: auto;
            padding-bottom:5px;
        }
        input["checkbox"]{
            display: block;
        }
        .grupa{
            display: block;
        }
        h1{
            width: 100%;
            border-bottom: 2px solid black;
            text-align: center;
            padding-bottom: 1em;
            padding-top: 1em;
        }
        input[type = "submit"]{
            border:none;
            border-bottom:2px solid lime;
            color: black;
            background-color:white;
            width:20%;
            margin-left: auto;
            margin-right: auto;
            font-size:20px;
        }
        input[type = "submit"]:hover{
            cursor:pointer;
            background-color:lightblue;
            transition: .5s;
        }
        .grupa{
            display:flex;
        }
    
    </style>
    <h1>Ustawianie QUIZZU</h1>
    <form method="post" action='process_set.php'>
        Wybierz nazwe quizu: <input list='name-quiz' name="name" autocomplete="off" required="required">
  <datalist id="name-quiz">
      <?php
    $sql="SELECT `name` FROM quizy WHERE id_n='".$_SESSION['user-id']."'";
    $rezultat=$mysqli->query($sql);
    while($row=$rezultat->fetch_assoc()){
        echo "<option value='".$row['name']."'>";
    }
    ?>
  </datalist>
  <?php
                if(isset($_SESSION['blad_set_nazwa'])){
                    echo '<br><span style="color:red;">'.$_SESSION['blad_set_nazwa']."</span><br>";
                    unset($_SESSION['blad_set_nazwa']);
                }else{
                    echo "<br>";
                }
            ?>
        Data-rozpoczęczia:<input type="datetime-local" name="datar" required="required"><br>
        Data-zakończenia:<input type="datetime-local" name="datak" required="required"><br>
        Klasa: <input class="input" list='klasy' name="klasa" autocomplete="off" required="required"><?php
                if(isset($_SESSION['blad_set_klasa'])){
                    echo '<br><span style="color:red;">'.$_SESSION['blad_set_klasa']."</span><br>";
                    unset($_SESSION['blad_set_klasa']);
                }else{
                    echo "<br>";
                }
            ?>
         
        <div class="grupa">grupa:
        <input type="checkbox" name="1" value="1" >1 <br>
        <input type="checkbox" name="2" value="2">2 
            </div>
            <?php
                if(isset($_SESSION['blad_set_grupa'])){
                    echo '<br><span style="color:red;">'.$_SESSION['blad_set_grupa']."</span><br>";
                    unset($_SESSION['blad_set_grupa']);
                }else{
                    echo "<br>";
                }
            ?>
        <input type="submit" value="Zaplanuj">
    </form></div>
</form>
<datalist id="klasy">
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