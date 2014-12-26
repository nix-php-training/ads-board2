<?php

class UserController extends Controller
{

    function loginAction()
    {
        if ($_SESSION['userRole']!='guest'){
            $this->redirect('/');
        }
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $user = $this->model->getEmail($_POST['email']);
            if ($user['email'] == $_POST['email'] && $user['password'] == $_POST['password']) {
                $_SESSION['userRole'] = $user['role'];
                $_SESSION['userName'] = $user['name'];
                $this->redirect('/');
            }
        } else {
        $this->view('content/login');
        }
    }

    function LogoutAction()
    {
        session_destroy();
        $this->redirect('/');
    }

    function registrationAction()
    {
        $this->view('content/registration');
    }

    function ConfirmAction()
    {
        $this->view($this->_name);//podklu4aem view confirm s privetstviem, formami logina i knopkoi submit
        if(isset($_POST['email']) and isset($_POST['password']) and isset($_GET['link'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $link = $_GET['link'];

            /*Zdes vuzov methoda modeli na polu4enie dannux polzovatelya v vide massiva $arr po zna4eniu linka GET['link'] i polei email, password - v tablice dolgna but odna zapis*/

            Registry::set('email', $arr['email']);//$arr polu4enui gipoteti4eskiu massive s infoi o usere v DB, berem email, password, link dlya dalneiwero sravneniya s vvedennumi v formu logina na stranice confirm
            Registry::set('password', $arr['password']);
            Registry::set('link', $arr['link']);
            $emailDb = Registry::get('email');
            $passwordDb = Registry::get('password');
            $linkDb = Registry::get('link');

            if(($email === $emailDb) and ($password === $passwordDb) and ($link === $linkDb)){
                /*ZDES Vuzov methoda modeli na izmenenie statusa usera s registred na confirmed i udalenie polya link u polzovatelya*/
                Registry::delete('email');
                Registry::delete('password');
                Registry::delete('link');
                /*vuzov actiona s zaloginenum polzovatelem na pervoi stranice*/
            }
        }


    }

    function PaypalAction()//action for Express Checkout on Paypal
    {
        $this->view($this->_name);//Отрисовуем страницу с формами для отправки данных на Paypal

        $requestParams = array(
            'RETURNURL' => 'http://ads-board2.zone/user/success',//user will return to this page when payment success
            'CANCELURL' => 'http://ads-board2.zone/user/cancelled'//user will return to this page when payment cancelled
        );

        $orderParams = array(
            'PAYMENTREQUEST_0_AMT' => '99.99',//цена услуги
            'PAYMENTREQUEST_0_SHIPPINGAMT' => '0',//расході на доставку
            'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',//валюта в трехбуквенном
            'PAYMENTREQUEST_0_ITEMAMT' => '99.99'//цена услуги без сопутствующих расходов, равна цене услуги если расходов нет
        );

        $item = array(//описание услуги, имя, описание, стоимость, количество
            'L_PAYMENTREQUEST_0_NAME0' => 'subscribe',
            'L_PAYMENTREQUEST_0_DESC0' => 'subcribe for adsboard2.zone',
            'L_PAYMENTREQUEST_0_AMT0' => '99.99',
            'L_PAYMENTREQUEST_0_QTY0' => '1'
        );

        $paypal = new Paypal();
        $response = $paypal -> request('SetExpressCheckout',$requestParams + $orderParams + $item);

        if(is_array($response) && $response['ACK'] == 'Success') { // Если запрос прошел успешно
            $token = $response['TOKEN'];//получаем токен из ответа апи
            header( 'Location: https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=' . urlencode($token) );//отправляем юзверя на пейпал для проведения оплаты
        }

        //Если пользователь подтвердил перевод средств, то Paypal отправит пользователя на указанный нами адресс с токеном

        if( isset($_GET['token']) && !empty($_GET['token']) ) { // Токен присутствует
            // Получаем детали оплаты, включая информацию о покупателе.
            // Эти данные могут пригодиться в будущем для создания, к примеру, базы постоянных покупателей
            $paypal = new Paypal();
            $checkoutDetails = $paypal -> request('GetExpressCheckoutDetails', array('TOKEN' => $_GET['token']));

            // Завершаем транзакцию
            $requestParams = array(
                'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
                'PAYERID' => $_GET['PayerID']
            );

            $response = $paypal -> request('DoExpressCheckoutPayment',$requestParams);
            if( is_array($response) && $response['ACK'] == 'Success') { // Оплата успешно проведена
                // Здесь мы сохраняем ID транзакции, может пригодиться во внутреннем учете
                $transactionId = $response['PAYMENTINFO_0_TRANSACTIONID'];
            }
        }
    }
}