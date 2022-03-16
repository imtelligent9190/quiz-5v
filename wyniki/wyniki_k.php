<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();
if( isset($_POST['id_sesji'])){
    $id_sesji=$_POST['id_sesji'];
    $_SESSION['wyniki_id_sesji']=$id_sesji;
}
if (isset($_POST['submit'])){
    $wyszukiwanie=$_POST['wyszukiwarka'];
    $sql="SELECT * FROM wyniki WHERE `id_sesji`='".$_SESSION['wyniki_id_sesji']."'";
    unset($_POST);
    $search=array();
    $index=0;
    $rezultat=$mysqli->query($sql);
    while($row=$rezultat->fetch_assoc()){
        $search[$row['id']]='szukane';
        $index++;
    }

}else{
    $sql="SELECT * FROM wyniki WHERE `id_sesji`='".$_SESSION['wyniki_id_sesji']."'";
    
}
$rezultat=$mysqli->query($sql);
if (isset($_POST['sprawdzenie'])){
    //bierze id quiz
    $select="SELECT * FROM kolejka WHERE id_sesji='".$_SESSION['wyniki_id_sesji']."'";
                $rezultat2=$mysqli->query($select);
                $wiersz=$rezultat2->fetch_assoc();
    // przypisuje wartosc post
    $point=$_POST['ile_punktów'];
    $info_o_uczniu=$_POST['info'];
    $pytanie_ot=$_POST['quest_text'];
    unset($_POST['sprawdzenie']);
    
    //bierze informacje o poprawnych ,złych i olgonych
    $select_wynik=$mysqli->query("SELECT * FROM wyniki WHERE `id_sesji`='".$_SESSION['wyniki_id_sesji']."' AND id_u='".$info_o_uczniu."'");
    $select_wyniki=$select_wynik->fetch_assoc();
    $zle_poprawa=unserialize($select_wyniki['niepoprawne']);
    print_r($zle_poprawa);
    for ($i=0; $i < sizeof($zle_poprawa); $i++) { 
        $selectquest="SELECT * FROM questions WHERE id_quiz='".$wiersz['id_quiz']."' AND QuestionNumber='".$zle_poprawa[$i][0]."'";
                $quest=$mysqli->query($selectquest);
                $questtext=$quest->fetch_assoc();
        if ($questtext['QuestionText']==$pytanie_ot){
            array_splice($zle_poprawa,$i,1);
            break;
        }
    }
    $zle=serialize($zle_poprawa);
    $poprawne=(int)$select_wyniki['poprawne']+$point;
    $total=(int)$select_wyniki['total_question']+1;
    $update=$mysqli->query("UPDATE wyniki SET niepoprawne='".$zle."', poprawne='".$poprawne."',total_question='".$total."' WHERE `id_sesji`='".$_SESSION['wyniki_id_sesji']."' AND id_u='".$info_o_uczniu."'");
    header("Location: wyniki_k.php");
    
    
    
}
$selectid="SELECT * FROM kolejka WHERE id_sesji='".$_SESSION['wyniki_id_sesji']."'";
                $rezultatid=$mysqli->query($selectid);
                $wierszid=$rezultatid->fetch_assoc();
$selectocen="SELECT * FROM quizy WHERE id='".$wierszid['id_quiz']."'";
    // echo $selectocen;
    $rezultocen=$mysqli->query($selectocen);
    $oceny=$rezultocen->fetch_assoc();
    // print_r ($oceny['zakres_ocen']);
    $ocenyy=unserialize($oceny['zakres_ocen']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>
        li input{
            position: relative;
            padding: 10px 0;
        }
        li{
            list-style:none;
            width: 400px
        }
        i{
            transition:0.6s;
            transform:rotate(0deg);
        }
        h1{
            cursor: default;
        }
        a{
            text-decoration: none;
            border: 1px solid black;
            border-radius: 10px;
            color: white;
            background: lightblue;
            color: black;
            text-align:center;
            
            padding: 2px 10px;
            margin: 1em auto;
        }
        a:hover{
            text-decoration: none;
            color: black;
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
    <div class='gora'><a href="../">back to menu</a></div>
    <script>
        var rotate = '0deg';
        $(document).ready(function(){
        $(".panel").hide();
        });
        $(document).ready(function(){
            $(".flip").click(function(){
                if (rotate=='0deg'){
                    rotate='180deg';
                    $(this).find('i').css('transform','rotate('+rotate+')');
                }else{
                    rotate='0deg';
                    $(this).find('i').css('transform','rotate('+rotate+')');
                    
                }

                $(this).next().find(".panel").slideToggle("slow");
            });
        });
    </script>

    <ul>

        
        <?php
        $ile=0;
            while($row=$rezultat->fetch_assoc()){

                $zle=unserialize($row['niepoprawne']);//zaciaganie niepoprawnych
                // print_r($zle);
                $procent=((int)$row['poprawne']/(int)$row['total_question'])*100;
                $procenty=round($procent,0);
                // echo $procenty;
                if ($procenty==100){
                    $ocena_aktualna=6;
                }else{
                    foreach ($ocenyy as $key => $value) {
                    if ($procenty<=$value){
                        
                        $ocena_aktualna=$key;
                        if ($ocena_aktualna==0 || $ocena_aktualna==1 ||$ocena_aktualna==2){
                            $ocena_aktualna+=2;
                        }
                        break;
                    }
                }
                }
                
                
                echo "<h1 class='flip'>".$row['imie_i_nazwisko']." <span style='color:lime;'>Correct: ".$row['poprawne']."</span> <span style='color:red;'>InCorrect: ".sizeof($zle)."</span> Mark: ".$ocena_aktualna." Start: ".$row['data_start']." End: ".$row['data_koniec']." <i class='fas fa-angle-down'></i><h1>";
                if(sizeof($zle)==0){continue;}
                
                $select="SELECT * FROM kolejka WHERE id_sesji='".$row['id_sesji']."'";
                $rezultat2=$mysqli->query($select);
                $wiersz=$rezultat2->fetch_assoc();


                
                for ($i=0; $i < sizeof($zle); $i++) {
                    $selectquest="SELECT * FROM questions WHERE id_quiz='".$wiersz['id_quiz']."' AND QuestionNumber='".$zle[$i][0]."'";
                // echo ($selectquest);
                $quest=$mysqli->query($selectquest);
                $questtext=$quest->fetch_assoc();
                    if (isset($zle[$i][2])){
                        echo "<div class='panel'><form method='post'><p>".$questtext['QuestionText']."<br><textarea disabled>".$zle[$i][1]."</textarea></br> <input name='ile_punktów' type='number'><input type='hidden' name='info' value='".$row['id_u']."'><input type='hidden' name='quest_text' value='".$questtext['QuestionText']."'><button type='submit' name='sprawdzenie'>save</button></form></p>";
                    }else{
                         echo "<div class='panel'><p>".$questtext['QuestionText']."
                            <ul>";
                        $selectchoice="SELECT * FROM choices WHERE id_quiz='".$wiersz['id_quiz']."' AND questionNumber='".$zle[$i][0]."'";
                        $choices=$mysqli->query($selectchoice);
                        while($choice=$choices->fetch_assoc()){
                            // echo gettype($zle[0][1])." || ".gettype($choice['choiceText']);
                            if ($zle[$i][1]==$choice['choiceText'] ){
                                echo"<li style='background-color:#EE0000; '><input type='radio' checked='true'  >".$choice['choiceText']."</li>";
                            }
                            elseif($choice['isCorrect']==1){
                                echo"<li style='background-color:lime; '><input type='radio' disabled >".$choice['choiceText']."</li>";
                            }
                            else{
                                echo"<li ><input type='radio' disabled>".$choice['choiceText']."</li>";
                            }
                            
                        }
                            echo"</ul></p>
                        </div>";
                    }
                
                   
                       
                } $ile++;
                    
            }
    
       ?>
    </ul>
</body>
</html>