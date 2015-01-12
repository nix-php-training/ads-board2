<?php

class ProfileController extends BaseController
{

    protected $userId;

    public function profileAction()
    {
        $userId = $this->getParams('user');
        if ($userId) {
            $this->userId = $userId;
        } else {
            $this->userId = $_SESSION['userId'];
        }
        $data = $this->getModel()->getProfile($this->userId);
        $this->view('content/profile', $data);
    }

    public function editProfileAction()
    {
        $post['user'] = $this->getPost([
                'login',
                'email',
                'old-password',
                'new-password',
            ]);

        $post['profile'] = $this->getPost([
            'firstname',
            'lastname',
            'phone',
            'skype'
        ]);
var_dump($post);

        $this->userId = $_SESSION['userId'];
        $users = new User();
        $profile = $this->getModel()->getProfile($this->userId);
        $user = $users->getBy('id', $this->userId);

//        $users->update($post['user']);

        $data['user'] = $user;
        $data['profile'] = $profile;
        $aaa = $users->update($post['user']);
//        if (is_array($aaa)){
//            var_dump($aaa);
//        }
        $this->view('content/editProfile', $data);
    }
} 