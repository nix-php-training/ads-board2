<?php

class HomeController extends BaseController
{
    function indexAction()
    {
        $this->view('content/index');
    }

    function postListAction()
    {
        $categories = (new Category())->getCategoriesBy(['id', 'title']);
        $ads = (new Advertisement())->getAllAdvertisements();

// TODO: use strtotime to manipulate with creationDate + date ()
        $data['categories'] = $categories;
        $ads = (new Advertisement())->splitCreationDate($ads);

        var_dump($ads);
        $data['advertisements'] = $ads;
        $this->view('content/postList', $data);

    }

    function pricingAction()
    {
        $this->view('content/pricing');
    }

    function postDetailAction()
    {
        $this->view('content/postDetail');
    }

    function addPostAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'subject' => $subject = $_POST['subject'],
                'description' => $description = $_POST['description'],
                'price' => $price = floatval($_POST['price']),
                'creationDate' => date('Y-m-d H:i:s'),
                'categoryId' => $category = intval($_POST['category']),
                'userId' => intval($_SESSION['userId'])
            ];
            var_dump($data);

            if (isset($subject) && isset($description) && isset($price) && isset($category)) {
                (new Advertisement())->addAdvertisement($data);
                $this->redirect('/postlist');
            } else $this->view('content/addPost');

        }else{
            $categories = (new Category())->getCategoriesBy(['id', 'title']);
            $data['categories'] = $categories;
            $this->view('content/addPost', $data);

        }
    }

        function termsAction()
        {
            $this->view('content/terms');
        }

        function aboutAction()
        {
            $this->view('content/about');
        }

        // for image download example
        // will be moved to correct controller
        function imageDownloadAction()
        {
            ChromePhp::log($_FILES);
        }
    }