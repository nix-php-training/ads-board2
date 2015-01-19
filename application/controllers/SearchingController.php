<?php

class SearchingController extends BaseController
{
    /**
     * Limit of drop-down list's items
     *
     * @var int
     */
    private $_limit = 5;

    /**
     * Do search when user clicked `see more` at drop-down list or button search at header
     */
    public function searchAction()
    {
        $query = str_replace("_", " ", $this->getParams('q'));

        if (!empty($result = $this->prepareResult($query))) {
            $this->view('content/search', ['searchResult' => $result]);
        } else {
            $this->view('content/search', ['notFound' => 'Nothing found by query: ' . $query . '']);
        }
    }

    /**
     * Do search while user typing search query
     */
    public function liveSearchAction()
    {
        if (isset($_POST['q'])) {

            $query = $_POST['q'];

            $result = $this->prepareResult($query);

            if (!empty($result)) {
                echo json_encode($result);
            }
        }
    }

    /**
     * Find ads-info in db by query
     *
     * @param $query
     * @return array
     */
    private function prepareResult($query)
    {
        $advertisement = new Advertisement();
        $result = [];

        $s = new SphinxClient();
        $s->setServer("localhost", 3307);
        $s->SetConnectTimeout(1);
        $s->SetArrayResult(true);
        $s->SetMatchMode(SPH_MATCH_ALL);
        $queryResult = $s->query($query);

        ChromePhp::log($s->GetLastError());
        ChromePhp::log($s->GetLastWarning());

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
            }
        }

        return $result;
    }
}