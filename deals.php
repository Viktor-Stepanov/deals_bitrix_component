<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Список сделок");

$APPLICATION->IncludeComponent(
    "dealslist:deals.list",
    ".default",
    []
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>