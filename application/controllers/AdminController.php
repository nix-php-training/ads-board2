<?php

class AdminController extends BaseController
{
    public function indexAction()
    {
        $this->usersAction();
    }

    //--------- User functions--------------

    /**
     * Render user management page
     */
    public function usersAction()
    {
        $this->view('admin/users', [], 'admin');
    }

    /**
     * Get data of users from db
     */
    public function getUsersAction()
    {
        echo json_encode($this->getModel()->getUsers());
    }

    /**
     * Ban user
     *
     * @var $_POST['id'] is user id from user management page
     */
    public function banUserAction()
    {
        $id = $_POST['id'];
        $this->getModel()->banUser($id);
    }

    /**
     * Unban user
     *
     * @var $_POST['id'] is user id from user management page
     */
    public function unbanUserAction()
    {
        $id = $_POST['id'];
        $this->getModel()->unbanUser($id);
    }

    //--------- Plan functions--------------

    /**
     * Save info about plan
     * or
     * create new plan if plan with $_POST parameters is not exist
     */
    public function savePlanAction()
    {
        $this->getModel()->savePlan($_POST);
    }

    /**
     * Delete plan from db
     *
     * @var $_POST['id'] is plan id from plan management page
     */
    public function removePlanAction()
    {
        $id = $_POST['id'];
        $this->getModel()->removePlan($id);
    }

    /**
     * Get info about plans from db
     */
    public function getPlansAction()
    {
        echo json_encode($this->getModel()->getPlans());
    }

    /**
     * Render plan management page
     */
    public function plansAction()
    {
        $this->view('admin/plans', [], 'admin');
    }

    //--------- Category functions--------------

    /**
     * Save info about category
     * or
     * create new category if category with $_POST parameters is not exist
     */
    public function saveCategoryAction()
    {
        $this->getModel()->saveCategory($_POST);
    }

    /**
     * Delete category from db
     *
     * @var $_POST['id'] is category id from category management page
     */
    public function removeCategoryAction()
    {
        $id = $_POST['id'];
        $this->getModel()->removeCategory($id);
    }

    /**
     * Get info about categories from db
     */
    public function getCategoriesAction()
    {
        echo json_encode($this->getModel()->getCategories());
    }

    /**
     * Render category management page
     */
    public function categoriesAction()
    {
        $this->view('admin/categories', [], 'admin');
    }

    //--------- Advertisements functions--------------
    /**
     * Render advertisements management page
     */
    public function advertisementsAction()
    {
        $this->view('admin/advertisements', [], 'admin');
    }

    /**
     * Get info about advertisements from db
     */
    public function getAdvertisementsAction()
    {
        echo json_encode($this->getModel()->getAds());
    }

    /**
     * Delete advertisement from db
     *
     * @var $_POST['id'] is advertisement id from advertisement management page
     */
    public function removeAdvertisementAction()
    {
        $id = $_POST['id'];
        $this->getModel()->removeAds($id);
    }
} 