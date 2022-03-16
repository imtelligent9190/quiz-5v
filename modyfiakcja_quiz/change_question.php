<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();
if (isset($_POST['submit'])){
    $wyszukiwanie=$_POST['wyszukiwarka'];
    $sql="SELECT * FROM question WHERE `name` like '%$wyszukiwanie%' AND id_n='".$_SESSION['user-id']."' ";
    unset($_POST);
    $search=array();
    $index=0;
    $rezultat=$mysqli->query($sql);
}else{
    $sql="SELECT * FROM questions WHERE id_quiz='".$_GET['n']."'";
    
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
        html{
            width:100%;
            height:100%;
        }
        body{
            margin-top:30px;
            width:80%;
            margin-left:auto;
            margin-right:auto;
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
        a{
            text-decoration: none;
            border: 1px solid black;
            border-radius: 10px;
            color: white;
            background: lightblue;
            color: black;
            text-align:center;
            margin-right:5px;
            margin-left:5px;
            padding: 2px 10px;
            margin-left:auto;
            margin-right:auto;
        }
        a:hover{
            text-decoration: none;
            color: black;
        }
         input{
            border:none;
            background:transparent;
        }
        .gora{
            margin: 0 auto;
            width: 100%;
            text-align: center;
            padding: 2em;
        }
    </style>
</head>
<body>
    <script>
        var ile=0
        var zapisane=true;
        var aktualne=0;
        function change(id){
            var przycisk=document.getElementById(id);
            console.log(id)
            console.log(zapisane)
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
        function deletee(id2,id_quiz){
            var przycisk2=document.getElementsByName(id2);
            var przyciski=document.getElementById(id2);
            przyciski.innerHTML="<button  onclick='deletee("+id2+","+id_quiz+")' type='button' name="+id2+" value='edit' style='background-color: lime; border: none; '><i class='fas fa-check'></i></button><button onclick='window.location.reload()' type='submit' name="+id2+" value='DELETE' style='background-color: red; border: none;'><i class='fas fa-times-circle'></i></button>"
            if (pierwszy==0){
                // przycisk2[0].style.display='none';
                // przycisk2[1].innerHTML='<i class="fas fa-check"></i>';
                pierwszy=1;
            }
            else if(pierwszy==1){
                
                // przycisk[1].setAttribute('name','delete');
                // przycisk[1].value=id2;
                location.href="delete_quest.php?n="+id2+"&id_quiz="+id_quiz;
                }
            
        }
        function cancle(id3){
            var przycisk3=document.getElementsByName(id3);
            console.log('cancle');
        }
    
    </script>
    
    <table>
        <tr>
            <th class='id'>question Number</th>
            <th class='Login'>question</th>
            <th class='Hasło'>Choice1</th>
            <th class='klasa'>Choice2</th>
            <th class='grupa'>Choice3</th>
            <th class='Imie'>Choice4</th>
            <th class='Nazwisko'>Choice5</th>
            <th class='uprawnienia'>Correct</th>
            <th class='Modyfikacja'>Modyfikacja</th>
        </tr>
        
    
        <?php
        $ile=1;
            while($row=$rezultat->fetch_assoc()){
                if($row['QuestionNumber']%2==0){
                    $color='lightgray';
                }else{
                    $color='white';
                }
                echo "<form method='post' action='save_change.php?n=".$_GET['n']."&quest_id=".$row['QuestionNumber']."'><tr style='background-color:".$color.";'><td class='id'>".$row['QuestionNumber']."</td>
                <td><input class='".$row['QuestionNumber']."' name='login".$row['QuestionNumber']."' value='".$row['QuestionText']."'disabled></td>";
                $sql2="SELECT * FROM choices WHERE id_quiz='".$_GET['n']."' AND     questionNumber='".$row['QuestionNumber']."'";
                $rezultat2=$mysqli->query($sql2);
                
                $totalcorrect=0;
                $ilechice=$rezultat2->num_rows;
                $ktory_quest=0;
                // echo $ilechice;
                while($row2=$rezultat2->fetch_assoc()){
                        echo "<td><input type='text' class='".$row['QuestionNumber']."' name='choice".$ktory_quest."' value='".$row2['choiceText']."'disabled></td>";
                        $ktory_quest++;
                    
                    
                    if ($row2['isCorrect']==1){
                        $totalcorrect++;
                        $correct=$totalcorrect;
                    }
                    else{
                        $totalcorrect++;
                    }
                }
                if ($ilechice!=0){
                   for ($i=0; $i < 5-$ilechice ; $i++) { 
                    $totalcorrect++;
                    echo "<td><input name='choice".$ktory_quest."' class='".$row['QuestionNumber']."' value='-' disabled></td>";
                    $ktory_quest++;
                }
                echo "<td><input class='".$row['QuestionNumber']."' name='corect' value='".$correct."' type='number' min='1' max='5' disabled></td>
                <td  class='Modyfikacja' id='".$row['QuestionNumber']."'><div ><button  onclick='change(".$row['QuestionNumber'].")' type='button' name=".$row['QuestionNumber']." value='edit' style='background-color: lightblue; border: none; '><i class='fas fa-pen' ></i></button></form>
                <button onclick='deletee(".$row['QuestionNumber'].",".$_GET['n'].")' type='button' name=".$row['QuestionNumber']." value='DELETE' style='background-color: red; border: none;'><i class='fas fa-trash-alt'></i></button><div></td></tr>";
                $ile++; 
                }
                else{
                    echo "<td colspan='6'><input value='pytanie otwarte' disabled></td><td  class='Modyfikacja' id='".$row['QuestionNumber']."'><div ><button  onclick='change(".$row['QuestionNumber'].")' type='button' name=".$row['QuestionNumber']." value='edit' style='background-color: lightblue; border: none; '><i class='fas fa-pen' ></i></button></form>
                    <button onclick='deletee(".$row['QuestionNumber'].",".$_GET['n'].")' type='button' id=".$row['QuestionNumber']." value='DELETE' style='background-color: red; border: none;'><i class='fas fa-trash-alt'></i></button><div></td></tr>";
                    $ile++; 
                }
                
            }
            echo "<form method='post' action='../pytania/dashboard.php'><tr><td class='id'>".$ile."</td><input type='hidden' name='id_quiz' value='".$_GET['n']."'><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                <td  class='Modyfikacja' ><div ><button ' type='submit'  style='background-color: lime; border: none; '><i class='fas fa-plus'></i></button></form></tr>";

        ?>
        <div class='gora'> <a type='submit' value='zapisz' href="modify_quiz.php">back to menu</a></div>
    
    </table>
</body>
</html>