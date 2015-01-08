<?php

class UserController extends BaseController
{

    function loginAction()
    {
        if ($_SESSION['userRole'] != 'guest') {
            $this->redirect('/');
        }
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            if ($this->getModel()->login($email, $password)) {
                $this->redirect('/');
            } else {
                echo 'Введены не верные данные';
            }
        } else {
            $this->view('content/login');
        }
    }

    function logoutAction()
    {
        $this->getModel()->logout();
        $this->redirect('/');
    }

    function registrationAction()
    {
        if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password'])) {
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $valid = $this->getModel()->registration($login, $email, $password);
            if (!is_array($valid)) {
                echo 'Вы зарегистрированы';
            } else {
                var_dump($valid);
            }
        } else {
            $this->view('content/registration');
        }
    }

    function planAction()
    {
        $this->view('content/plan');//Отрисовуем страницу с формами для отправки данных на Paypal
    }

    function paypalAction()//action for Express Checkout on Paypal
    {
        $orderParams['PAYMENTREQUEST_0_SHIPPINGAMT'] = '0';//расході на доставку
        $orderParams['PAYMENTREQUEST_0_CURRENCYCODE'] = 'USD';//валюта в трехбуквенном
        switch ($this->getParams('type')) {
            case 'pro':
                $orderParams = array(
                    'PAYMENTREQUEST_0_AMT' => '99.99',//цена услуги
                    'PAYMENTREQUEST_0_ITEMAMT' => '99.99'//цена услуги без сопутствующих расходов, равна цене услуги если расходов нет
                );

                $item = array(//описание услуги, имя, описание, стоимость, количество
                    'L_PAYMENTREQUEST_0_NAME0' => 'PRO-plan',
                    'L_PAYMENTREQUEST_0_DESC0' => 'Subcribe for PRO-plan on ads-board2.zone',
                    'L_PAYMENTREQUEST_0_AMT0' => '99.99',
                    'L_PAYMENTREQUEST_0_QTY0' => '1'
                );
                break;
            case 'business':
                $orderParams = array(
                    'PAYMENTREQUEST_0_AMT' => '999.9',//цена услуги
                    'PAYMENTREQUEST_0_ITEMAMT' => '999.9'//цена услуги без сопутствующих расходов, равна цене услуги если расходов нет
                );

                $item = array(//описание услуги, имя, описание, стоимость, количество
                    'L_PAYMENTREQUEST_0_NAME0' => 'BUSINESS-plan',
                    'L_PAYMENTREQUEST_0_DESC0' => 'Subcribe for BUSINESS-plan on ads-board2.zone',
                    'L_PAYMENTREQUEST_0_AMT0' => '999.9',
                    'L_PAYMENTREQUEST_0_QTY0' => '1'
                );
                break;
        }

        $requestParams = array(
            'RETURNURL' => Config::get('site')['host'] . 'user/success',//user will return to this page when payment success
            'CANCELURL' => Config::get('site')['host'] . 'user/cancelled'//user will return to this page when payment cancelled
        );

        $paypal = new Paypal();
        $response = $paypal->request('SetExpressCheckout', $requestParams + $orderParams + $item);

        if (is_array($response) && $response['ACK'] == 'Success') { // Если запрос прошел успешно
            $token = $response['TOKEN'];//получаем токен из ответа апи
            header('Location: https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=' . urlencode($token));//отправляем юзверя на пейпал для проведения оплаты
        }

        //Если пользователь подтвердил перевод средств, то Paypal отправит пользователя на указанный нами адресс с токеном

        if (isset($_GET['token']) && !empty($_GET['token'])) { // Токен присутствует
            // Получаем детали оплаты, включая информацию о покупателе.
            // Эти данные могут пригодиться в будущем для создания, к примеру, базы постоянных покупателей
            $paypal = new Paypal();
            $checkoutDetails = $paypal->request('GetExpressCheckoutDetails', array('TOKEN' => $this->getParams('token')));

            // Завершаем транзакцию
            $requestParams = array(
                'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
                'PAYERID' => $_GET['PayerID']
            );

            $response = $paypal->request('DoExpressCheckoutPayment', $requestParams);
            if (is_array($response) && $response['ACK'] == 'Success') { // Оплата успешно проведена
                // Здесь мы сохраняем ID транзакции, может пригодиться во внутреннем учете
                $transactionId = $response['PAYMENTINFO_0_TRANSACTIONID'];
            }
        }
    }

    function restoreAction()
    {
        $this->view('content/restore');
    }

    function profileAction()
    {
        $this->view('content/profile');
    }

    function editProfileAction()
    {
        $this->view('content/editProfile');
    }
}