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


    public function getUsersAction()
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

    public function savePlanAction()
    {
        $this->getModel()->savePlan($_POST);
    }

    public function removePlanAction()
    {
        $id = $_POST['id'];
        $this->getModel()->removePlan($id);
    }

    public function getPlansAction()
    {
        echo json_encode($this->getModel()->getPlans());
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