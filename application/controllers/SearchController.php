<?php

class SearchController extends BaseController
{
    private $_limit = 5;

    public function searchAction()
    {

        if (isset($_POST['q'])) {
            $query = $_POST['q'];
            $user = new User();
            $result = [];

            $s = new SphinxClient();
            $s->setServer("localhost", 3307);
            $s->SetConnectTimeout(1);
            $s->SetArrayResult(true);
            $s->SetMatchMode(SPH_MATCH_ALL);
            $queryResult = $s->query($query);

            if ($queryResult) {
                if (array_key_exists('matches', $queryResult)) {

                    $matches = $queryResult['matches'];

                    $l = (count($matches) <= $this->_limit) ? count($matches) : $this->_limit;

                    for ($i = 0; $i < $l; $i += 1) {
                        $match = $matches[$i];

                        if (array_key_exists('id', $match)) {
                            $result [] = $user->getBy('id', $match['id']);
                        }
                    }
                    // return data to js
                    echo json_encode($result);
                }
            }
        }
    }
} 