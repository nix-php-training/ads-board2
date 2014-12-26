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
        $this->view($this->_name);
        }
    }

    function LogoutAction()
    {
        session_destroy();
        $this->redirect('/');
    }

    function registrationAction()
    {
        $this->view($this->_name);
    }
}