<?php

class SearchController extends BaseController
{
    private $_limit = 5;

    public function searchAction()
    {


        $query = str_replace("_", " ", $this->getParams('q'));

        if (isset($_POST['q'])) {
            $query = $_POST['q'];
        }

        $advertisement = new Advertisement();
        $result = [];

        $s = new SphinxClient();
        $s->setServer("localhost", 3307);
        $s->SetConnectTimeout(1);
        $s->SetArrayResult(true);
        $s->SetMatchMode(SPH_MATCH_ALL);
        $queryResult = $s->query($query);

//            ChromePhp::log($queryResult);

        if ($queryResult) {
            if (array_key_exists('matches', $queryResult)) {

                $matches = $queryResult['matches'];

                $l = (count($matches) <= $this->_limit) ? count($matches) : $this->_limit;

                for ($i = 0; $i < $l; $i += 1) {
                    $match = $matches[$i];

                    if (array_key_exists('id', $match)) {
                        $result [] = $advertisement->getFromCatalogById($match['id']);
                    }
                }
                // return data to js
                echo json_encode($result);
            }
        }
    }
}