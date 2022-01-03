<?php
include_once '../db/connect.php';
session_start();
if(isset($_POST['submit'])){
    $login=$_POST['login'];
    $haslo=base64_encode($_POST['haslo']);
    $klasa=$_POST['klasa'];
    $grupa=$_POST['grupa'];
    $imie=$_POST['imie'];
    $nazwisko=$_POST['nazwisko'];
    $sql="SELECT * FROM klasa WHERE klasa='".$klasa."'";
    $rezultat=$mysqli->query($sql);
    if ($login!= '' && $haslo!= '' && $rezultat->num_rows==1 && $grupa!= '' && $imie!= '' && $nazwisko!=''){
        
        $sql2="SELECT * FROM konta WHERE `login`='".$login."'";
        $rezultat2=$mysqli->query($sql2);
        if ($rezultat2){
            $ile=$rezultat2->num_rows;
            echo $ile;
        if ($ile==0){
            $insert="INSERT INTO konta VALUES('null','".$login."','".$haslo."','".$klasa."','".$grupa."','".$imie."','".$nazwisko."',0)";
            if($rezultat=$mysqli->query($insert) or die ($mysqli_error.__LINE__)){
                header("Location: logowanie.php");
            };

            
        }else{
            $_SESSION['bladreg']='Taki Login jest już uzywany';
            header("Location: rejestracja.php");
        }
        }
        
    }else{
        $_SESSION['bladreg']='Źle podane dane';
        header("Location: rejestracja.php");
    }
};
?>