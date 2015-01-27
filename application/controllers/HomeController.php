<?php

class HomeController extends BaseController
{
    private $advertisementImgModel;
    private $advertisementModel;
    private $categoryModel;
    private $userModel;


    function __construct($params, $model)
    {
        parent::__construct($params, $model);

        $this->advertisementImgModel = new AdvertisementImages();
        $this->advertisementModel = new Advertisement();
        $this->categoryModel = new Category();
        $this->userModel = new User();
        $this->profileModel = new Profile();
    }

    public function indexAction()
    {
        try {
            // create list of last 10 posts
            $advertisementList = $this->advertisementModel->getLastAdvertisement();

            // attach images to advertisement list
            $this->advertisementImgModel->attachImagesToAdsList($advertisementList);

            $data = ['resentAds' => $advertisementList];
            $this->view('content/index', $data);
        } catch (DatabaseErrorException $e) {
            $this->view('content/index', ['message' => 'Sorry, we have nothing to show.']);
        }
    }

    public function postListAction()
    {
        $data = array();
        $categories = $this->categoryModel->getCategoriesBy(['id', 'title']);


        if(isset($_POST['category-name']))
        {
            $categorySelected =  $this->categoryModel->getCategoryByTitle($_POST['category-name']);
            $ads = $this->advertisementModel->getAdvertisementsByCategory($categorySelected[0]['id']);
            $data['categorySelected'] = $categorySelected[0]['id'];

        }else {
            $ads = $this->advertisementModel->getAllAdvertisements();
        }

        $data['categories'] = $categories;

        // attach images to advertisement list
        $this->advertisementImgModel->attachImagesToAdsList($ads);

        $data['advertisements'] = $ads;
        $this->view('content/postList', $data);
    }

    public function adsLoadAction()
    {
        $catId = $_POST['catId'];

        if ($catId == 0) {
            $ads = $this->advertisementModel->getAllAdvertisements();
        } else {
            $ads = $this->advertisementModel->getAdvertisementsByCategory($catId);
        }

        // attach images to advertisement list
        $this->advertisementImgModel->attachImagesToAdsList($ads);

        if (!empty($ads)) {
            echo json_encode($ads);
        }
    }

    public function pricingAction()
    {
        $this->view('content/pricing');
    }

    public function postDetailAction()
    {
        try {
            $id = $this->getParams('adsId');
            $ads = $this->advertisementModel->getAdvertisementById($id);

            // attach images to advertisement list
            $this->advertisementImgModel->attachImagesToAdsList($ads);

            $data = $ads[0];
            $data['profile'] = $this->profileModel->getProfile($data['userId']);

            $this->view('content/postDetail', $data);
        } catch (DatabaseErrorException $e) {
            $this->view('error/error', ['message' => $e->getMessage()]);
        }

    }

    public function addPostAction()
    {
        $this->userModel->checkCurrentPlan();/*check current plan if payments.endDate expired - reset plan to free*/
        $adsCounter = $this->userModel->checkAdsCounter();
        if ($adsCounter == 0) {
            $this->redirect('/');
            die();
        }

        $arr = Config::get('site');
        $tempUserDir = $arr['tempImagePath'] . $_SESSION['userId'];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'subject' => $subject = $_POST['subject'],
                'description' => $description = $_POST['description'],
                'price' => $price = floatval($_POST['price']),
                'creationDate' => date('Y-m-d H:i:s'),
                'categoryId' => $category = intval($_POST['category']),
                'userId' => intval($_SESSION['userId'])
            ];

            if (isset($subject) && isset($description) && isset($price) && isset($category)) {

                $adsId = $this->advertisementModel->addAdvertisement($data);
                $userDir = $arr['imagePath'] . $_SESSION['userId'] . '/' . $adsId;
                $tempImages = glob($tempUserDir . '/*.{png,jpg,gif,jpeg}', GLOB_BRACE);

                //create folder for images + folder for images preview
                mkdir($userDir . '/preview', 0777, true);

                foreach ($tempImages as $image) {
                    $temp = explode('/', $image);
                    $imageName = end($temp);
                    $targetImageName = 'img_' . $_SESSION['userId'] . '_' . $adsId . '_' . $imageName;
                    $finalImageName = $userDir . '/' . $targetImageName;

                    $data = [
                        'imageName' => $targetImageName,
                        'advertisementId' => $adsId,
                    ];
                    $this->advertisementImgModel->saveAdsImages($data);

                    rename($image, $finalImageName);
                    $this->advertisementImgModel->makeThumb($finalImageName);
                }

                rmdir($tempUserDir);

                $this->userModel->adsCounter($adsCounter);

                $this->redirect('/postlist');
            } else {
                $this->view('content/addPost');
            }

        } else {
            if (is_dir($tempUserDir)) {
                $this->rrmdir($tempUserDir);
            }
            $categories = $this->categoryModel->getCategoriesBy(['id', 'title']);
            $data['categories'] = $categories;
            $this->view('content/addPost', $data);

        }
    }

    private function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function termsAction()
    {
        $this->view('content/terms');
    }

    public function aboutAction()
    {
        $this->view('content/about');
    }

    public function imageUploadAction()
    {
        $arr = Config::get('site');

        $tempUserDir = $arr['tempImagePath'] . $_SESSION['userId'] . '/';

        if (!mkdir($tempUserDir, 0777, true)) {
        };
        $extension = explode('.', $_FILES['file']['name']);

        move_uploaded_file($_FILES['file']['tmp_name'], $tempUserDir . '/' . microtime(true) . '.' . end($extension));
    }
}
