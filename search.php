<?php

include 'framework/classes/ChromePhp.php';

if (isset($_POST['go'])) {
    if (isset($_POST['search'])) {
        $s = new SphinxClient();
        $s->setServer("localhost", 3307);
        $s->SetConnectTimeout(1);
        $s->SetArrayResult(true);

        $result = $s->query($_POST['search']);

        ChromePhp::log($s->GetLastError());
        ChromePhp::log($s->GetLastWarning());

        echo $_POST['search'];
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}


?>

<form action="#" method="post">
    <input type="text" name="search"/>
    <input type="submit" name="go" value="search"/>
</form>