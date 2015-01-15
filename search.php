<?php

include 'framework/classes/sphinxapi.php';

$s = new SphinxClient();
$s->setServer("localhost", 3307);
$s->SetConnectTimeout(1);
$s->SetArrayResult(true);
$s->SetMatchMode(SPH_MATCH_ALL);

$result1 = $s->query("stas");
$result2 = $s->query("1");

//ChromePhp::log($result1);
echo '<pre>';
print_r($result1);
echo '</pre>';

echo '<pre>';
print_r($result2);
echo '</pre>';