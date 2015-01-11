<?php

class AdminController extends BaseController
{
    public function indexAction()
    {
        $this->usersAction();
    }

    //--------- User functions--------------
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

    //--------- Plan functions--------------
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

    //--------- Category functions--------------
    public function saveCategoryAction()
    {
        $this->getModel()->saveCategory($_POST);
    }

    public function removeCategoryAction()
    {
        $id = $_POST['id'];
        $this->getModel()->removeCategory($id);
    }

    public function getCategoriesAction()
    {
        echo json_encode($this->getModel()->getCategories());
    }

    public function categoriesAction()
    {
        $this->view('admin/categories', [], 'admin');
    }

    //--------- Advertisements functions--------------
    public function advertisementsAction()
    {
        $this->view('admin/advertisements', [], 'admin');
    }

    public function getAdvertisementsAction()
    {
        echo json_encode($this->getModel()->getAds());
    }

    public function removeAdvertisementAction()
    {
        $id = $_POST['id'];
        $this->getModel()->removeAds($id);
    }
} 