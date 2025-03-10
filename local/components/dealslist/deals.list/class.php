<?php
namespace local\components\dealslist;

use Bitrix\Main\Loader;
use Bitrix\Crm\DealTable;
use Bitrix\Main\Type\DateTime;

class DealsListComponent extends \CBitrixComponent {
    public function executeComponent() {
        try {
            if (!Loader::includeModule('crm')) {
                throw new \Exception('Модуль CRM не установлен');
            }

            $this->arResult['DEALS'] = DealTable::getList([
                'select' => ['ID', 'TITLE', 'DATE_CREATE'],
                'order' => ['TITLE' => 'ASC'],
                'limit' => 50,
            ])->fetchAll();

            // Преобразуем даты в строки
            foreach ($this->arResult['DEALS'] as &$deal) {
                if ($deal['DATE_CREATE'] instanceof DateTime) {
                    $deal['DATE_CREATE'] = $deal['DATE_CREATE']->format('d.m.Y H:i:s');
                }
            }

            $total = DealTable::getCount();
            $this->arResult['PAGINATION'] = [
                'CURRENT_PAGE' => 1,
                'TOTAL_PAGES' => ceil($total / 50),
            ];

            $this->includeComponentTemplate();
        } catch (\Exception $e) {
            ShowError($e->getMessage());
        }
    }
}
?>