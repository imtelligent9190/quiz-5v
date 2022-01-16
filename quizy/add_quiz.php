<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <style>
        *{
            font-family: sans-serif;
            font-style: normal;
        }
        h1{
            font-size: 2em;
            margin: 0 auto;
            text-align: center;
        }
        form{
            display: inline-grid;
            align-content: center;
            margin: 0 auto;
            width: 100%;
            text-align: center;
            padding-top: 2em; 
        }
        .sub{
            background-color: blue;           
            border-radius: 10px;
            
        }
        .sub:hover{
            background-color: #a1a1ff;
            transition: 0.5s;
        }
    </style>
    <h1>DODAJ QUIZZ</h1>
    <form method="post" action='process.php'>
        Nazwa quizu: <input type="text" name="name" id="" required="required"><br>
        <input class = "sub" type="submit" value="Create">
    </form>

    
</body>
</html>