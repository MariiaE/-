<?php

function validation(string $file_data): string
{
    //открываем файл только для чтения
    $input_file = fopen($file_data, 'r') or die("не удалось открыть файл");

    // Записываем весь файл в массив
    $file_array=file($file_data);

    //считаем количество строк в массиве
    $cont_lines=count($file_array);

    //создадим строку, в которую будем записывать результат проверки валидации
    $result_validation = '';

    //создаем цикл, который будет считывать поо одной строке из файла, пока они не закончаться
    for ($i=0; $i<$cont_lines; $i++){

        //разобьем первую строку на 2 массива в первом будет храниться "<информация пользователя", а во втором тип и параметры валидации
        $output = explode('>',fgets($input_file),2);

        //избавимся от лишних пробелов
        $output[1] = trim($output[1]);

        //запишем в переменную тип валидации
        $p=substr($output[1],0,1);

        //удалим пробелы
        $p = trim($p);

        //удаляем ненужный эл-т в строке
        $output[0]=trim($output[0], '<');


        if ($p=='S'){

            //записываем значения параметров из строки
            $n = explode(" ", $output[1])[1];
            $m = explode(" ", $output[1])[2];
        
            //находим длину нужной строки
            $lenght=strlen($output[0]);

            //Сравниваем длину данных с допустимой
            if (($n <= $lenght) and ($lenght <= $m))
            {
                $result_validation.="OK\n";
            }

            else
            {
                $result_validation.="FAIL\n";
            } 

        }


        else if ($p=='N')
        {
            //записываем значения параметров из строки
            $n = explode(" ", $output[1])[1];
            $m = explode(" ", $output[1])[2];

            
            $number=$output[0];

            

            //Сравниваем число с допустимыми значениями
            if ((preg_match('/^-[1-9]*[0-9][0-9]*$/', $number)==1 || preg_match('/^[1-9]*[0-9][0-9]*$/', $number)==1 || $number == '0') and ($n <= $number) and ($number <= $m))
            {
                $result_validation.="OK\n";
            }

            else
            {
                $result_validation.="FAIL\n";
            }
            
        }


        else if ($p=='P')
        {

            //преобразовываем оставшиеся данные массива в строку
            $string=$output[0];
            
            //с помощью регулярного выражения проверяем правильность написанного номера
            if (strlen($string) == 18 && preg_match("/\+7 \([0-9]{3}\) ([0-9]{3})-([0-9]{2})-([0-9]{2})/", $string) == 1) 
            {

                $result_validation .= "OK\n";
                    
            } 

            else {

                $result_validation .= "FAIL\n";

            } 

        }   
        

       else if ($p=='D')
        {
            //записываем в переменные значения даты и времени
            $date = explode(" ", $output[0])[0];
            $time = explode(" ", $output[0])[1];

            // разделяем дату на отдельные переменные
            $day = explode(".", $date)[0];
            $month = explode(".", $date)[1];
            $year = explode(".", $date)[2];

            // разделяем время на отдельные переменные
            $hours = explode(":", $time)[0];
            $minutes = explode(":", $time)[1];

            // проверяем существование даты
            $isDateValid = checkdate($month, $day, $year);

            // проверяем год на количество символов
            if (strlen($year) != 4) 
            {
                $isDateValid = false;
            }


            if ($hours < 24)
            {
                $isHoursValid = true;
            } 

            else
            {
                $isHoursValid = false;
            }


            if ($minutes < 60) 
            {
                $isMinutesValid = true;
            } 
            else
            {
                $isMinutesValid = false;
            }


            // условия, что все проверки валидности пройдены
            if ($isDateValid==1 && $isHoursValid==1 && $isMinutesValid==1) 
            {
                $result_validation .= "OK\n";
                
            } 

            else 
            {
                $result_validation .= "FAIL\n";
            }

        }


        else if ($p == 'E') 
        {
            //проверяем, что первый символ не равен "_"
            if (substr($output[0],0,1) != '_') 
            {

                //с помощью регулярного выражения проверяем правильность написанной почты
                if (preg_match('/([0]{0})([A-Za-z0-9]{1})([A-Za-z0-9_]{3,29})@([A-Za-z]{2,30})[.]([a-z]{2,10})/', $output[0])==1)
                {
                    $result_validation .= "OK\n";
                } 

                else 
                {
                    $result_validation .= "FAIL\n"; 
                }

            } 

            else 
            {
                $result_validation .= "FAIL\n";
            }
        }
    
    } 

    return $result_validation;
 } 





/*
//Проверка программы на примере из задания
//входные данные из условия задачи
$a='input.txt';

//вызов функции
$result= validation($a);

//открываем файл для записи результата
$output_file = fopen("output.txt", 'w') or die("не удалось создать файл");

//запись результата в файл вывода
fwrite($output_file, $result);

*/




// с помощью ф-ии glob возвращаем массив, который содержит файлы тестов
$mass_dat = glob('C/*.dat');

// массив с ф-ми ответов на тесты
$mass_ans = glob('C/*.ans');

echo "Результаты тестов: ";

// алгоритм для проверки ответов из 2-х файлов
for ($i = 0; $i < sizeof($mass_dat); $i++) {


    // вызов написанной ф-ии, запись ее результата
    $result = validation($mass_dat[$i]);


    $file_array=file($mass_dat[$i]);
    $cont_lines=count($file_array);

    $answer='';
    for ( $j=0; $j < $cont_lines; $j++) {
    // записываем правильный ответ из файла с ответами в переменную
    $answer = file_get_contents($mass_ans[$i], 'r');
    }
    echo($i + 1) . '';

    // вывод ответов проверки

    if ($answer == $result) {
        echo '-right  ';
 } else {
        echo '-false  '.'Your answer: ' . $result . 'Correct answer: ' . $answer . ' ';
    }
}




