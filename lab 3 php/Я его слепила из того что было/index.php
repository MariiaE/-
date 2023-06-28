<?php

function combo(string  $file_data_sections, string $file_data_products)
{
//преобразовываем xml файл
$xml = simplexml_load_file($file_data_sections);
$xml_products = simplexml_load_file($file_data_products);

//считаем сколько всего разделов в файле
 $count_of_items =  $xml->count();

//для каждого раздела добавляем каталог товаров
for ($i=0; $i<$count_of_items; $i++)
$xml-> Раздел[$i] -> addChild('Товары');

//считаем сколько всего товаров нужно добавить 
 $count_of_products =  $xml_products->count();

//если товаров нет
if ($count_of_products==0){
    //$result = $xml->asXML();
    $b = substr($xml->asXML(), 38);
    $b= "<ЭлементыКаталога>".$b;
    $b=$b."</ЭлементыКаталога>";
    $a=substr($xml->asXML(), 0, 38);
    $xml=$a.$b;
    return $xml;
    exit();
}

//если товары есть
for ($i=0; $i<$count_of_products; $i++){

    //ко скольки разделам относится товар
    for ($o=0; $o<count($xml_products->Товар[$i]->Разделы->ИдРаздела); $o++){

        //считаем ко скольки разделам пренадлежит товар
        $products_section[$o] = $xml_products->Товар[$i]->Разделы->ИдРаздела[$o];

            //проходи по каждому разделу секций
            for ($k=0; $k<$count_of_items; $k++){
                
                //записываем ид секции
                 $section_id[$k] = $xml-> Раздел[$k] ->Ид;  

                //удаляем ненужные пробелы в строке
                $products_section_id_form[$o] = preg_replace('/[\r\n\s]/',"",$products_section[$o]);
                
                //если ид секции и раздела, которому пренадлежит товар совпадают
                if ($products_section_id_form[$o] == $section_id[$k]){
                    $xml-> Раздел[$k] ->Товары->addChild('Товар');
                    $xml-> Раздел[$k] ->Товары ->Товар[count($xml-> Раздел[$k] ->Товары ->Товар)-1]->addChild('Ид',$xml_products-> Товар[$i] ->Ид);
                    $xml-> Раздел[$k] ->Товары ->Товар[count($xml-> Раздел[$k] ->Товары ->Товар)-1]->addChild('Наименование',$xml_products-> Товар[$i] ->Наименование);
                    $xml-> Раздел[$k] ->Товары ->Товар[count($xml-> Раздел[$k] ->Товары ->Товар)-1]->addChild('Артикул',$xml_products-> Товар[$i] ->Артикул);

                }

            }

    
        } 
    }
$b = substr($xml->asXML(), 38);
$b= "<ЭлементыКаталога>".$b;
$b=$b."</ЭлементыКаталога>";
$a=substr($xml->asXML(), 0, 38);
$xml=$a.$b;

return $xml;
}


/*
 //Проверка программы на примере из задания

//входные данные из условия задачи
$a='B/005_sections.xml';
$b='B/005_products.xml';

//вызов функции
$result= combo($a,$b);

//записываем результат в файл
//$result->asXML('output.xml');

//убираем все пробелы для того, чтобы произвести проверку
$result = preg_replace(
    '/[\r\n\s]/',
    "",
    $result
);

//открываем файл для записи результата
$output_file = fopen("output.xml", 'w') or die("не удалось создать файл");

//запись результата в файл вывода
fwrite($output_file, $result);
*/


// с помощью ф-ии glob возвращаем массив, который содержит файлы тестов
$mass_products = glob('B/*_products.xml');


// с помощью ф-ии glob возвращаем массив, который содержит файлы тестов
$mass_sections = glob('B/*_sections.xml');


// массив с ф-ми ответов на тесты
$mass_result = glob('B/*_result.xml');


echo "Результаты тестов: ";

// алгоритм для проверки ответов из 2-х файлов
for ($i = 0; $i < sizeof($mass_products); $i++) {


    // вызов написанной ф-ии, запись ее результата
    $result = combo($mass_sections[$i],$mass_products[$i]);
    //var_dump($result);

    //записываем результат в файл
    //$result->asXML('result.xml');

    //убираем все пробелы для того, чтобы произвести проверку
    $result = preg_replace(
        '/[\r\n\s]/',
        "",
        $result
    );
    
    

    // записываем правильный ответ из файла с ответами в переменную
    $answer = simplexml_load_file($mass_result[$i]);

    $answer->asXML('answer.xml');

    //убираем все пробелы для того, чтобы произвести проверку
    $answer = preg_replace(
        '/[\r\n\s]/',
        "",
        file_get_contents("answer.xml")
    );
    
    
    
    echo($i + 1) . '';

    // вывод ответов проверки

    if ($answer == $result) {
        echo '-right  ';
 } else {
    echo '-false  '.'Your answer: '."\n". $result ."\n". 'Correct answer: '."\n" . $answer ."\n". ' ';
    }
}
