<?php

include 'framework/classes/sphinxapi.php';
include 'framework/classes/ChromePhp.php';

$s = new SphinxClient();
$s->setServer("localhost", 3307);
$s->SetConnectTimeout(1);
$s->SetArrayResult(true);
$s->SetMatchMode(SPH_MATCH_ALL);

$result1 = $s->query("2015-01-13");

ChromePhp::log($result1);
echo '<pre>';
print_r($result1);
echo '</pre>';