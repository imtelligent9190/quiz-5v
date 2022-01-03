<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();
if (isset($_POST['submit'])){
    $wyszukiwanie=$_POST['wyszukiwarka'];
    $sql="SELECT * FROM `kolejka` 
    INNER JOIN quizy on quizy.id= kolejka.id_quiz
    WHERE quizy.id_n='".$_SESSION['user-id']."' and kolejka.klasa like '%".$wyszukiwanie."%' OR kolejka.grupa like '%".$wyszukiwanie."%' ORDER BY id_sesji DESC";
    unset($_POST);
    $search=array();
    $index=0;
    $rezultat=$mysqli->query($sql);
    while($row=$rezultat->fetch_assoc()){
        $search[$row['id']]='szukane';
        $index++;
    }

}else{
    $sql="SELECT * FROM `kolejka` 
    INNER JOIN quizy on quizy.id= kolejka.id_quiz
    WHERE quizy.id_n='".$_SESSION['user-id']."' ORDER BY id_sesji DESC";
    
}
// echo $sql;
$rezultat=$mysqli->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>

        table,tr,th,td{
            border: 2px solid #121221;
            transition: 0.5s;
        }
        th,td{
            width:180px;
            text-align:center;
        }
        .id{
            width:20px;
        }
        table{
            margin: 0px;
            position: relative;
        }
        td input{
            text-align:center;
            width:100%;
            transition: 0.5s;
        }
        td button{
            margin:5px;
        }
        .Modyfikacja{
            width:20px;
           
        }
        div{
            display:inline-block;
        }
    </style>
</head>
<body>
    <form method="post">
        <input name="wyszukiwarka" type="text">
        <input type="submit" name='submit'value='Szukaj'>
        </form>
    <table>
        
        <tr>
            <th class='id'>id</th>
            <th class='Login'>Nazwa Quizu</th>
            <th class='Hasło'>Data_startu</th>
            <th class='klasa'>Data_końca</th>
            <th class='grupa'>klasa</th>
            <th class='Imie'>grupa<br>(3-obie grupy)</th>
            <th >ile_wyników</th>
            <th class='mod'>Sprawdź wyniki</th>
        </tr>
        
        <?php
        $ile=1;
            while($row=$rezultat->fetch_assoc()){
                echo "<form method='post' action='wyniki_k.php'><tr><td class='id'>".$ile."<input type='hidden' value='".$row['id_sesji']."'</td>
                <td><input value='".$row['name']."'disabled></td>
                <td><input value='".$row['data_start']."'disabled></td>
                <td><input value='".$row['data_koniec']."'disabled></td>
                <td><input value='".$row['klasa']."'disabled></td>
                <td><input type='number' value='".$row['grupa']."'disabled min='1' max='3'></td>";
                $select ="SELECT * FROM wyniki WHERE id_sesji='".$row['id_sesji']."'";
                $ilewynikow=$mysqli->query($select);
                $ilew=$ilewynikow->num_rows;
                echo "<td>$ilew</td>
                <td  class='Modyfikacja'><div ><button  onclick='change(".$row['id_sesji'].")' type='submit' ".$row['id_sesji']." name='id_sesji' value='".$row['id_sesji']."' style='background-color: lime; border: none; '><i class='far fa-list-alt'></i></button></form>
                <div></td></tr>";
                $ile++;
            }
    
       ?><datalist id="name-quiz"><?php
    $sql="SELECT `name` FROM quizy WHERE id_n='".$_SESSION['user-id']."'";
    $rezultat=$mysqli->query($sql);
    while($row=$rezultat->fetch_assoc()){
        echo "<option value='".$row['name']."'>";
    }?>
  </datalist> 
        <a type='submit' value='zapisz' href="../index.php">back to menu<a>
    
    </table>
</body>
</html>