<?php

class SearchController extends BaseController
{
    public function searchAction()
    {
        // get $_GET param
//        $query = $this->getParams('q');
        if (isset($_POST['q'])) {
            $query = $_POST['q'];
//        if ($query) {
            $s = new SphinxClient();
            $s->setServer("localhost", 3307);
            $s->SetConnectTimeout(1);
            $s->SetArrayResult(true);
            $s->SetMatchMode(SPH_MATCH_ALL);

            // return data to js
            echo json_encode($s->query($query));
        }
    }

    public
    function searchDetailAction()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $user = new User();

            echo json_encode($user->getBy('id', $id));
        }

    }

} 