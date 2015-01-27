<?php

class UserController extends BaseController
{

    private $loginInput = [
        'type' => 'text',
        'class' => 'form-control',
        'id' => 'login',
        'name' => 'login',
        'placeholder' => 'Enter login',
        'required' => ''
    ];

    private $emailInput = [
        'type' => 'email',
        'class' => 'form-control',
        'id' => 'email',
        'name' => 'email',
        'placeholder' => 'Enter email',
        'required' => ''
    ];

    private $passwordInput = [
        'type' => 'password',
        'class' => 'form-control',
        'id' => 'password',
        'name' => 'password',
        'placeholder' => 'Enter password',
        'required' => ''
    ];

    function loginAction()
    {
        // create inputs for page 'login'
        $data = [
            'email' => $this->getView()->generateInput($this->emailInput),
            'password' => $this->getView()->generateInput($this->passwordInput),
            'message' => ''
        ];

        if ($_SESSION['userRole'] != 'guest') {
            $this->redirect('/');
        }

        // for restore password
        //--------------- start----------------
        if (isset($_GET['link'])) {

            // get restore link from email
            $mailLink = $_GET['link'];

            $restore = $this->getModel()->getRestoreInfoByLink($mailLink);

            // if restoreInfoLink match mailLink
            if ($restore) {

                // get generated password
                $newPassword = $restore['newPassword'];

                // get user id
                $userId = $restore['userId'];

                // get restore info id
                $restoreInfoId = $restore['id'];


                // change password
                $this->getModel()->changePassword($userId, $newPassword);

                // delete info
                $this->getModel()->deleteRestoreInfo($restoreInfoId);

                // delete used variable
                unset($restore);

                $data['message'] = $this->getView()->generateMessage('Password was successfully changed.',
                    'success');

                // show login page
                $this->view('content/login', $data);
                exit();
            } else { // if session variables empty
                $data['message'] = $this->getView()->generateMessage('Password was changed before. Please, check your mailbox.',
                    'danger');

                // show login page
                $this->view('content/login', $data);
                exit();
            }
        }
        //--------------- end----------------

        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            if ($this->getModel()->login($email, $password)) {
                $this->redirect('/');
            } else {

                // fill inputs with values
                $data = [
                    'email' => $this->getView()->generateInput($this->emailInput, $email),
                    'password' => $this->getView()->generateInput($this->passwordInput),
                    'message' => $this->getView()->generateMessage('Incorrect username or password.', 'danger')
                ];

                $this->view('content/login', $data);
            }
        } else {
            $this->view('content/login', $data);
        }
    }

    function logoutAction()
    {
        $this->getModel()->logout();
        $this->redirect('/');
    }

    function registrationAction()
    {
        // create inputs for page 'registration'
        $data = [
            'message' => '',
            'login' => $this->getView()->generateInput($this->loginInput),
            'email' => $this->getView()->generateInput($this->emailInput),
            'password' => $this->getView()->generateInput($this->passwordInput)
        ];

        if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password'])) {
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];


            $valid = $this->getModel()->registration($login, $email, $password);
            if ($valid == 'true') {

                /*mail section*/

                $letter = new RegistrationEmail($email);//Creating object EmailSender

                $letter->send();//Sending Email with unique-link to user email
                $this->getModel()->putLink($letter->getUnique());//Unique part of link writing in DB table confirmationLinks

                /*end of mail section*/

                $this->view('content/registrationmessage');
            } else {
                $data = [
                    'login' => $this->getView()->generateInput($this->loginInput, $login),
                    'email' => $this->getView()->generateInput($this->emailInput, $email),
                    'password' => $this->getView()->generateInput($this->passwordInput, $password),
                    'message' => $this->getView()->generateMessage('Login/email is invalid or already taken.', 'danger')
                ];

                $this->view('content/registration', $data);
            }
        } else {
            $this->view('content/registration', $data);
        }
    }

    function planAction()
    {
        $planData = $this->getModel()->checkCurrentPlan();
        $this->view('content/plan', $planData);//Отрисовуем страницу с формами для отправки данных на Paypal
    }

    function successAction()
    {
        //Если пользователь подтвердил перевод средств, то Paypal отправит пользователя на указанный нами(/user/success) адресс с токеном
        $token = $this->getParams('token');
        if (isset($token) && !empty($token)) { // If Токен присутствует
            // Получаем детали оплаты, включая информацию о покупателе.
            // Эти данные могут пригодиться в будущем для создания, к примеру, базы постоянных покупателей
            $paypal = new Paypal();
            $checkoutDetails = $paypal->request('GetExpressCheckoutDetails', array('TOKEN' => $token));
            // Завершаем транзакцию
            $requestParams = array(
                'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
                'PAYERID' => $_GET['PayerID'],
                'TOKEN' => $token,
                'PAYMENTREQUEST_0_AMT' => '99.99',
            );

            $response = $paypal->request('DoExpressCheckoutPayment', $requestParams);
            if (is_array($response) && $response['ACK'] == 'Success') { // Оплата успешно проведена
                /* Здесь мы сохраняем ID транзакции, может пригодиться во внутреннем учете*/
                $transactionId = $response['PAYMENTINFO_0_TRANSACTIONID'];
                $_SESSION['transactionId'] = $transactionId;
                $planType = $_SESSION['planType'];
                $this->getModel()->changePlan($planType);
            }
        }
        $this->view('content/success');//Отрисовуем страницу на которую прийдет пользователь в случае оплаты на Paypal
    }

    function cancelledAction()
    {
        unset($_SESSION['planType']);
        $this->view('content/cancelled');//Отрисовуем страницу на которую прийдет пользователь в случае отмены оплаты на Paypal
    }

    function paypalAction()//action for Express Checkout on Paypal
    {
        $orderParams['PAYMENTREQUEST_0_SHIPPINGAMT'] = '0';//расході на доставку
        $orderParams['PAYMENTREQUEST_0_CURRENCYCODE'] = 'USD';//валюта в трехбуквенном
        switch ($this->getParams('type')) {
            case 'pro':
                $price = $this->getModel()->db->fetchOne('plans','price',['name' => 'pro']);
                $orderParams = array(
                    'PAYMENTREQUEST_0_AMT' => $price,
                    //цена услуги
                    'PAYMENTREQUEST_0_ITEMAMT' => $price
                    //цена услуги без сопутствующих расходов, равна цене услуги если расходов нет
                );

                $item = array(//описание услуги, имя, описание, стоимость, количество
                    'L_PAYMENTREQUEST_0_NAME0' => 'PRO-plan',
                    'L_PAYMENTREQUEST_0_DESC0' => 'Subscribe for PRO-plan on ads-board2.zone',
                    'L_PAYMENTREQUEST_0_AMT0' => $price,
                    'L_PAYMENTREQUEST_0_QTY0' => '1'
                );
                $_SESSION['planType'] = 'pro';
                break;
            case 'business':
                $price = $this->getModel()->db->fetchOne('plans','price',['name' => 'business']);
                $orderParams = array(
                    'PAYMENTREQUEST_0_AMT' => $price,
                    //цена услуги
                    'PAYMENTREQUEST_0_ITEMAMT' => $price
                    //цена услуги без сопутствующих расходов, равна цене услуги если расходов нет
                );

                $item = array(//описание услуги, имя, описание, стоимость, количество
                    'L_PAYMENTREQUEST_0_NAME0' => 'BUSINESS-plan',
                    'L_PAYMENTREQUEST_0_DESC0' => 'Subscribe for BUSINESS-plan on ads-board2.zone',
                    'L_PAYMENTREQUEST_0_AMT0' => $price,
                    'L_PAYMENTREQUEST_0_QTY0' => '1'
                );
                $_SESSION['planType'] = 'business';
                break;
        }

        $requestParams = array(
            'RETURNURL' => Config::get('site')['host'] . 'user/success',
            //user will return to this page when payment success
            'CANCELURL' => Config::get('site')['host'] . 'user/cancelled'
            //user will return to this page when payment cancelled
        );
        $paypal = new Paypal();

        $response = $paypal->request('SetExpressCheckout', $requestParams + $orderParams + $item);

        if (is_array($response) && $response['ACK'] == 'Success') { // Если запрос прошел успешно
            $token = $response['TOKEN'];//получаем токен из ответа апи
            echo "Ima here3";
            header('Location: https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=' . urlencode($token));//отправляем юзверя на пейпал для проведения оплаты
        }
    }

    function resetAction()
    {
        $userId = $this->getModel()->getIdByHash();
        $this->getModel()->resetPlan($userId);
        $this->redirect('/plan');
    }

    function restoreAction()
    {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];

            // check if user exist by email
            if ($this->getModel()->isUserExist($email)) { // if found

                // generate password
                $newPassword = Tools::generateUniqueString();

                try {
                    //Creating EmailSender instance
                    $letter = new RestoreEmail($email, $newPassword);

                    // save email, newPasswrod and unique link
                    $this->getModel()->saveRestoreInfo($email, $newPassword, $letter->getUnique());

                    // send letter
                    $letter->send();


                    // show message
                    $this->view('content/restoremessage');

                } catch (DatabaseErrorException $e) {
                    $this->view('error/error', ['message' => $e->getMessage()]);
                } catch (phpmailerException $e) {
                    $this->view('error/error', ['message' => $e->getMessage()]);
                } catch (PDOException $e) {
                    $this->view('error/error', ['message' => $e->getMessage()]);
                }

            } else {

                $data = [
                    'email' => $this->getView()->generateInput($this->emailInput, $email),
                    'message' => $this->getView()->generateMessage('User with this email not found.', 'danger')
                ];

                $this->view('content/restore', $data);
            }
        } else {

            $data = [
                'email' => $this->getView()->generateInput($this->emailInput),
                'message' => '',
            ];

            $this->view('content/restore', $data);
        }
    }

    function profileAction()
    {
        $this->view('content/profile');
    }

    function editProfileAction()
    {
        $this->view('content/editProfile');
    }

    function confirmAction()
    {
        $link = $this->getParams('link');

        if ($this->getModel()->checkStatus($link)) {
            header("Location: " . Config::get('site')['host'] . 'user/login');
        } else {
            $profile = new Profile();
            $profile->addProfile($link);
            $this->getModel()->changeStatus($link);
            $this->getModel()->getFreePlan($link);
            $this->view('content/confirm');
        }
    }
}