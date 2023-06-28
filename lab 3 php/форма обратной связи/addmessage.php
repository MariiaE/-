<?php
try{
    $conn = new PDO( "mysql:host=localhost;dbname=laba3",'root', '' );

    if(empty($_POST['name'])) exit("Поле имени заполнено не верно");
    else if(empty($_POST['email']) || preg_match('/([0]{0})([A-Za-z0-9]{1})([A-Za-z0-9_]{3,29})@([A-Za-z]{2,30})[.]([a-z]{2,10})/', $_POST['email'])==0)
    exit("Поле email заполнено не верно");
    else if(empty($_POST['phone']) || preg_match('/\+7 [0-9]{3} [0-9]{3}-[0-9]{2}-[0-9]{2}/', $_POST['phone']) == 0) 
    exit("Поле номера заполнено не верно");
    else if(empty($_POST['comment'])) exit("Поле text заполнено не верно");
    $a=$_POST['email'];
    
    // Запрос на вывод записей из таблицы
    $sql = "SELECT (now()-max(time)) as timee FROM `message`  where email='$a'";
    // Подготовка запроса
    $statement = $conn->prepare($sql);
    // Выполняем запрос
    $statement->execute();
    // Получаем массив строк 
    $result_array = $statement->fetchAll();
   
    foreach ($result_array as $row){
        $time= $row['timee'] ;
        }
    
       // echo $time;
       // exit;
    

    if ($time>3600 || $time==''){

    $query = "INSERT INTO  message VALUES( NULL, :text, :Name, :number, :email, NOW())";
    $msg = $conn->prepare($query);
    $msg->execute(['text' => $_POST['comment'], 'Name' => $_POST['name'], 'number' => $_POST['phone'], 'email' => $_POST['email']]);

    session_start(); 

     $_SESSION['name'] = $_POST['name'];
     $_SESSION['email'] = $_POST['email'];
     $_SESSION['comment'] = $_POST['comment'];
    header("Location: index2.php");


    mail('mashaegorova2002@gmail.com', 'My form', $_POST['comment'] );
    $message = "<table style='width: 100%;'>$message</table>";

}
else{
    session_start(); 
    $time=60-ceil($time/60);
    
     $_SESSION['name'] = $time;
    header("Location: index3.php");
}
}
catch(PDOException $e){
    echo "error".$e->getMessage();
}

?>


