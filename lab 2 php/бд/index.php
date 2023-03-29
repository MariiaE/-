<?php

function bd(string $file_data): string
{
    //открываем файл только для чтения
    $input_file = fopen($file_data, 'r') or die("не удалось открыть файл");
   

    // Записываем весь файл в массив
    $file_array=file($file_data);

    //считаем количество строк в массиве
    $cont_lines=count($file_array);
    

    //создадим строку, в которую будем записывать результат 
    $result_string = '';

    //одна строка файла
    $str='';

    //создаем цикл, который будет считывать по одной строке из файла, пока они не закончаться
    for ($j=0; $j<= $cont_lines; $j++)
    {
  
    $str=$file_array[$j];
    //проверяем есть ли старый адресс
    if (preg_match('/http:\/\/asozd\.duma\.gov\.ru\/main\.nsf\/\(Spravka\)\?OpenAgent&RN=[0-9-]+&[0-9]+/', $str)){

        //заменяем старый адресс на новый
        $str = preg_replace("/http:\/\/asozd\.duma\.gov\.ru\/main\.nsf\/\(Spravka\)\?OpenAgent&RN=/", "http://sozd.parlament.gov.ru/bill/", $str);
        $str = preg_replace("/&[0-9]+/", "", $str);
    }
    
    $result_string.=$str;

        }
    return $result_string;
 } 






//Проверка программы на примере из задания
//входные данные из условия задачи
$a='input.txt';

//вызов функции
$result=  bd($a);

//открываем файл для записи результата
$output_file = fopen("output.txt", 'w') or die("не удалось создать файл");

//запись результата в файл вывода
fwrite($output_file, $result);











