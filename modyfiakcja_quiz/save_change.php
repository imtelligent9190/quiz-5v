<?php
include_once '../db/connect.php';
session_start();
if (!isset($_POST)){
    header("Location: modify_quiz.php");
}
else{
    $id_pytanie=$_GET['quest_id'];
    $n=$_GET['n'];
    $selectquest="SELECT * FROM choices WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."'";
    $choice=$mysqli->query($selectquest);
    $ilerekordów=$choice->num_rows;
    $ile=0;
    print_r($_POST);
    if (sizeof($_POST)-3==$ilerekordów){
        //jezeli jest tyel samo pytan co w bazie 
        while($choiceszbaz=$choice->fetch_assoc()){
            if($choiceszbaz['choiceText']==$_POST['choice'.$ile]){
                //jezeli choicetext == temu co w bazie
                //sprawdzanie poprawnoych odp
                if ($ile+1==$_POST['corect']){
                    
                    if($choiceszbaz['isCorrect']==1){
                        
                    }
                    else{
                        $update="UPDATE choices SET isCorrect='1' WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."' AND  choiceText='".$choiceszbaz['choiceText']."'";
                        $update2=$mysqli->query($update) or die("nie udało się");
                        
                    }
                }
                else{
                    if($choiceszbaz['isCorrect']==1){
                        $update="UPDATE choices SET isCorrect='0' WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."' AND  choiceText='".$choiceszbaz['choiceText']."'";
                        $update2=$mysqli->query($update) or die("nie udało się");
                        
                    }
                    else{
                        
                    }
                }
            }
            else{
                // jeżeli się nie zgadza
                if($_POST['choice'.$ile]=='-' or $_POST['choice'.$ile]==''){
                   $delete="DELETE FROM choices WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."' AND  choiceText='".$choiceszbaz['choiceText']."'";
                   $delete2=$mysqli->query($delete) or die("nie udało się");
                }
                elseif ($_POST['choice'.$ile]!=$choiceszbaz['choiceText']) {
                    $update="UPDATE choices SET choiceText='".$_POST['choice'.$ile]."' WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."' AND  choiceText='".$choiceszbaz['choiceText']."'";
                    $update2=$mysqli->query($update);
                    if ($ile+1==$_POST['corect']){
                    
                        if($choiceszbaz['isCorrect']==1){
                            
                        }
                        else{
                            $update="UPDATE choices SET isCorrect='1' WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."' AND  choiceText='".$choiceszbaz['choiceText']."'";
                            $update2=$mysqli->query($update) or die("nie udało się");
                            
                        }
                    }
                    else{
                        if($choiceszbaz['isCorrect']==1){
                            $update="UPDATE choices SET isCorrect='0' WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."' AND  choiceText='".$choiceszbaz['choiceText']."'";
                            $update2=$mysqli->query($update) or die("nie udało się");
                            
                        }
                        else{
                            
                        }
                    }
                }
            }
            
            $ile++;
        }
        echo $ilerekordów;

    }
    else{
        while($choiceszbaz=$choice->fetch_assoc()){
            
            if($choiceszbaz['choiceText']==$_POST['choice'.$ile]){
                if ($ile+1==$_POST['corect']){
                    if($choiceszbaz['isCorrect']==1){
                        
                    }
                    else{
                        $update="UPDATE choices SET isCorrect='1' WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."' AND  choiceText='".$choiceszbaz['choiceText']."'";
                        $update2=$mysqli->query($update) or die("nie udało się");
                    }
                }
                else{
                    if($choiceszbaz['isCorrect']==1){
                        $update="UPDATE choices SET isCorrect='0' WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."' AND  choiceText='".$choiceszbaz['choiceText']."'";
                        $update2=$mysqli->query($update) or die("nie udało się");
                    }
                    else{
                        
                    }
                }
            }elseif ($_POST['choice'.$ile]!=$choiceszbaz['choiceText']) {
                $update="UPDATE choices SET choiceText='".$_POST['choice'.$ile]."' WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."' AND  choiceText='".$choiceszbaz['choiceText']."' ";
                $update2=$mysqli->query($update);
                if ($ile+1==$_POST['corect']){
                
                    if($choiceszbaz['isCorrect']==1){
                        
                    }
                    else{
                        $update="UPDATE choices SET isCorrect='1' WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."' AND  choiceText='".$choiceszbaz['choiceText']."'";
                        $update2=$mysqli->query($update) or die("nie udało się");
                        
                    }
                }
                else{
                    if($choiceszbaz['isCorrect']==1){
                        $update="UPDATE choices SET isCorrect='0' WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."' AND  choiceText='".$choiceszbaz['choiceText']."'";
                        $update2=$mysqli->query($update) or die("nie udało się");
                        
                    }
                    else{
                        
                    }
                }
            }
            else{
                if($_POST['choice'.$ile]=='-' or $_POST['choice'.$ile]==''){
                    $delete="DELETE FROM choices WHERE questionNumber='".$id_pytanie."' AND id_quiz='".$n."' AND  choiceText='".$choiceszbaz['choiceText']."'";
                    $delete2=$mysqli->query($delete) or die("nie udało się");
                 }
            }
            
            $ile++;
        }
        
        
        for ($i=0; $i < sizeof($_POST)-(3+$ilerekordów); $i++) {
            $il=(int)$i+(int)$ilerekordów;
            if ($_POST['choice'.$il]!='-'){
                $wybur=$_POST['choice'.$il];
                if ($_POST['corect']==($i+1+$ilerekordów)){
                    $insert="INSERT INTO choices VALUES('".$n."','".$id_pytanie."','1','".$wybur."')";
                    $insertbaza=$mysqli->query($insert);
                }else{
                    $insert="INSERT INTO choices VALUES('".$n."','".$id_pytanie."','0','".$wybur."')";
                    $insertbaza=$mysqli->query($insert);
                }
                
            }
        }
    }
    $delete=$mysqli->query("DELETE FROM `choices` WHERE choiceText=''");
    header("Location: change_question.php?n=".$n."");
}


?>