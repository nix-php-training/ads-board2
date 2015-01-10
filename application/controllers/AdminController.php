<?php

class AdminController extends BaseController
{
    public function indexAction()
    {
        $this->usersAction();
    }

    public function usersAction()
    {
        $this->view('admin/users', [], 'admin');
    }

    public function showUsersAction()
    {
        echo json_encode($this->getModel()->getUsers());
    }

    public function plansAction()
    {
        $this->view('admin/plans', [], 'admin');
    }

    public function categoriesAction()
    {
        $this->view('admin/categories', [], 'admin');
    }

    public function advertisementsAction()
    {
        $this->view('admin/advertisements', [], 'admin');
    }

} 