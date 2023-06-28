<?php
//$str = file_get_contents('php://input'); 
$city = trim($_POST['city']);
$street = trim($_POST['street']);
$house = trim($_POST['house']);

//$data = "Lipetsk+Lenina+14";
$data = '';
$data = $city . '+' . $street . '+' . $house;
//echo $address;

class Metro
{
	//функция для подсчета расстояния до метро
	function distance($lat_1, $lon_1, $lat_2, $lon_2)
	{

		$radius_earth = 6371; // Радиус Земли

		$lat_1 = deg2rad($lat_1);
		$lon_1 = deg2rad($lon_1);
		$lat_2 = deg2rad($lat_2);
		$lon_2 = deg2rad($lon_2);

		$d = 2 * $radius_earth * asin(sqrt(sin(($lat_2 - $lat_1) / 2) ** 2 + cos($lat_1) * cos($lat_2) * sin(($lon_2 - $lon_1) / 2) ** 2));

		return "\n" . "Расстояние до ближайшего метро:" . " " . number_format($d, 2, '.', '') . ' км.';
	}

	function meeeee($data, $file): string
	{

		$result = '';
		//достаем ключ из файла
		$flower = parse_ini_file($file);

		// получаем координаты по адресу
		$url = "https://geocode-maps.yandex.ru/1.x/?apikey=" . $flower['key'] . "&geocode=" . $data . "&format=json";
		$answer = file_get_contents($url);
		$coordsData = json_decode($answer, false);

		// координаты адреса
		list($longitude, $with) = explode(' ', $coordsData->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos);


		// ищем метро
		$url = "https://geocode-maps.yandex.ru/1.x/?apikey=" . $flower['key'] . "&geocode={$longitude},{$with}&kind=metro&format=json";
		$answer = file_get_contents($url);
		$metroData = json_decode($answer, false);
		//var_dump($name_of_close_metro = $metroData->response->GeoObjectCollection->featureMember[0]);
		if ($name_of_close_metro = $metroData->response->GeoObjectCollection->featureMember[0] != NULL) {
			$name_of_close_metro = $metroData->response->GeoObjectCollection->featureMember[0]->GeoObject->metaDataProperty->GeocoderMetaData->text;
			list($longitude_metro, $with_metro) = explode(' ', $metroData->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos);

			if ($longitude_metro == NULL || $with_metro == NULL) {
				$result .= "\n" . "Боюсь, что в городе, который Вы указали, нет метро.";
			} else {
				//расстояние до метро
				$lenght = $this->distance($with, $longitude, $with_metro, $longitude_metro);
				$result .= $name_of_close_metro . $lenght;
			}
		} else {
			$result .= "\n" . "Боюсь, что в городе, который Вы указали, нет метро.";
		}
		return $result;
	}
}
session_start();
//$data = "Moscow+Lenina+14";
$file = "config.ini";
$result = new Metro();
$result = $result->meeeee($data, $file);

$_SESSION['result'] = $result;
//echo $_SESSION['result'];
