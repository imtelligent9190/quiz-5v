<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();

    $sql="SELECT * FROM `kolejka` 
    INNER JOIN quizy on quizy.id= kolejka.id_quiz
    WHERE quizy.id_n='".$_SESSION['user-id']."' ORDER BY id_sesji DESC";
    

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
    <script>
        var ile=0
        var zapisane=true;
        var aktualne=0;
        function change(id){
            var przycisk=document.getElementsByName(id);
            console.log(id)
            if (aktualne==0){
                aktualne=id
            }
            if (zapisane==true && ile==0 ){
                ile=1;
                var pamiec=id
                var element=document.getElementsByClassName(id);
                for (let index = 0; index < element.length; index++) {
                        element[index].disabled=false;


                    
                }

                var przycisk=document.getElementsByName(id);
                przycisk[0].innerHTML='<i class="fas fa-save"></i>';
                przycisk[0].style.backgroundColor='lime';
                przycisk[1].style.display='none'
                zapisane=false; 
            }
            else if (aktualne==id && zapisane==false){
                var przycisk=document.getElementsByName(id);
                przycisk[0].type='submit';
                ile=0;
                aktualne=0
                przycisk[0].value=id;
                przycisk[0].setAttribute('name','edit');
                przycisk[0].formAction='change.php' 
                zapisane=true;
            }
            
        }
        var pierwszy=0
        function deletee(id2){
            var przycisk2=document.getElementsByName(id2);
            var przyciski=document.getElementById(id2);
            przyciski.innerHTML="<button  onclick='deletee("+id2+")' type='button' name="+id2+" value='edit' style='background-color: lime; border: none; '><i class='fas fa-check'></i></button><button onclick='window.location.reload()' type='submit' name="+id2+" value='DELETE' style='background-color: red; border: none;'><i class='fas fa-times-circle'></i></button>"
            if (pierwszy==0){
                pierwszy=1;
                alert("czy jesteś pewny usunięcia zaplanowanego quizu spowoduje to usuniecie wszystkich wyników zwiazanych z tym zaplanowanym quizem")
            }
            else if(pierwszy==1){
                location.href="delete.php?n="+id2;
                }
            
        }
        function cancle(id3){
            var przycisk3=document.getElementsByName(id3);
            console.log('cancle');
        }
    
    </script>
    
    <table>
        <tr>
            <th class='id'>id</th>
            <th class='Login'>Nazwa Quizu</th>
            <th class='Hasło'>Data_startu</th>
            <th class='klasa'>Data_końca</th>
            <th class='grupa'>klasa</th>
            <th class='Imie'>grupa<br>(3-obie grupy)</th>
            <th class='mod'>modyfikacja</th>
        </tr>
        
        <?php
        $ile=1;
            while($row=$rezultat->fetch_assoc()){
                echo "<form method='post' action='change.php'><tr><td class='id'>".$ile."<input type='hidden' name='id-s' value='".$row['id_sesji']."'</td>
                <td><input list='name-quiz' class='".$row['id_sesji']."' name='name".$row['id_sesji']."' value='".$row['name']."'disabled></td>
                <td><input  class='".$row['id_sesji']."' name='data-s".$row['id_sesji']."' value='".$row['data_start']."'disabled></td>
                <td><input class='".$row['id_sesji']."' name='data-k".$row['id_sesji']."' value='".$row['data_koniec']."'disabled></td>
                <td><input class='".$row['id_sesji']."' name='klasa".$row['id_sesji']."' value='".$row['klasa']."'disabled></td>
                <td><input type='number' class='".$row['id_sesji']."' name='grupa".$row['id_sesji']."' value='".$row['grupa']."'disabled min='1' max='3'></td>
                <td  class='Modyfikacja' id='".$row['id_sesji']."'><div ><button  onclick='change(".$row['id_sesji'].")' type='button' name=".$row['id_sesji']." value='edit' style='background-color: lightblue; border: none; '><i class='fas fa-pen' ></i></button></form>
                <button onclick='deletee(".$row['id_sesji'].")' type='button' name=".$row['id_sesji']." value='DELETE' style='background-color: red; border: none;'><i class='fas fa-trash-alt'></i></button><div></td></tr>";
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