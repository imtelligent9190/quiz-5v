<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <!-- <style>
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
    </style> -->
        <style>
        body{
            width:80%;
            margin-left: auto;
            margin-right: auto;
            border-bottom: 2px solid black;
        }
        form{
            display: grid;
            width:80%;
            margin-left: auto;
            margin-right: auto;
            padding-bottom:5px;
        }
        input["checkbox"]{
            display: block;
        }
        .grupa{
            display: block;
        }
        h1{
            width: 100%;
            border-bottom: 2px solid black;
            text-align: center;
            padding-bottom: 1em;
            padding-top: 1em;
        }
        input[type = "text"]{
            width:80%;
        }
        input[type = "submit"]{
            border:none;
            border-bottom:2px solid lime;
            color: black;
            background-color:white;
            width:20%;
            margin-left: auto;
            margin-right: auto;
            font-size:20px;
        }
        input[type = "submit"]:hover{
            cursor:pointer;
            background-color:lightblue;
            transition: .5s;
        }
        .grupa{
            display:flex;
        }
        label{
            display:flex;
        }
    
    </style>
    <h1>DODAJ QUIZZ</h1>
    <form method="post" action='process.php'>
        <label>Nazwa quizu: <input type="text" name="name" id="" required="required"></label><br>
        <label><p> Oceny(podaj procenty):<br>
            <input type="number" name="2-" placeholder='2-' required="required">
            <input type="number" name="2" placeholder='2' required="required">
            <input type="number" name="2+" placeholder='2+' required="required">
            <input type="number" name="3-" placeholder='3-' required="required">
            <input type="number" name="3" placeholder='3' required="required">
            <input type="number" name="3+" placeholder='3+' required="required">
            <input type="number" name="4-" placeholder='4-' required="required">
            <input type="number" name="4" placeholder='4' required="required">
            <input type="number" name="4+" placeholder='4' required="required">
            <input type="number" name="5-" placeholder='5-' required="required">
            <input type="number" name="5" placeholder='5' required="required">
            <input type="number" name="5+" placeholder='5+' required="required">
        </p></label><br>
        <input class = "sub" type="submit" value="Create">
    </form>

    
</body>
</html>