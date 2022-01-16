<?php
    session_start();
//    include_once '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            font-family: sans-serif;
            font-style:normal;
        }
        h1{
            display: block;
            margin: 0 auto;
            padding-top: 2em;
            font-size: 2.5em;
            width: 100%;
            border-bottom: 2px solid black;
            text-align: center;
        }
        body{
            width: 100%;
            height: 100%;
        }
        form{
            font-size: 1.5em;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            height: auto;
            width: 400px;
            text-align: center;
        }
        form input{
            margin: 5px 0px;
            border: none;
            border-bottom: 2px solid;
        }
        button{
            text-decoration: none;
            border: 1px solid black;
            border-radius: 5px;
            background-color: #337df4;
            font-size: 0.75em;
        }

    </style>
</head>
<body>
    <h1 >Logowanie do QUIZZU</h1>
    <form action='proceslog.php' method="post" >
        
       <p>Login: <input type="text" name="login"></p>
        <p>Hasło: <input type="password" name="haslo"></p>
        <?php
            if(isset($_SESSION['blad'])){
                echo "<p style='color: red;'>".$_SESSION['blad']."</p>";
                unset($_SESSION['blad']);
            }
        ?>
        <button type="submit" name='submit'>Log in</button>
        <button type="submit" name='rejestracja'>Register</button>
    </form>
</body>
</html>
<?php
include_once '../includes/footer.php';

?>