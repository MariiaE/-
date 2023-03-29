<?php

function integer2(string $file_data): string
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

    //создаем цикл, который будет считывать поо одной строке из файла, пока они не закончаться
    for ($j=0; $j< $cont_lines; $j++)
    {
       
    
    $str=$file_array[$j];
    
    
        //ищем число в ковычках
         preg_match_all("/[']+-?[0-9]+\.?[0-9]*[']/", $str, $number_array);

        // умножаем найденные числа
        for ($i = 0; $i < count($number_array[0]); $i++)
        {

            $num_array[0][$i] = "'" . trim($number_array[0][$i], "'") * 2 . "'";
        }
        
        
        // замена значений в ковычках
        for ($i = count($num_array[0]) - 1; $i >= 0; $i--) {
            $count = $i + 1;
            $str = preg_replace("/[']-?[0-9]+\.?[0-9]*[']/", $num_array[0][$i], $str, $count);
         }
    
    $result_string.=$str;

        }
    return $result_string;
 } 






//Проверка программы на примере из задания
//входные данные из условия задачи
$a='input.txt';

//вызов функции
$result=  integer2($a);

//открываем файл для записи результата
$output_file = fopen("output.txt", 'w') or die("не удалось создать файл");

//запись результата в файл вывода
fwrite($output_file, $result);











