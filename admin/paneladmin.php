<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();
if($_SESSION['uprawinienia']!=1){
    header("Location: ../");
}
if (isset($_POST['submit'])){
    $wyszukiwanie=$_POST['wyszukiwarka'];
    $sql="SELECT * FROM konta WHERE `login` like '%$wyszukiwanie%' or `klasa` like '%$wyszukiwanie%' or `grupa` like '%$wyszukiwanie%' or `imie` like '%$wyszukiwanie%' or `nazwisko` like '%$wyszukiwanie%'";
    unset($_POST);
    $search=array();
    $index=0;
    $rezultat=$mysqli->query($sql);
    while($row=$rezultat->fetch_assoc()){
        $search[$row['id']]='szukane';
        $index++;
    }

}else{
    $sql="SELECT * FROM konta";
    
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

        table,tr,th,td{
            border: 2px solid #121221;
            transition: 0.5s;
        }
        table>form{
            margin: 0 auto;
            text-align: center;
        }
        a{
            text-decoration: none;
            border: 1px solid black;
            border-radius: 10px;
            color: white;
            background: blue;
/*            padding: 10px;*/
        }
        input["submit"]{
            color: blue;
            margin: 0 auto;
            display: flex;
            
        }
        th,td{
            width:150px;
            text-align:center;
        }
        .id{
            width:20px;
        }
        table{
            margin: 0 auto;
            position: relative;
            top: 2em;
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
        .gora{
            margin: 0 auto;
            display: table;
            padding-top: 2em;
        }
        div{
/*            display:inline-block;*/
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
                    if(index!=1){
                        element[index].disabled=false;
                    }

                    
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
                // przycisk2[0].style.display='none';
                // przycisk2[1].innerHTML='<i class="fas fa-check"></i>';
                pierwszy=1;
            }
            else if(pierwszy==1){
                
                // przycisk[1].setAttribute('name','delete');
                // przycisk[1].value=id2;
                location.href="delete.php?n="+id2;
                }
            
        }
        function cancle(id3){
            var przycisk3=document.getElementsByName(id3);
            console.log('cancle');
        }
    
    </script>
    
    <table>
        <div class="gora">
        <form method="post">
            <input name="wyszukiwarka" type="text">
            <input type="submit" name='submit'value='Szukaj'>
            <a type='submit' value='zapisz' href="../index.php">back to menu<a>
        </form>
            </div>
        <tr>
            <th class='id'>id</th>
            <th class='Login'>Login</th>
            <th class='Hasło'>Hasło</th>
            <th class='klasa'>klasa</th>
            <th class='grupa'>grupa</th>
            <th class='Imie'>Imie</th>
            <th class='Nazwisko'>Nazwisko</th>
            <th class='uprawnienia'>uprawnienia<br>(0-brak,1-pełne)</th>
            <th class='Modyfikacja'>Modyfikacja</th>
        </tr>
        
    
        <?php
        $ile=1;
            while($row=$rezultat->fetch_assoc()){
                echo "<form method='post' action='change.php'><tr><td class='id'>".$ile."</td>
                <td><input class='".$row['id']."' name='login".$row['id']."' value='".$row['login']."'disabled></td>
                <td><input type='password' class='".$row['id']."' name='haslo".$row['id']."' value='".base64_decode($row['haslo'])."'disabled></td>
                <td><input class='".$row['id']."' name='klasa".$row['id']."' value='".$row['klasa']."'disabled></td>
                <td><input class='".$row['id']."' name='grupa".$row['id']."' value='".$row['grupa']."'disabled></td>
                <td><input class='".$row['id']."' name='imie".$row['id']."' value='".$row['imie']."'disabled></td>
                <td><input class='".$row['id']."' name='nazwisko".$row['id']."' value='".$row['nazwisko']."'disabled></td>
                <td><input class='".$row['id']."' name='admin".$row['id']."' value='".$row['admin']."' type='number' min='0' max='1' disabled></td>
                <td  class='Modyfikacja' id='".$row['id']."'><div ><button  onclick='change(".$row['id'].")' type='button' name=".$row['id']." value='edit' style='background-color: lightblue; border: none; '><i class='fas fa-pen' ></i></button></form>
                <button onclick='deletee(".$row['id'].")' type='button' name=".$row['id']." value='DELETE' style='background-color: red; border: none;'><i class='fas fa-trash-alt'></i></button><div></td></tr>";
                $ile++;
            }

        ?>
        
    
    </table>
    <?php
            include_once '../includes/footer.php';
    ?>
</body>
</html>