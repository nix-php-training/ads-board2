<?php

class RegisterController extends Controller
{
    public function action()
    {
        $data = Requests::post();

        if (isset($data['register'])) {

            $code = $this->registerAction($data);

            $tmp = ViewHelper::generateMessageData($code);

            ChromePhp::log($tmp);

            $this->view($this->_name, $tmp);
        } else {
            parent::action();
        }
    }

    private function registerAction($data)
    {
        $user = new UserModel($data);
        $userConnection = new UserConnection();

        $code = $userConnection->register($user->getUser());

        return $code;

    }
} 