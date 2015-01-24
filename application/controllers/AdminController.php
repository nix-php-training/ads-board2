<?php

/**
 * Class AdminController
 *
 * Provides functions for works admin-panel.
 *
 * User's functions:
 * - retrieve data about users;
 * - change user's status (banned/unbanned).
 *
 * Plan's functions:
 * - retrieve/create/update/delete plans.
 *
 * Category's functions:
 * - retrieve/create/update/delete categories.
 *
 * Advertisement's functions:
 * - retrieve/delete advertisements.
 */
class AdminController extends BaseController
{
    /**
     * @var User
     */
    private $userModel;

    /**
     * @var Plan
     */
    private $planModel;

    /**
     * @var Advertisement
     */
    private $advertisementModel;

    /**
     * @var Category
     */
    private $categoryModel;

    function __construct($params, $model)
    {
        parent::__construct($params, $model);

        $this->userModel = new User();
        $this->planModel = new Plan();
        $this->advertisementModel = new Advertisement();
        $this->categoryModel = new Category();
    }

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
        echo json_encode($this->userModel->getUsers());
    }

    /**
     * Ban user
     *
     * @var $_POST ['id'] is user id from user management page
     */
    public function banUserAction()
    {
        $id = $_POST['id'];
        $this->userModel->banUser($id);
    }

    /**
     * Unban user
     *
     * @var $_POST ['id'] is user id from user management page
     */
    public function unbanUserAction()
    {
        $id = $_POST['id'];
        $this->userModel->unbanUser($id);
    }

    //--------- Plan functions--------------

    /**
     * Save info about plan
     * or
     * create new plan if plan with $_POST parameters is not exist
     */
    public function savePlanAction()
    {
        $this->planModel->savePlan($_POST);
    }

    /**
     * Delete plan from db
     *
     * @var $_POST ['id'] is plan id from plan management page
     */
    public function removePlanAction()
    {
        $id = $_POST['id'];
        $this->planModel->removePlan($id);
    }

    /**
     * Get info about plans from db
     */
    public function getPlansAction()
    {
        echo json_encode($this->planModel->getPlans());
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
        $this->categoryModel->saveCategory($_POST);
    }

    /**
     * Delete category from db
     *
     * @var $_POST ['id'] is category id from category management page
     */
    public function removeCategoryAction()
    {
        $id = $_POST['id'];
        $this->categoryModel->removeCategory($id);
    }

    /**
     * Get info about categories from db
     */
    public function getCategoriesAction()
    {
        echo json_encode($this->categoryModel->getCategoriesBy(['id', 'title', 'description']));
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
        echo json_encode($this->advertisementModel->getAllAdvertisementsWithImages());
    }

    /**
     * Delete advertisement from db
     *
     * @var $_POST ['id'] is advertisement id from advertisement management page
     */
    public function removeAdvertisementAction()
    {
        $id = $_POST['id'];
        $this->advertisementModel->removeAdvertisement($id);
    }
} 