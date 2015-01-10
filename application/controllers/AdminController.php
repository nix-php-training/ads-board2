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

    public function banUserAction()
    {
        $id = $_POST['id'];
        $this->getModel()->banUser($id);
    }

    public function unbanUserAction()
    {
        $id = $_POST['id'];
        $this->getModel()->unbanUser($id);
    }

    public function editPlanAction()
    {

    }

    public function createPlanAction()
    {

    }

    public function removePlanAction()
    {

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