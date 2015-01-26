<?php

/**
 * Class SearchingController
 *
 * Provides functions for works with search:
 * - retrieve data from db by text-type query;
 * - render query-result as page;
 * - return query-result as json-data.
 */
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
            $this->view('content/search', ['searchResult' => $result, 'imgHost' => Config::get('site')['imageLink']]);
        } else {
            $this->view('content/search', ['notFound' => 'Nothing found by query: ' . $query . '']);
        }
    }

    /**
     * Find ads-info in db by query
     *
     * @uses SearchingController::searchAction
     * @uses SearchingController::liveSearchAction
     * @param $query
     * @return array
     */
    private function prepareResult($query)
    {
        $advertisement = new Advertisement();
        $result = [];

        $s = new SphinxClient();
        $s->setServer("localhost", 3307);
        $s->SetArrayResult(true);
        $queryResult = $s->query($query);

        // expects $result['matches']
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

        return $result;
    }

    /**
     * Do search while user typing search query
     *
     * Data sends to jQuery script
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
}