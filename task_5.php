<?php

/* 5. Простая интеграция.
Сделать веб-страничку запроса курса USD. На странице — форма. В форме поле даты и кнопка "запросить".
После отправки формы скрипт ищет курс на эту дату в локальной БД. Если его нет — идёт в API ЦБ РФ https://www.cbr.ru/development/SXML/ и вытаскивает курс доллара. Потом сохраняет в локальную БД и выводит пользователю.
Пришлите ссылку на репозиторий с решением */


/* В данном файле представлена часть контроллера для обработки запроса обменного курса на определенную дату */
// Данные $date из формы на страничке направляются на сервер с помощью ajax
// Файл Rate.php также находится в текущем репозитории

require_once ROOT . '/core/Controller.php';
require_once ROOT . '/models/Rate.php';

class SolutionController extends Controller
{
    // Метод для задачи № 5
    // Метод, добавляющий Exchange Rate в БД
    public function actionAddrate($date = '')
    {
        if (empty($date)) {
            return false;
        }

        $pattern = '~([0-9]{4})-([0-9]{2})-([0-9]{2})~';
        $file = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?date_req=" . preg_replace($pattern, '$3/$2/$1', $date));
        $valutes = array();

        foreach ($file as $valute) {
            if (array_key_exists('USD', $valutes) && array_key_exists('EUR', $valutes)) {
                break;
            } else {
                if (strval($valute->CharCode) == 'USD' || strval($valute->CharCode) == 'EUR') {
                    $valutes[strval($valute->CharCode)] = strval($valute->Value);
                } else {
                    continue;
                }
            }
        }

        return Rate::addRateByDate($valutes['USD'], $valutes['EUR'], $date);
    }

    // Метод, получающий Exchange Rate из БД
    public function actionGetrate()
    {
        header('Content-Type: application/json');

        $date = '';
        $date = $_POST['date'];
        $pattern = '~([0-9]{4})-([0-9]{2})-([0-9]{2})~';

        $exchangeRate = array();
        $exchangeRate = Rate::getRateByDate($date);
        $response = array();

        if ($exchangeRate) {
            $response = [
                'status' => true,
                'rate' => '<div>Курс валют на ' . preg_replace($pattern, '$3.$2.$1', $date)
                    . ': <span style="margin: 0 2em ">USD&nbsp;&nbsp;' . $exchangeRate['USD']
                    . '</span><span>EUR&nbsp;&nbsp;' . $exchangeRate['EUR'] . '</span></div>'
            ];
        } else {
            if ($this->actionAddrate($date)) {
                $exchangeRate = Rate::getRateByDate($date);
                $response = [
                    'status' => true,
                    'rate' => '<div>Курс валют на ' . preg_replace($pattern, '$3.$2.$1', $date)
                        . ': <span style="margin: 0 2em ">USD&nbsp;&nbsp;' . $exchangeRate['USD']
                        . '</span><span>EUR&nbsp;&nbsp;' . $exchangeRate['EUR'] . '</span></div>'
                ];
            } else {
                $response = [
                    'status' => false
                ];
            }
        }

        echo json_encode($response);

        return true;
    }
}
