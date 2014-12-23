<?php

class UserController extends Controller
{

    function loginAction()
    {
        if ($_SESSION['userRole']!='guest'){
            $this->redirect('/');
        }
        if (isset($_POST['email']) && isset($_POST['email'])) {
            $users = Config::get('users');
            if (is_array($users)) {
                foreach ($users as $k) {
                    if ($k['email'] == $_POST['email'] && $k['password'] == $_POST['password']) {
                        $_SESSION['userRole'] = $k['role'];
                        $_SESSION['userName'] = $k['name'];
                        $this->redirect('/');
                    }
                }
            }
        } else {
            $this->view($this->_name);
        }
    }

    function LogoutAction(){
        session_destroy();
        $this->redirect('/');
    }

    function registrationAction()
    {
        $this->view($this->_name);
    }
}