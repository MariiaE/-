<?php

function fullview(string $file_data): string
{
    //открываем файл только для чтения
    $input_file = fopen($file_data, 'r') or die("не удалось открыть файл");

    // Записываем весь файл в массив
    $file_array=file($file_data);

    //считаем количество строк в массиве
    $cont_lines=count($file_array);

    //создадим строку, в которую будем записывать результат 
    $result_fullview = '';

    //создадим строку, с помощью которой будем добавлять пропущенные символы
    $missed_valie='';

   
    //создаем цикл, который будет считывать поо одной строке из файла, пока они не закончаться
    for ($i=0; $i<$cont_lines; $i++){
       
        
        //удалим пробелы
        $file_array[$i] = trim($file_array[$i]);

        //разбиваем на блоки
        $ip = explode(":", fgets($input_file));
        

        for ($j=0; $j<count($ip);$j++){

         //удалим пробелы   
        $ip[$j] = trim($ip[$j]);
        
        //если "::", то заполняем нулями блоки
         if($ip[$j]==''){
            
            while (count($ip) < 8) {
                $key=$j;
                array_splice($ip,$key,0,'0000');
            }
           
        }
        }
        
        // если блоков < 8 дополняем нулями справа
        while (count($ip) < 8) {
            $ip[] = '0000';
        }
       
        //если в блоке меньше 4 символов, то добавляем нули слева
        for ($j=0; $j<8;$j++){  
  
        if (strlen($ip[$j])<4){
            for  ($k=strlen($ip[$j]); $k<4;$k++){
                
                $missed_valie.="0";

            } 
            $missed_valie.= $ip[$j];
            $ip[$j]=$missed_valie;
            $missed_valie='';
           //$ip[$j] = str_pad($ip[$j], 4, '0', STR_PAD_LEFT);
        }
    }
     
        //записываем результат в строку
        $result_fullview.=implode(':', $ip) . "\n";
        
     

    }     

    return $result_fullview;
 } 


/* 
 //Проверка программы на примере из задания

//входные данные из условия задачи
$a='input.txt';

//вызов функции
$result= fullview($a);

//открываем файл для записи результата
$output_file = fopen("output.txt", 'w') or die("не удалось создать файл");

//запись результата в файл вывода
fwrite($output_file, $result);


*/
// с помощью ф-ии glob возвращаем массив, который содержит файлы тестов
$mass_dat = glob('B/*.dat');

// массив с ф-ми ответов на тесты
$mass_ans = glob('B/*.ans');

echo "Результаты тестов: ";

// алгоритм для проверки ответов из 2-х файлов
for ($i = 0; $i < sizeof($mass_dat); $i++) {


    // вызов написанной ф-ии, запись ее результата
    $result = fullview($mass_dat[$i]);

    // записываем правильный ответ из файла с ответами в переменную
    $answer = file_get_contents($mass_ans[$i], 'r');;

    echo($i + 1) . '';

    // вывод ответов проверки

    if ($answer == $result) {
        echo '-right  ';
 } else {
        echo '-false  '.'Your answer: ' . $result . 'Correct answer: ' . $answer . ' ';
    }
}

