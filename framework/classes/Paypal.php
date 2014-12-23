<?php
class Paypal {
    /**
     * Последние сообщения об ошибках
     * @var array
     */
    protected $errors = array();

    /**
     * Данные API
     * Обратите внимание на то, что для песочницы нужно использовать соответствующие данные
     * @var array
     */
    protected $credentials = array(
        'USER' => 'ch.kyrill-facilitator_api1.gmail.com',
        'PWD' => 'HTNT6R6EEH7Z76R6',
        'SIGNATURE' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AE.YSMq7OL6JtrdUhwzcO0-hJ0Az',
    );

    /**
     * Указываем, куда будет отправляться запрос
     * Реальные условия - https://api-3t.paypal.com/nvp
     * Песочница - https://api-3t.sandbox.paypal.com/nvp
     * @var string
     */
    protected $endPoint = 'https://api-3t.sandbox.paypal.com/nvp';

    /**
     * Версия API
     * @var string
     */
    protected $version = '98.0';

    /**
     * Сформировываем запрос
     *
     * @param string $method Данные о вызываемом методе перевода
     * @param array $params Дополнительные параметры
     * @return array / boolean Response array / boolean false on failure
     */
    public function request($method,$params = array()) {
        $this -> errors = array();
        if( empty($method) ) { // Проверяем, указан ли способ платежа
            $this -> errors = array('Не указан метод перевода средств');
            return false;
        }

        // Параметры нашего запроса
        $requestParams = array(
                'METHOD' => $method,
                'VERSION' => $this -> version
            ) + $this -> credentials;

        // Сформировываем данные для NVP
        $request = http_build_query($requestParams + $params);

        // Настраиваем cURL
        $curlOptions = array (
            CURLOPT_URL => $this -> endPoint,
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_CAINFO => ROOT_PATH . '/cacert.pem', // Файл сертификата
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $request
        );

        $ch = curl_init();
        curl_setopt_array($ch,$curlOptions);

        // Отправляем наш запрос, $response будет содержать ответ от API
        $response = curl_exec($ch);

        // Проверяем, нету ли ошибок в инициализации cURL
        if (curl_errno($ch)) {
            $this -> errors = curl_error($ch);
            curl_close($ch);
            var_dump($this->errors);
            return false;
        } else  {
            curl_close($ch);
            $responseArray = array();
            parse_str($response,$responseArray); // Разбиваем данные, полученные от NVP в массив
            return $responseArray;
        }
    }
}


//////////////////////////////////////////////////////////////////////////////////////////////
/*The following cURL command makes an Express Checkout call to the Sandbox with my account data*/
//curl -s --insecure https://api-3t.sandbox.paypal.com/nvp -d
//"USER = ch.kyrill-facilitator_api1.gmail.com
//PWD = HTNT6R6EEH7Z76R6
//SIGNATURE = AFcWxV21C7fd0v3bYYYRCpSSRl31AE.YSMq7OL6JtrdUhwzcO0-hJ0Az
//METHOD = SetExpressCheckout
//VERSION = 98
//PAYMENTREQUEST_0_AMT = 10
//PAYMENTREQUEST_0_CURRENCYCODE = USD
//PAYMENTREQUEST_0_PAYMENTACTION = SALE
//cancelUrl = http://www.example.com/cancel.html
//returnUrl = http://www.example.com/success.html"
