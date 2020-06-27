[![Total Downloads](https://poser.pugx.org/drillcoder/amocrm_wrap/downloads)](https://packagist.org/packages/meowto16/profitbase)
[![License](https://poser.pugx.org/drillcoder/amocrm_wrap/license)](https://packagist.org/packages/meowto16/profitbase)

# ProfitBase API Wrapper #
Мини-обертка с методами для обращения к API ProfitBase, 
без необходимости писать свои cURL запросы.

## Начало работы ##
Перед использованием обёртки, нужно подключить файл от composer для автозагрузки классов 
'autoload.php'.

**Пример подключения autoload.php composer'a**

```$xslt
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php"))
    require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";
```

## Пример использования ##
Все запросы идут через одну точку входа $handler

```php
<?php

// Подключаем autoload.php composer
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php"))
    require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

// https://developer.profitbase.ru/
$handler = new \Meowto16\ProfitBase\Handler([
    "API_KEY" => "app-2s2sfc46x7jd5", // Ваш API-KEY, можно получить в личном кабинете
    "API_URL" => "https://pbXXX.profitbase.ru/api/v4/json", // API EndPoint, где pbXXX - ваш sub.домен
    
    // Файл, куда будем кэшировать данные для авторизации, для последующих запросов. Важно, чтобы на него нельзя было зайти напрямую.
    "AUTH_JSON_PATH" => $_SERVER["DOCUMENT_ROOT"] . "/data/profitbase/authorize-data.json" 
]);

// Задаем фильтр, если он необходим.
$filter = [
    "status" => ["AVAILABLE"], // Получить только со статусом "В продаже"
    "price" => [
        "min" => 2000000, // От 2 млн. 
        "max" => 6000000 // До 6 млн.
    ],
    "projectIds" => [15562], // ID Проекта '15562'
    "propertyTypeAliases" => ["office"] // Только офисы
];

// Делаем запрос
$properties = $handler->getProperties($filter);

// Смотрим на данные, которые пришли от ProfitBase
echo '<pre>';
var_dump($properties);
echo '</pre>';
```

## Доступные методы ##
### Общие ###
- ``$handler->lastResponse`` - последний ответ от ProfitBase
- ``$handler->lastCode`` - последний код ответа от ProfitBase
### Шахматка ###
- ``$handler->getBoard($params)`` - [метод получения шахматки дома](https://developer.profitbase.ru/#tag-board)
### Фасады ###
- ``$handler->getFacade($params)`` - [метод получения списка фасадов дома](https://developer.profitbase.ru/#tag-facade)
### Этажи ###
- ``$handler->getFloors($params)`` - [метод получения планировок этажей дома](https://developer.profitbase.ru/#tag-floor)
### Дома ###
- ``$handler->getHouses($params)`` - [метод получения списка домов с возможностью фильтрации](https://developer.profitbase.ru/#operation--house-get)
- ``$handler->getCountFloors($params)`` - [метод получения количества этажей в конкретном доме](https://developer.profitbase.ru/#operation--house-get-count-floors-get)
- ``$handler->getCountPropertiesOnFloor($params)`` - [метод получения количества помещений в конкретном доме на конкретном этаже](https://developer.profitbase.ru/#operation--house-get-count-properties-on-floor-get)
- ``$handler->createHouse($params)`` - [метод создания дома в существующем ЖК](https://developer.profitbase.ru/#operation--houses-post)
### Акции и специальные предложения
- ``$handler->getSpecialOffers($params)`` - [метод получения списка активных акции со списком помещений по каждой акции](https://developer.profitbase.ru/#operation--special-offer-get)
### Планировки ###
- ``$handler->getPlan($params)`` - [метод получения планировок помещений с возможностью фильтрации](https://developer.profitbase.ru/#tag-presets)
### Проекты ###
- ``$handler->getProjects()`` - [метод получения списка ЖК](https://developer.profitbase.ru/#operation--projects-get)
- ``$handler->createProject($params)`` - [метод создания ЖК](https://developer.profitbase.ru/#operation--projects-post)
### Квартиры ###
- ``$handler->getProperties($params)`` - [метод получения списка помещений с возможностью фильтрации](https://developer.profitbase.ru/#operation--property-get)
- ``$handler->getPropertyTypes()`` - [метод получения списка типов помещений и их дополнительных полей](https://developer.profitbase.ru/#operation--property-types-get)
- ``$handler->getPropertiesFromDeal($dealId)`` - [метод получения списка помещений привязанных к конкретной сделке](https://developer.profitbase.ru/#operation--get-property-deals-get)
- ``$handler->getPropertyHistory($propertyId)`` - [метод получения истории изменения статусов по конкретному помещению](https://developer.profitbase.ru/#operation--property-deal--dealId--get)

