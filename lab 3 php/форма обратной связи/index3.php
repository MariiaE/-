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
        
        <p>Спасибо за Ваше сообщение, но в данный момент мы не можем его отправить!</p>
        <p>Повторите попытку через  
        <?php
        session_start();
        echo $_SESSION['name'];
        ?>
         мин</p>
       


    
    </body>

</html>