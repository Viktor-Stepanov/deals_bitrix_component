# Компонент "Список сделок"

Компонент для вывода списка сделок с пагинацией и сортировкой.

## Структура
- `api/dealslist.deals.list.get.php` — API-контроллер для получения данных.
- `local/components/dealslist/deals.list/` — основной компонент.

## Установка
1. Склонируйте репозиторий:
   ```bash
   git clone https://github.com/Viktor-Stepanov/deals_bitrix_component.git

2. Перенесите файлы в соответствующие папки вашего проекта Bitrix:
    cp -r deals_bitrix_component/local/components/* /path/to/your/project/local/components/
    cp deals_bitrix_component/api/* /path/to/your/project/api/

3. Очистите кеш Bitrix:
    http://your-site.ru/bitrix/admin/cache.php

## Использование
Добавьте компонент на страницу через административную панель или вызовите его в PHP:
    
    $APPLICATION->IncludeComponent(
        "dealslist:deals.list",
        ".default",
        []
    );
(Либо добавить в корневую папку файл deals.php)