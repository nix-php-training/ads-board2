<?php

class UserController extends Controller
{

    function loginAction()
    {
        $this->view($this->_name);
    }

    function registrationAction()
    {
        $this->view($this->_name);
    }

    function ConfirmAction()
    {
        $this->view->generate('confirm.phtml', 'layout.phtml');//podklu4aem view confirm s privetstviem, formami logina i knopkoi submit
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
}