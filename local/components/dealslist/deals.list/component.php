<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use local\components\dealslist\DealsListComponent;

$component = new DealsListComponent();
$component->executeComponent();
?>