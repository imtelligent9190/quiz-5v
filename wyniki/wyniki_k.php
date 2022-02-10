<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();
if( isset($_POST)){
    $id_sesji=$_POST['id_sesji'];
}
if (isset($_POST['submit'])){
    $wyszukiwanie=$_POST['wyszukiwarka'];
    $sql="SELECT * FROM wyniki WHERE `id_sesji`='".$id_sesji."'";
    unset($_POST);
    $search=array();
    $index=0;
    $rezultat=$mysqli->query($sql);
    while($row=$rezultat->fetch_assoc()){
        $search[$row['id']]='szukane';
        $index++;
    }

}else{
    $sql="SELECT * FROM wyniki WHERE `id_sesji`='".$id_sesji."'";
    
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
    </style>
</head>
<body>
    <a href="../">back to menu</a>
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
                
                echo "<h1 class='flip'>".$row['imie_i_nazwisko']." <span style='color:lime;'>Correct: ".$row['poprawne']."</span> <span style='color:red;'>InCorrect: ".sizeof($zle)."</span> Percent: ".round($procent,2)."% Start: ".$row['data_start']." End: ".$row['data_koniec']." <i class='fas fa-angle-down'></i><h1>";
                if(sizeof($zle)==0){continue;}
                
                $select="SELECT * FROM kolejka WHERE id_sesji='".$row['id_sesji']."'";
                $rezultat2=$mysqli->query($select);
                $wiersz=$rezultat2->fetch_assoc();


                
                for ($i=0; $i < sizeof($zle); $i++) { 
                $selectquest="SELECT * FROM questions WHERE id_quiz='".$wiersz['id_quiz']."' AND QuestionNumber='".$zle[$i][0]."'";
                // echo ($selectquest);
                $quest=$mysqli->query($selectquest);
                $questtext=$quest->fetch_assoc();
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
                       
                } $ile++;
                    
            }
    
       ?>
    </ul>
</body>
</html>