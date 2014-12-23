<?php

class UserController extends Controller
{

    function loginAction()
    {
        $this->view($this->_name);
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
            $this->view->generate('login.phtml', 'layout.phtml');
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