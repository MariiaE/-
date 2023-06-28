<?php

function flight_time(string $file_data): string
{
//открываем файл только для чтения
$input_file = fopen($file_data, 'r') or die("не удалось открыть файл");

//количество рейсов
$n=0;

//считываем количество рейсов
$n = fgets($input_file);

//объявдем переменную для записи результата
$result='';

//если переменная в допустимом интервале значений выполняем
if($n>=1&&$n<=10000){

    //построчно считываем данные
    for ($i =0 ; $i<$n; $i++){
        
        //разбиваем строку на переменные даты и часового пояса
        list($takeoff, $time_zone1, $arrival,$time_zone2) = explode(" ", fgets($input_file));

        //разделяем информацию о вылете на дату и время
        list($date_takeoff,$time_takeoff) = explode("_",$takeoff);

        //разделляем информацию о прилете на дату и время
        list($date_arrival,$time_arrival) = explode("_",$arrival);

        //записываем дату в необходимый формат
        $date_time_takeoff=$date_takeoff.' '.$time_takeoff;
        $date_time_arrival=$date_arrival.' '.$time_arrival;

        //преобразовываем дату в секунды от начала эры
        $date_time_takeoff = strtotime($date_time_takeoff);
        $date_time_arrival = strtotime($date_time_arrival);

        //переводим часовой пояс в секунды
        $time_zone1=$time_zone1*3600;
        $time_zone2=$time_zone2*3600;

        //преводим дату вылета и прилета к одному часовому поясу (0)
        $date_time_takeoff=$date_time_takeoff-$time_zone1;
        $date_time_arrival=$date_time_arrival-$time_zone2;

        //находим время полета
        $difference=$date_time_arrival-$date_time_takeoff;

        $result.=$difference."\n";

    }
    
   

}
else{
    echo "число введено не верно";
}
 
return $result;
}



/*
 //Проверка программы на примере из задания

//входные данные из условия задачи
$a='input.txt';

//вызов функции
$result= flight_time($a);

//открываем файл для записи результата
$output_file = fopen("output.txt", 'w') or die("не удалось создать файл");

//запись результата в файл вывода
fwrite($output_file, $result);


*/
// с помощью ф-ии glob возвращаем массив, который содержит файлы тестов
$mass_dat = glob('A/*.dat');

// массив с ф-ми ответов на тесты
$mass_ans = glob('A/*.ans');

echo "Результаты тестов: ";

// алгоритм для проверки ответов из 2-х файлов
for ($i = 0; $i < sizeof($mass_dat); $i++) {

    // открываем файл с ответами для чтения
    $output = fopen($mass_ans[$i], 'r');

    // вызов написанной ф-ии, запись ее результата
    $result = flight_time($mass_dat[$i]);

    // записываем правильный ответ из файла с ответами в переменную
    $answer = file_get_contents($mass_ans[$i], 'r');


    echo($i + 1) . '';

    // вывод ответов проверки

    if ($answer == $result) {
        echo '-right  ';
 } else {
        echo '-false  '.'Your answer: ' . $result . '    Correct answer: ' . $answer . ' ';
    }
}

