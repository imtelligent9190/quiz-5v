<?php
include_once '../db/connect.php';
session_start();
if (isset($_POST)){
    $name=$_POST['name'];
    if ($name!= ''  ){
        $sql="SELECT id FROM quizy order by id DESC limit 1;";
            $rezultat=$mysqli->query($sql);
            $id=$rezultat->fetch_assoc();
            $total=(int)$id['id']+1;
            
            $insert="INSERT INTO quizy VALUES('null','".$name."','".$_SESSION['user-id']."')";
            if($rezultat=$mysqli->query($insert) or die ($mysqli_error.__LINE__)){
                $query = $sql="SELECT id FROM quizy WHERE name='".$name."' AND id_n ='".$_SESSION['user-id']."'";
                $run = $mysqli->query($query);
                $id = mysqli_fetch_row($run);
                $_SESSION['id']=$id[0];
                header("Location: ../pytania/dashboard.php");
            };


        }
        
    // echo $_POST['1']."< >".$_POST['2']."<br>";
    // echo $datar." ".$datak;
    }


    ?>