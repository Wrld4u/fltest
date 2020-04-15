<?php

class Inn
{

    /**
     * Данная конкретная функция была получена со следующего источника:
     * Сайт: http://www.kholenkov.ru/data-validation/inn/
     * Источник: https://github.com/Kholenkov/php-data-validation/blob/master/src/DataValidation.php
     *
     * @param string $inn
     * @param mixed $error_message
     * @param mixed $error_code
     * @return boolean
     */
    public static function validateInn($inn, &$error_message = null, &$error_code = null) {
        $result = false;
        $inn = (string) $inn;
        if (!$inn) {
            $error_code = 1;
            $error_message = 'ИНН пуст';
        } elseif (preg_match('/[^0-9]/', $inn)) {
            $error_code = 2;
            $error_message = 'ИНН может состоять только из цифр';
        } elseif (!in_array($inn_length = strlen($inn), [10, 12])) {
            $error_code = 3;
            $error_message = 'ИНН может состоять только из 10 или 12 цифр';
        } else {
            $check_digit = function($inn, $coefficients) {
                $n = 0;
                foreach ($coefficients as $i => $k) {
                    $n += $k * (int) $inn{$i};
                }
                return $n % 11 % 10;
            };
            switch ($inn_length) {
                case 10:
                    $n10 = $check_digit($inn, [2, 4, 10, 3, 5, 9, 4, 6, 8]);
                    if ($n10 === (int) $inn{9}) {
                        $result = true;
                    }
                    break;
                case 12:
                    $n11 = $check_digit($inn, [7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);
                    $n12 = $check_digit($inn, [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);
                    if (($n11 === (int) $inn{10}) && ($n12 === (int) $inn{11})) {
                        $result = true;
                    }
                    break;
            }
            if (!$result) {
                $error_code = 4;
                $error_message = 'Неправильное контрольное число';
            }
        }
        return $result;
    }

    /**
     * @param $inn
     * @param null $error_message
     * @param null $error_code
     * @return int|mixed
     */
    public static function getStatus($inn, &$error_message = null, &$error_code = null){
        $result = 0;
        if( $curl = curl_init() ) {

            $data = json_encode(['inn' => $inn, "requestDate" => date('Y-m-d', time())]);

            curl_setopt($curl, CURLOPT_URL, 'https://statusnpd.nalog.ru:443/api/v1/tracker/taxpayer_status');
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $res = curl_exec($curl);
            curl_close($curl);
            $result = $res;
        } else {
            $error_code = 5;
            $error_message = 'Не удалось инициализировать CURl';
        }
        return $result;
    }


    public static function inBase($inn, &$error_message = null, &$error_code = null) {
        $innDB = R::findOne( 'users', 'inn = ?', [$inn]);
        //если нет записи в БД или прошло более 24 часов
        if (empty($innDB)) {
            $res = json_decode(self::getStatus($inn), true);

            $user = R::dispense('users');
            $user->inn = $inn;
            $user->msg = $res['message'];
            $user->status = $res['status'];
            $user->created = time();
            R::store($user);
            return json_encode($res);
        } else {
            if ($innDB['created']+60*60*24 < time()) {
                $res = json_decode(self::getStatus($inn), true);
                if (!isset($res['code'])){
                    $innDB->msg = $res['message'];
                    $innDB->status = $res['status'];
                    $innDB->created = time();
                    R::store($innDB);
                }
                return json_encode($res);
            } else {
                return json_encode(['message' => $innDB['msg'], 'status' => $innDB['status'], 'code' => null]);
            }
        }
    }

}