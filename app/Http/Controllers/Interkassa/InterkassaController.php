<?php

namespace App\Http\Controllers\Interkassa;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

//use App\TypeSubscribers;
//use App\Subscribers;
//use Illuminate\Support\Facades\DB;

/**
 * Базовый класс работы с Интеркассой
 *
 * @since  0.1
 * @author Volodymyr Tykhomyrov <vadtiho@hotmail.com>
 */
class InterkassaController extends Controller
{
    /**
     * ID Интеркассы
     * @var string
     */
    private $ik_id;

    /**
     * Ключ Интеркассы
     * @var string
     */
    private $ik_key;


    /**
     * Ключ Тестовый Интеркассы
     * @var string
     */
    private $ik_t_key;

    /**
     * Режим Интеркассы
     * @var boolean
     */
    private $ik_test;

    /**
     * Валюта Интеркассы
     * @var string
     */
    private $ik_currency;
    
    /**
     * Инициализация класса
     */
    public function __construct()
    {
        $this->ik_id = env('INTERKASSA_ID', NULL);
        $this->ik_test = env('INTERKASSA_TEST_MODE', FALSE);
        $this->ik_key = env('INTERKASSA_REAL_KEY', NULL);
        $this->ik_t_key = env('INTERKASSA_TEST_KEY', NULL);
        $this->ik_currency = env('INTERKASSA_CURRENCY', 'UAH');
    }

    public function getID()
    {
        return $this->ik_id;
    }

    public function setID($id)
    {
        $this->ik_id = $id;
    }

    public function getKey()
    {
        return $this->ik_key;
    }

    public function setKey($key)
    {
        $this->ik_key = $key;
    }

    public function getTKey()
    {
        return $this->ik_t_key;
    }

    public function setTKey($key)
    {
        $this->ik_t_key = $key;
    }

    public function getTest()
    {
        return $this->ik_test;
    }

    public function setTest($key)
    {
        $this->ik_test = $key;
    }
    
    public function getCurrency()
    {
        return $this->ik_currency;
    }

    /**
     * Метод взаимодействия с кассой интеркасса, GET/POST
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function api(Request $request)
    {
        //пришёл любой запрос, пишем его в лог файл на сервер
        Log::info('---INTERKASSA_API----------------------------------------------------- ', [$request->all()]);

        $inval = $this->invalidSignIK($request);
        //если не FALSE, значит что-то пошло не так ;)
        if ($inval) {
            switch ($inval['key']) {
                case 'forbidden':
                    Log::error('---INTERKASSA_API--------- ' . $inval['string']);
                    return $this->sendForbiddenIK($inval['string']);
                    break;
                case 'error_request':
                    Log::error('---INTERKASSA_API--------- ' . $inval['string']);
                    return $this->sendForbiddenIK($inval['string']);
                    break;
                case 'error_sign':
                    Log::error('---INTERKASSA_API--------- ' . $inval['string']);
                    return $this->sendForbiddenIK($inval['string']);
                    break;
            }
        }
        Log::info('---INTERKASSA_API--------- OK');
        //тут пишем куда передать на обработку валидные данные
        //*******************************************************************
        $x = (new addBalanceController())->apiInterkassa($request);
        //*******************************************************************

        //обязательно отвечаем серверу или он нас задолбает...
        return $this->sendOkIK();
    }
    
    /**
     * Метод создания формы или подписанных данных для Интеркассы
     * @param  Illuminate\Support\Collection $data_form
     * @param  Boolean $forma Признак возрата, форма или данные
     * @return String||mix
     */
    public function getInterkassa(Collection $data_form, $forma = TRUE)
    {
        $signed_data = $this->getSignData($data_form);
        if ($forma) {
            return $this->getFormaIK($signed_data);
        }
        return $signed_data;
    }

    /**
     * Метод создания формы для Интеркассы
     * @param  \Illuminate\Support\Collection $data_form
     * @return String
     */
    public function getFormaIK($data_form)
    {
        $html = '<form id="interkassa_payment" name="payment" method="post" action="https://sci.interkassa.com/" enctype="utf-8">';
        foreach ($data_form as $key => $value) {
            $html .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
        }
        $html .= '<input type="submit" value="interkassa_Pay" class="hidden">';
        $html .= '</form>';
        return $html;
    }


    /**
     * Метод подписывает полученные данные для формы
     * @param  Illuminate\Support\Collection Данные для подписи
     * @return Illuminate\Support\Collection  Данные с подписью
     */
    public function getSignData(Collection $data_form)
    {
        if ($data_form->isEmpty()) {
            return FALSE;
        }                                                                                                               //нет данных => нечего подписывать
        $data_form->put('ik_co_id', $this->ik_id);                                                                      //вставляем ID кассы
        $data_form->pull('ik_sign');                                                                               //удаляем из данных строку подписи
        $data_form->pull('ik_key');                                                                                //удаляем из данных строку ключа и сохраняем
        $signString = $this->getSignIK($data_form);                                                                     //получаем подпись для данных
        if ($this->ik_test) {
            $data_form->put('ik_pw_via', 'test_interkassa_test_xts');                                                   //если включен тестовый режим добавляем направление
        }
        $data_form->put('ik_sign', $signString);                                                                         //добаляем подпись к данным
        return $data_form;                                                                                              // возвращаем результат
    }


    /**
     * Метод создания цифровой подписи Интеркассы
     * @param  Illuminate\Support\Collection Коллекция , в формате Интеркассы
     * @return String||FALSE
     */
    protected function getSignIK(Collection $data_form)
    {
        if ($data_form->isEmpty()) {
            return FALSE;
        }                                                                                                               //нет данных => нечего подписывать
        $data_form->put('ik_co_id', $this->ik_id);                                                                      //вставляем ID кассы
        $data_form->pull('ik_sign');                                                                               //удаляем из данных строку подписи
        $data_form->pull('ik_key');                                                                                //удаляем из данных строку ключа и сохраняем
        $loc_a = $data_form->toArray();                                                                                 //из коллекции преобразуем в массив
        if ($this->ik_test) {
            $loc_a['ik_pw_via'] = 'test_interkassa_test_xts';                                                           //если включен тестовый режим добавляем направление
        }
        ksort($loc_a, SORT_STRING);                                                                           // сортируем по ключам в алфавитном порядке элементы массива
        array_push($loc_a, $this->ik_key);                                                                              // добавляем в конец массива "секретный ключ"
        $signString = implode(':', $loc_a);                                                                       // конкатенируем значения через символ ":"
        $sign = base64_encode(md5($signString, true));                                                       // берем MD5 хэш в бинарном виде по сформированной строке и кодируем в BASE64
        return $sign; // возвращаем результат
    }

    /**
     * Метод проверки запроса от Интеркассы на ивалидность IP, подписи
     * @param Request $request Запрос от Интеркассы
     * @return Boolean||String
     */
    protected function invalidSignIK(Request $request)
    {
        //Проверяем диапазон допустимых IP
        if ((ip2long($request->server("REMOTE_ADDR")) < ip2long('151.80.190.97'))
            || (ip2long($request->server("REMOTE_ADDR")) > ip2long('151.80.190.104'))
        ) {
            return array('key' => 'forbidden', 'string' => sprintf('Удаленный IP шлюза %s не из разрешенного диапазона', $request->server("REMOTE_ADDR")));
        }

        $qd = $request->all();                                                  //получаем данные запроса в виде массива

        //проверка, хоть каких-то данных в запросе
        if (empty($qd)) {
            return array('key' => 'error_request', 'string' => 'Пусто запрос');
        }
        //проверка, наличие ID кассы в запросе
        if (!isset($qd['ik_co_id'])) {
            return array('key' => 'error_request', 'string' => 'Нет ID кассы в запросе');
        }
        //проверка, ID кассы c настройками из кассы в файле .env
        if ($qd['ik_co_id'] != $this->ik_id) {
            return array('key' => 'error_request', 'string' => 'ID кассы неверный, провереть настройки .env');
        }
        //проверка, наличие цифровой подписи в запросе
        if (!isset($qd['ik_sign'])) {
            return array('key' => 'error_request', 'string' => 'Нет цифровой подписи в запросе');
        }
        //проверка, если пришло из тестовой системы то используем тестовый ключ
        if (isset($qd['ik_pw_via'])
            && $qd['ik_pw_via'] == 'test_interkassa_test_xts'
        ) {
            $key = $this->ik_t_key;
        } else {
            $key = $this->ik_key;
        }

        $in_sign = $qd['ik_sign'];                                                                                      //сохраняем подпись из запроса интеркассы
        unset($qd['ik_sign']);                                                                                          // удаляем из данных строку подписи
        ksort($qd, SORT_STRING);                                                                              // сортируем по ключам в алфавитном порядке элементы массива
        array_push($qd, $key);                                                                                          // добавляем в конец массива ключ/подпись
        $signString = implode(':', $qd);                                                                          // конкатенируем значения через символ ":"
        $sign = base64_encode( md5($signString, true) );                                                       // берем MD5 хэш в бинарном виде по сформированной строке и кодируем в BASE64

        //Проверка подписей
//        if ($in_sign != $sign) {
//            return array('key' => 'error_sign', 'string' => 'Не совпадают подписи ' . $signString . '    ' . $sign.' '.$in_sign);
//        }

        return FALSE;                                   //всё гуд, работайте дальше
    }


    /**
     * Метод отправляет ответ с ошибкой доступа, для Интеркассы
     * @param  String $error
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendForbiddenIK($error)
    {
        $html = "<html>
                <head>
                <meta charset='UTF-8'>
                   <title>403 Forbidden</title>
                </head>
                <body>
                    <p>$error</p>
                </body>
        </html>";
        return response($html, 403);
    }

    /**
     * Метод отправляет ответ OK, для Интеркассы
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendOkIK()
    {
        $html = "<html><head><title>200 OK</title></head></html>";
        return response($html, 200);
    }

}
