<!DOCTYPE html>
<html lang="en">
    <header>
        <meta charset="UTF-8">
        <meta name="viewport"
        content="width=device-width, user-scalable, initial-scale=1.0,maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">


    </header>

    <body>
        
        <p>Спасибо за Ваше сообщение, мы обязательно ответим Вам!</p>
        <p>Ваше имя: 
        <?php
        session_start();
        echo $_SESSION['name'];
        ?>
        </p>
        <p>Ваше email: 
        <?php
        echo $_SESSION['email'];
        ?>
        </p>

        <p>Ваше сообщение: 
        <?php
        echo $_SESSION['comment'];
        ?>
        </p>


    
    </body>

</html>