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
        'placeholder' => 'Enter birthday',
    ];

    public function profileAction()
    {
        $userId = $this->getParams('user');
        if ($userId) {
            $this->userId = $userId;
        } elseif (isset($_SESSION['userId'])) {
            $this->userId = $_SESSION['userId'];
        } else {
            $this->redirect('/error404');
        }
        $data = $this->getModel()->getProfile($this->userId);
        if ($data['birthday'] == 0000-00-00)
            $data['birthday'] = '';
        if ($data) {
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

        $base['user'] = $user;
        $base['profile'] = $profile;
        if ($base['profile']['birthday'] == 0000-00-00)
            $base['profile']['birthday'] = '';

        $data = [
            'login' => $this->getView()->generateInput($this->loginInput, $base['user']['login']),
            'email' => $this->getView()->generateInput($this->emailInput, $base['user']['email']),
            'old-password' => $this->getView()->generateInput($this->oldPasswordInput),
            'new-password' => $this->getView()->generateInput($this->newPasswordInput),
            'fullName' => $this->getView()->generateInput($this->fullNameInput, $base['profile']['fullName']),
            'phone' => $this->getView()->generateInput($this->telInput, $base['profile']['phone']),
            'skype' => $this->getView()->generateInput($this->skypeInput, $base['profile']['skype']),
            'birthday' => $this->getView()->generateInput($this->birthdayInput, $base['profile']['birthday']),
        ];

        if (!empty($post['user']) && !empty($post['profile'])) {

            if ($post['user']['login'] !== $base['user']['login'])
                $data['login'] = $this->getView()->generateInput($this->loginInput, $post['user']['login']);
            if ($post['user']['email'] !== $base['user']['email'])
                $data['email'] = $this->getView()->generateInput($this->emailInput, $post['user']['email']);
            if ($post['profile']['fullName'] !== $base['profile']['fullName'])
                $data['fullName'] = $this->getView()->generateInput($this->fullNameInput, $post['profile']['fullName']);
            if ($post['profile']['phone'] !== $base['profile']['phone'])
                $data['phone'] = $this->getView()->generateInput($this->telInput, $post['profile']['phone']);
            if ($post['profile']['skype'] !== $base['profile']['skype'])
                $data['skype'] = $this->getView()->generateInput($this->skypeInput, $post['profile']['skype']);
            if ($post['profile']['birthday'] !== $base['profile']['birthday'])
                $data['birthday'] = $this->getView()->generateInput($this->birthdayInput, $post['profile']['birthday']);



                $validateProfile = $this->getModel()->validate($post['profile']);
            if (empty($validateProfile)) {
                $userSave = $users->update($post['user']);
                if ($userSave !== true) {
                    $error = $this->getView()->errorToMessage($userSave);
                    $data['message'] = $this->getView()->generateMessage($error, 'danger');
                    $this->view('content/editProfile', $data);
                } elseif ($userSave == true) {
                    $this->getModel()->update($post['profile'], $this->userId);
                    $_SESSION['saveChanges'] = true;
                    $this->redirect('/profile');
                }
            } else {
                $error = $this->getView()->errorToMessage($validateProfile, 'danger');
                $data['message'] = $this->getView()->generateMessage($error, 'danger');
                $this->view('content/editProfile', $data);
            }
        }

        if ($post['user'] == false || $post['profile'] == false) {
            $this->view('content/editProfile', $data);
        }
    }
} 