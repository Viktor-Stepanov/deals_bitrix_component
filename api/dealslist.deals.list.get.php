<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Crm\DealTable;

Loader::includeModule('crm');

// Параметры запроса
$page = (int)$_GET['page'] ?? 1;
$sortField = $_GET['sortField'] ?? 'TITLE'; // Поле для сортировки
$sortDirection = ($_GET['sortDirection'] ?? 'ASC') === 'ASC' ? 'ASC' : 'DESC'; // Направление сортировки

// Лимит записей на странице
$limit = 50;
$offset = ($page - 1) * $limit;

// Получение данных
$filter = []; // Здесь можно добавить фильтры, если нужно
$select = ['ID', 'TITLE', 'DATE_CREATE'];
$order = [$sortField => $sortDirection];

$deals = DealTable::getList([
    'select' => $select,
    'filter' => $filter,
    'order' => $order,
    'limit' => $limit,
    'offset' => $offset,
])->fetchAll();

// Преобразование дат
foreach ($deals as &$deal) {
    if ($deal['DATE_CREATE'] instanceof \Bitrix\Main\Type\DateTime) {
        $deal['DATE_CREATE'] = $deal['DATE_CREATE']->format('d.m.Y H:i:s');
    }
}

// Подсчёт общего количества записей
$total = DealTable::getCount($filter);

// Ответ в формате JSON
header('Content-Type: application/json');
echo json_encode([
    'deals' => $deals,
    'currentPage' => $page,
    'totalPages' => ceil($total / $limit),
]);
?>