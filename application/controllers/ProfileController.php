<?php

class ProfileController extends BaseController
{

    protected $userId;

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
        'id' => 'inputWarning1',
        'name' => 'email',
        'placeholder' => 'Enter email',
        'required' => ''
    ];

    private $oldPasswordInput = [
        'type' => 'password',
        'class' => 'form-control',
        'id' => 'old-password',
        'name' => 'old-password',
        'placeholder' => 'Password',
    ];

    private $newPasswordInput = [
        'type' => 'password',
        'class' => 'form-control',
        'id' => 'new-password',
        'name' => 'new-password',
        'placeholder' => 'Password',
    ];

    private $fullNameInput = [
        'type' => 'text',
        'class' => 'form-control',
        'id' => 'frame',
        'name' => 'fullName',
        'placeholder' => 'Enter full name',
    ];


    private $telInput = [
        'type' => 'tel',
        'class' => 'form-control',
        'id' => 'phone',
        'name' => 'phone',
        'placeholder' => 'Enter phone number',
    ];

    private $skypeInput = [
        'type' => 'text',
        'class' => 'form-control',
        'id' => 'skype',
        'name' => 'skype',
        'placeholder' => 'Enter skype nickname',
    ];

    private $birthdayInput = [
        'type' => 'text',
        'class' => 'form-control',
        'id' => 'birthday',
        'name' => 'birthday',
        'placeholder' => 'Enter skype nickname',
    ];

    public function profileAction()
    {
        $userId = $this->getParams('user');
        if ($userId) {
            $this->userId = $userId;
        } elseif (isset($_SESSION['userId'])){
            $this->userId = $_SESSION['userId'];
        } else {
            $this->redirect('/error404');
        }
        $data = $this->getModel()->getProfile($this->userId);
        if ($data){
            $data['login'] = $this->getModel()->db->fetchOne('users', 'login', ['id' => $this->userId]);
            $this->view('content/profile', $data);
        } else {
            $this->redirect('/error404');
        }

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
            'fullName',
            'phone',
            'skype',
            'birthday'
        ]);


        $this->userId = $_SESSION['userId'];
        $users = new User();
        $profile = $this->getModel()->getProfile($this->userId);
        $user = $users->getBy('id', $this->userId);

        $data['user'] = $user;
        $data['profile'] = $profile;

        if (!empty($post['user']) && !empty($post['profile'])) {
            $validateProfile = $this->getModel()->validate($post['profile']);
            if (empty($validateProfile)) {
                $userSave = $users->update($post['user']);
                if ($userSave !== true) {
                    var_dump($this->getView()->simplifyValidate($userSave));
                } elseif ($userSave == true) {
                    $this->getModel()->update($post['profile'], $this->userId);
                    $_SESSION['saveChanges'] = true;
                    $this->redirect('/profile');
                }
            } else {
                var_dump($this->getView()->simplifyValidate($validateProfile));
            }
        }

        if ($post['user'] == false || $post['profile'] == false) {
            $this->view('content/editProfile', $data);
        }
    }
} 