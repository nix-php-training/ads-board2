<?php

class ProfileController extends BaseController{

    protected $userId;

    function profileAction()
    {
        $userId = $this->getParams('user');
        if ($userId){
            $this->userId = $userId;
        } else {
            $this->userId = $_SESSION['userId'];
        }
        $profile = $this->getModel()->getProfile($this->userId);
        Registry::set('profile', $profile);
        $this->view('content/profile');
    }

    function editProfileAction()
    {
        $this->view('content/editProfile');
    }
} 