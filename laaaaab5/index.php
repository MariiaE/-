<!DOCTYPE html>

<html>
    <head>
        
        <link href="styles.css" rel="stylesheet" type="text/css">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
     
        <title>метро</title>
       
    </head>
    <body class="body">
    <div class="div" >
                            <form action="in3.php" id="myForm" method="post">
                                <p class="text">
                                    Введите город
                                </p>
                              <input class="input" type="text" id="address"  name="city">
                              <p class="text">
                                    Введите улицу
                                </p>
                              <input class="input" type="text" id="address"  name="street">
                              <p class="text">
                                    Введите дом
                                </p>
                              <input class="input" type="text" id="address"  name="house">
                              
                              <button onclick="sumbit()" class="button" type="submit" id="button"> Получить ответ</button>
                          </form>
                      </div>

                      <p>Ответ на Ваш запрос</p>
                      <?php
                      session_start();
                    
                      echo $_SESSION['result'];
                      ?>

    </body>

    
    
   



    </html>