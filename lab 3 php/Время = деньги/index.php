<?php

function short_html(string $file_data): string
{

    //$doc = new DOMDocument();
    //$doc->loadHTMLFile("input.html");
    //echo $doc->saveHTML();
   // echo htmlspecialchars($doc);
    //echo $elements = $doc->getElementsByTagName('body');





    $buffer = file_get_contents($file_data);
    // удаляем лишние комментарии
    $buffer = preg_replace('/<!--(?!skip-delete).*?-->/s', '', $buffer);

    // удаляем лишние пробелы
    $buffer = preg_replace('/\s+/', ' ', $buffer);

    // удаляем пробелы, переносы строк и табуляцию вне тегов
    $buffer = preg_replace('/(?<=>)\s+|\s+(?=<)/m', '', $buffer);

    // находим лишние скрипты
    preg_match_all('/<script\s+(?!.*data-skip-moving="true").*?<\/script>/s', $buffer, $scripts);

    // удаляем найденные скрипты
    $buffer = preg_replace('/<script\s+(?!.*data-skip-moving="true").*?<\/script>/s', '', $buffer);

    // добавляем найденные скрипты в конец html-страницы
    $html = preg_replace('/<\/body>/', implode('', $scripts[0]) . '</body>', $buffer);

    // записываем html текст в файл
    file_put_contents("output.html", $buffer);
   // $buffer = preg_replace('~>\s+<~', '><', $buffer);
    //$buffer = preg_replace('/<!--(?!skip-delete).*?-->/s', '', $buffer);
    //$buffer = preg_replace('/(?<code=>)\s+|\s+(?=<code)|(?<pre=>)\s+|\s+(?=<pre)|(?<textarea=>)\s+|\s+(?=<textarea)/m', '', $buffer);
   // $buffer = preg_replace('/(?:(?<=\>)|(?<=\/\>))\s+(?=\<\/?)/', '', $buffer);
   // if (FALSE === strpos($buffer, '<pre')) {
// $buffer = preg_replace('/\s+/', ' ', $buffer);
  //  }

    //$buffer = preg_replace("/\s+/u", " ", $buffer);?!(skip-delete)
    


   // $buffer = preg_replace('/(?:(?<=\>)|(?<=\/\>))\s+(?=\<\/?)/', '', $buffer);
   // $buffer = preg_match('/(?!=<!--)?!skip-delete(?=<!--)([\s\S]*?)-->/', '', $buffer);
  //  echo $buffer;
   // foreach (token_get_all($buffer) as $token ) {
      //  if ($token[0] != T_COMMENT) {
      //      continue;
      //  }
      //  $buffer = str_replace($token[1], '', $buffer);
   // }
    
    //echo $buffer;
    //if (FALSE === strpos($buffer, '<pre') && FALSE === strpos($buffer, '<code')&& FALSE === strpos($buffer, '<textarea')&& FALSE === strpos($buffer, '<style')&& FALSE === strpos($buffer, '<script')) {
     //   $buffer = preg_replace('/\s+/', ' ', $buffer);
       //    }
    // удалить новые строки,за которыми пробелы
    //$buffer = preg_replace('/[\t\r]\s+/', ' ', $buffer);       
    //echo '00000000000000000000000000000000000000000000';
    
    // читаем исходный файл

/*
// удаляем комментарии, кроме тех, что начинаются со слова skip-delete
$buffer = preg_replace('/<!--(?!skip-delete).*?-->/s', '', $buffer);

// заменяем больше одного пробела подряд на один пробел
$buffer = preg_replace('/\s+/', ' ', $buffer);

// удаляем пробелы, переносы строк и табуляцию вне тегов
$buffer = preg_replace('/(?<=>)\s+|\s+(?=<)/m', '', $buffer);

// находим все скрипты, кроме тех, что имеют атрибут data-skip-moving со значением true
preg_match_all('/<script\s+(?!.*data-skip-moving="true").*?<\/script>/s', $buffer, $scripts);

// удаляем найденные скрипты из исходного текста
$buffer = preg_replace('/<script\s+(?!.*data-skip-moving="true").*?<\/script>/s', '', $buffer);

// добавляем найденные скрипты в конец html-страницы
$buffer= preg_replace('/<\/body>/', implode('', $scripts[0]) . '</body>', $buffer);


/*
// Получаем содержимое полученного :) динамического/статического содержимого из файла и помещаем в переменную
function one_line($buffer)
// обрабатываем переменную
{
// удалить пробелы между html тегами, кроме <pre>
    $buffer = preg_replace('/(?:(?<=\>)|(?<=\/\>))\s+(?=\<\/?)/', '', $buffer);
    if (FALSE === strpos($buffer, '<pre')) {
 $buffer = preg_replace('/\s+/', ' ', $buffer);
    }
// удалить новые строки,за которыми пробелы
    $buffer = preg_replace('/[\t\r]\s+/', ' ', $buffer);
// но сохранить комментарии IE 
    $buffer = preg_replace('/<!(--)([^\[|\|])^(<!-->.*<!--.*-->)/', '', $buffer);
// и скрыть css комменты
    $buffer = preg_replace('/\/\*.*?\*\//', '', $buffer);
    return $buffer;
}
//echo one_line($buffer); //выводим окончательный результат
*/
   

    return $buffer;
 } 


 
 //Проверка программы на примере из задания

//входные данные из условия задачи
$a='input.html';

//вызов функции
$result= short_html($a);

//открываем файл для записи результата
$output_file = fopen("output.txt", 'w') or die("не удалось создать файл");

//запись результата в файл вывода
fwrite($output_file, $result);



/* 

// с помощью ф-ии glob возвращаем массив, который содержит файлы тестов
$mass_dat = glob('D/[0-9][0-9][0-9].html');

// массив с ф-ми ответов на тесты
$mass_ans = glob('D/*_ans.html');

echo "Результаты тестов: ";

// алгоритм для проверки ответов из 2-х файлов
for ($i = 0; $i < sizeof($mass_dat); $i++) {


    // вызов написанной ф-ии, запись ее результата
    $result = short_html($mass_dat[$i]);

    // записываем правильный ответ из файла с ответами в переменную
    $answer = file_get_contents($mass_ans[$i], 'r');;

    echo($i + 1) . '';

    // вывод ответов проверки

    if ($answer == $result) {
        echo '-right  ';
 } else {
    echo '-false  '.'Your answer: '."\n". $result ."\n". 'Correct answer: '."\n" . $answer ."\n". ' ';
    }
    if ($i==2){
        exit();
    }
    
}
*/

 