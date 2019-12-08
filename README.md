# Описание

PHP класс для работы с API Укрпочты. Форкнуто с https://github.com/martinjack/UkrposhtaAPI для добавления новых методов (пока только просчёт доставки).

# Документация

[API documentation](https://dev.ukrposhta.ua/documentation)

# Требования

* PHP 7+
* Composer

# Установка
```bash
composer require yurycooliq/ukrposhta-php
```

# Пример использования
См. example.php.

# Список методов

0. Getting started
1. Создать адрес
2. Редактировать адрес
3. Показать адрес по ID
4. Создать нового клиента
5. Редактировать клиента
6. Получить список клиентов
7. Получить клиента по ID или ExternalID
8. Создать группу отправлений
9. Редактирование группы отправлений
10. Получить список групп отправлений
11. Получить группу отправлений по ID
12. Создать новую посылку
13. Редактировать посылку
14. Получить список почтовых отправлений
15. Получить почтовое отправление по ID
16. Удалить почтовое отправление с группы
17. Создать форму в PDF формате
18. Создать форму 103 в PDF формате
19. [NEW] Стоимость доставки по Украине

# Примеры
## Getting started

```php
<?php

use Ukrposhta\Ukrposhta;

// If you are using framework, like Laravel, skip this line
include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Ukrposhta('API_KEY');

// Address payload
$data = [
    'postcode'        => '02099',
    'region'          => 'Полтавська',
    'district'        => 'Полтавський',
    'city'            => 'Полтава',
    'street'          => 'Шевченка',
    'houseNumber'     => '25',
    'apartmentNumber' => '20',
];

// Get response in json
$json_string = $ukrpochta->createAddress($data);

// Decode it
$result = json_decode($json_string);

// Example of use
print_r($result->id); // 123130
print_r($result->postcode); // "02099"
print_r($result->country); // "UA"
```
## Создать адрес
```php
$ukrpochta->createAddress([
    'postcode'        => '02099',
    'region'          => 'Полтавська',
    'district'        => 'Полтавський',
    'city'            => 'Полтава',
    'street'          => 'Шевченка',
    'houseNumber'     => '25',
    'apartmentNumber' => '20',
]);
```

## Редактировать адрес
```php
$ukrpochta->editAddress(123130, [
    'postcode'        => '02050',
    'region'          => 'Полтавська',
    'district'        => 'Полтавський',
    'city'            => 'Полтава',
    'street'          => 'Шевченка',
    'houseNumber'     => '50',
    'apartmentNumber' => '1',
]);
```

## Показать адрес по ID
```php
$ukrpochta->getAddress(123130);
```

### createClient($token, $data = array()) ###
```php
$ukrpochta->createClient('TOKEN COUNTERPARTY', array(
    'name'                     => 'ФОП «Діскорд',
    'uniqueRegistrationNumber' => '32855961',
    'externalId'               => '12345678',
    'addressId'                => 1245,
    'phoneNumber'              => '0954623442',
    'counterpartyUuid'         => 'COUNTERPARTY UUID',
    'bankCode'                 => '612456',
    'bankAccount'              => '12345684'
));
```

### editClient($id, $token, $data = array()) ###
```php
$ukrpochta->editClient('UUID_CLIENT', 'TOKEN_COUNTERPARTY', array(
    'lastName'                 => 'Петрик',
    'firstName'                => 'Иван',
    'middleName'               => 'Васильович',
    'uniqueRegistrationNumber' => '73232855',
    'addressId'                => 1,
    'phoneNumber'              => '0954623442',
    'counterpartyUuid'         => 'UUID COUNTERPARTY',
    'discount'                 => 24,
    'bankCode'                 => 254,
));
```

### clientsList($token) ###
```php
$ukrpochta->clientsList('TOKEN_COUNTERPARTY');
```

### getClient($token, $id = 0, $extID = 0, $type = true) ###
```php
$ukrpochta->getClient('TOKEN_COUNTERPARTY', 'ID_CLIENT');
```

```php
$ukrpochta->getClient('TOKEN_COUNTERPARTY', '', 'externalId_CLIENT', false);
```

### createGroup($data = array()) ###
```php
$ukrpochta->createGroup('TOKEN_COUNTERPARTY', array(
    'name'             => 'group1',
    'counterpartyUuid' => 'UUID_COUNTERPARTY',
));
```

### editGroup($token, $id, data = array()) ###
```php
$ukrpochta->editGroup('TOKEN_COUNTERPARTY', 'UUID_GROUP', array(
    'name'             => 'group2',
    'counterpartyUuid' => 'UUID_COUNTERPARTY',
));
```

### groupList($token) ###
```php
$ukrpochta->groupList('TOKEN_COUNTERPARTY');
```

### getGroup($id) ###
```php
$ukrpochta->getGroup('UUID_GROUP', 'UUID_COUNTERPARTY');
```

### createParcel($token, $data = array()) ###
```php
$ukrpochta->createParcel('ba5378df-985e-49c5-9cf3-d222fa60aa68', array(
    'sender'            => array(
        'name'                     => 'ПРАТ Иван Движок',
        'firstName'                => '',
        'middleName'               => '',
        'lastName'                 => '',
        'uniqueRegistrationNumber' => '2541',
        'counterpartyUuid'         => '2304bbe5-015c-44f6-a5bf-3e750d753a17',
        'addressId'                => 123130,
        'phoneNumber'              => '0954623442',
        'individual'               => false,
        'bankCode'                 => '123001',
        'bankAccount'              => '111000222000999',
    ),
    'recipient'         => array(
        'name'                     => 'Иванов Иван Иванович',
        'firstName'                => 'Иван',
        'middleName'               => 'Иванович',
        'lastName'                 => 'Иванови',
        'uniqueRegistrationNumber' => '52415',
        'counterpartyUuid'         => '2304bbe5-015c-44f6-a5bf-3e750d753a17',
        'addressId'                => 123130,
        'phoneNumber'              => '0954623442',
        'individual'               => true,
        'bankCode'                 => '123011',
        'bankAccount'              => '111000222000123',
    ),
    'shipmentGroupUuid' => '54d3cb05-7ff4-4310-ab7c-ea77af42d998',
    'deliveryType'      => 'W2W',
    'weight'            => 150,
    'length'            => 20,
    'width'             => 0,
    'height'            => 0,
    'postPay'           => 15,
    'description'       => 'test comment comment',
    'parcels'           => array(
        array(
            'name'          => 'parcel name',
            'weight'        => 1000,
            'length'        => 170,
            'declaredPrice' => 20,
        ),
    ),
));
```

### editParcel($id, $token, $data = array()) ###
```php
$ukrpochta->editParcel('ID_PARCEL', 'TOKEN_COUNTERPARTY', array(
    'sender'            => array(
        'name'                     => 'ПРАТ Иван Движок',
        'firstName'                => '',
        'middleName'               => '',
        'lastName'                 => '',
        'uniqueRegistrationNumber' => '2541',
        'counterpartyUuid'         => '2304bbe5-015c-44f6-a5bf-3e750d753a17',
        'addressId'                => 123130,
        'phoneNumber'              => '0954623442',
        'individual'               => false,
        'bankCode'                 => '123001',
        'bankAccount'              => '111000222000999',
    ),
    'recipient'         => array(
        'name'                     => 'Иванов Иван Иванович',
        'firstName'                => 'Иван',
        'middleName'               => 'Иванович',
        'lastName'                 => 'Иванови',
        'uniqueRegistrationNumber' => '52415',
        'counterpartyUuid'         => '2304bbe5-015c-44f6-a5bf-3e750d753a17',
        'addressId'                => 123130,
        'phoneNumber'              => '0954623442',
        'individual'               => true,
        'bankCode'                 => '123011',
        'bankAccount'              => '111000222000123',
    ),
    'shipmentGroupUuid' => '54d3cb05-7ff4-4310-ab7c-ea77af42d998',
    'deliveryType'      => 'W2W',
    'weight'            => 1500,
    'length'            => 20,
    'width'             => 0,
    'height'            => 0,
    'postPay'           => 15,
    'description'       => 'change comment parcel',
    'parcels'           => array(
        array(
            'name'          => 'parcel name change',
            'weight'        => 1000,
            'length'        => 170,
            'declaredPrice' => 20,
        ),
    ),
));
```

### parcelList($token) ###
```php
$ukrpochta->parcelList('TOKEN_COUNTERPARTY');
```

### getParcel($id, $token, $type = true) ###
```php
$ukrpochta->getParcel('ID_PARCEL', 'TOKEN_COUNTERPARTY');
```

```php
$ukrpochta->getParcel('ID_SENDER', 'TOKEN_COUNTERPARTY');
```
### delParcelGroup($id, $token) ###
```php
$ukrpochta->delParcelGroup('ID_PARCEL', 'ID_GROUP');
```

### createForm($id, $token, $path, $type = true) ###
```php
$ukrpochta->createForm('ID_PARCEL', 'TOKEN_COUNTERPARTY', __DIR__ . '/file.pdf');
```

```php
$ukrpochta->createForm('ID_GROUP', 'TOKEN_COUNTERPARTY', __DIR__ . '/file.pdf', false);
```

![Example PDF 1](https://i.imgur.com/7G9PaIs.png)

### createForm103($id, $token, $path) ###
```php
$ukrpochta->createForm103('ID_GROUP', 'TOKEN_COUNTERPARTY', __DIR__ . '/file.pdf');
```

![Example PDF 2](https://i.imgur.com/O5MRATj.png)

## Стоимость доставки

```php
$ukrpochta->deliveryPrice([
    'weight' => 1000,
    'length' => 55,
    'addressFrom' => [
        'postcode' => '03134'
    ],
    'addressTo' => [
        'postcode' => '62404'
    ],
    'type' => 'EXPRESS',
    'deliveryType' => 'W2W',
    'declaredPrice' => 300,
]);
```
