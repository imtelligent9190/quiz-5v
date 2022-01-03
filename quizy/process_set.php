<?php
include_once '../db/connect.php';
session_start();
if (isset($_POST)){
    $name=$_POST['name'];
    $datar = date('Y-m-d H:i:s ', strtotime($_POST['datar']));
    $datak = date('Y-m-d H:i:s ', strtotime($_POST['datak']));

    if ($datar>$datak){
        $pamiec=$datak;
        $datak=$datar;
        $datar=$pamiec;

    }
    $klasa=$_POST['klasa'];
    
    if (isset($_POST['1']) && isset($_POST['2'])){
        $grupa=3;
    }
    else if (isset($_POST['1'])){
        $grupa=1;
    }
    else if (isset($_POST['2'])){
        $grupa=2;
    }
    else {
        $_SESSION['blad_set_grupa']='Nie została zanaczona żadna grupa';
        header("Location: set_quiz.php");
    }
     if ($name==""){
        $_SESSION['blad_set_nazwa']='Nie został wybrany żaden quiz';
        header("Location: set_quiz.php");
    }
    $sql="SELECT * FROM klasa WHERE klasa='".$klasa."'";
    $check=$mysqli->query($sql);
     if ($check->num_rows==0){
        $_SESSION['blad_set_klasa']='Nie został wybrana żadna klasa';
        header("Location: set_quiz.php");
    }
    if ($datak<gmdate('Y-m-d H:i:s ',time()+3600)){
        $_SESSION['blad_set_data']='wybrałęś date ktra już mineła';
    };
    if ($name!= '' && $check->num_rows!=0 && $grupa!=0 && $datak>gmdate('Y-m-d H:i:s ',time()+3600)){
            $search="SELECT id FROM quizy WHERE `name`='".$name."' AND `id_n`='".$_SESSION['user-id']."'";
            $id_quiz=$mysqli->query($search);
            $id_quiz=$id_quiz->fetch_assoc();
            $insert="INSERT INTO kolejka VALUES('null','".$name."','".$id_quiz['id']."','".$datar."','".$datak."','".$klasa."','".$grupa."')";
            if($rezultat=$mysqli->query($insert) or die ($mysqli_error.__LINE__)){
                
                header("Location: ../");
            };


        }
        else{
            header("Location: set_quiz.php");
        }

    }


    ?>