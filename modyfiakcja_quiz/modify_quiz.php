<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();
if (isset($_POST['submit'])){
    $wyszukiwanie=$_POST['wyszukiwarka'];
    $sql="SELECT * FROM quizy WHERE `name` like '%$wyszukiwanie%' AND id_n='".$_SESSION['user-id']."' ";
    unset($_POST);
    $search=array();
    $index=0;
    $rezultat=$mysqli->query($sql);
    while($row=$rezultat->fetch_assoc()){
        $search[$row['id']]='szukane';
        $index++;
    }

}else{
    $sql="SELECT * FROM quizy WHERE id_n='".$_SESSION['user-id']."'";
    
}
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
        h1{
            width: 100%;
            border-bottom: 2px solid black;
            text-align: center;
            padding: 1em;
        }
        .gora{
            margin: 0 auto;
            width: 100%;
            text-align: center;
            padding: 2em;
        }
        .gora>a{
            text-decoration: none;
            border: 1px solid black;
            background-color: blue;
            border-radius: 10px;
            color: white;
            padding: 2px 10px;
        }
        
        table,tr,th,td{
            border: 2px solid #121221;
            transition: 0.5s;
        }
        th,td{
            width:150px;
            text-align:center;
        }
        .id{
            width:20px;
        }
        table{
            width: 80%;
            margin: 0 auto;
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
<script>
        var ile=0
        var zapisane=true;
        var aktualne=0;
        function change(id){
            var przycisk=document.getElementsByName(id);
            location.href="change_question.php?n="+id;
            
        }
        var pierwszy=0
        function deletee(id2){
            var przycisk2=document.getElementsByName(id2);
            var przyciski=document.getElementById(id2);
            przyciski.innerHTML="<button  onclick='deletee("+id2+")' type='button' name="+id2+" value='edit' style='background-color: lime; border: none; '><i class='fas fa-check'></i></button><button onclick='window.location.reload()' type='submit' name="+id2+" value='DELETE' style='background-color: red; border: none;'><i class='fas fa-times-circle'></i></button>"
            if (pierwszy==0){
                // przycisk2[0].style.display='none';
                // przycisk2[1].innerHTML='<i class="fas fa-check"></i>';
                pierwszy=1;
            }
            else if(pierwszy==1){
                
                // przycisk[1].setAttribute('name','delete');
                // przycisk[1].value=id2;
                location.href="delet_quiz.php?n="+id2;
                }
            
        }
        function cancle(id3){
            var przycisk3=document.getElementsByName(id3);
            console.log('cancle');
        }
    
    </script>
    <h1>Modyfikowanie QUIZZU</h1>
    <table>
        <div class="gora">
        <form method="post">
        <input name="wyszukiwarka" type="text">
        <input type="submit" name='submit'value='Szukaj'>
            <a type='submit' value='zapisz' href="../index.php">back to menu</a>
        </form>
                </div>
        <tr>
            <th class='id'>id</th>
            <th class='Login'>Nazwa</th>
            
        </tr>
        
    
        <?php
        $ile=1;
            while($row=$rezultat->fetch_assoc()){
                echo "<form method='post' action='change.php'><tr><td class='id'>".$ile."<input type='hidden' name='quiz_id' value='".$row['id']."'></td>
                <td><input class='".$row['id']."' name='login".$row['id']."' value='".$row['name']."'disabled></td>
                <td  class='Modyfikacja' id='".$row['id']."'><div ><button  onclick='change(".$row['id'].")' type='button' name=".$row['id']." value='edit' style='background-color: lightblue; border: none; '><i class='fas fa-pen' ></i></button></form>
                <button onclick='deletee(".$row['id'].")' type='button' name=".$row['id']." value='DELETE' style='background-color: red; border: none;'><i class='fas fa-trash-alt'></i></button><div></td></tr>";
                $ile++;
            }

        ?>
        
    
    </table>
</body>
</html>