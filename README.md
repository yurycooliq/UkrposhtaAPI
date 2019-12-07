# Описание

PHP класс для работы с API Укрпочты. Форкнуто с https://github.com/martinjack/UkrposhtaAPI для добавления новых методов (пока только просчёт доставки).

# Документация

[API documentation](https://dev.ukrposhta.ua/documentation)

# Требования

* PHP 7+
* Composer

# Composer
```bash
composer require yurycooliq/ukrposhta-php
```

# Список методов

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
## [Создать адрес](#создать-адрес)

```php
<?php
use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';
$ukrpochta = new Pochta('API_KEY');

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

$result = $ukrpochta->createAddress($data);

print_r($result);
//{"id":123130,"postcode":"02099","region":"Полтавська","district":"Полтавський",
//"city":"Полтава","street":"Шевченка",
//"houseNumber":"51","apartmentNumber":"20","description":null,"countryside":false,
//"detailedInfo":"Україна, 02099, Полтавська, Полтавський, Полтава, Шевченка, 51, 20","country":"UA"}
```

## Редактировать адрес
```php
<?php
use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';
$ukrpochta = new Pochta('API_KEY');

// Adress ID
$address_id = 123130;

// New address data
$data = [
    'postcode'        => '02050',
    'region'          => 'Полтавська',
    'district'        => 'Полтавський',
    'city'            => 'Полтава',
    'street'          => 'Шевченка',
    'houseNumber'     => '50',
    'apartmentNumber' => '1',
];

$result = $ukrpochta->editAddress($address_id, $data);

print_r($result);
//{"id":123130,"postcode":"02099","region":"Полтавська","district":"Полтавський",
//"city":"Полтава","street":"Шевченка",
//"houseNumber":"51","apartmentNumber":"20","description":null,"countryside":false,
//"detailedInfo":"Україна, 02099, Полтавська, Полтавський, Полтава, Шевченка, 51, 20","country":"UA"}
```

### getAddress($id) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->getAddress(123130);
print_r($result);
```

### createClient($token, $data = array()) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->createClient('TOKEN COUNTERPARTY', array(
    'name'                     => 'ФОП «Діскорд',
    'uniqueRegistrationNumber' => '32855961',
    'externalId'               => '12345678',
    'addressId'                => 1245,
    'phoneNumber'              => '0954623442',
    'counterpartyUuid'         => 'COUNTERPARTY UUID',
    'bankCode'                 => '612456',
    'bankAccount'              => '12345684'
));
print_r($result);
``` 

### editClient($id, $token, $data = array()) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->editClient('UUID_CLIENT', 'TOKEN_COUNTERPARTY', array(
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
print_r($result);
```

### clientsList($token) ###
```php
<?php
use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');
$result = $ukrpochta->clientsList('TOKEN_COUNTERPARTY');
print_r($result);
```

### getClient($token, $id = 0, $extID = 0, $type = true) ###
```php
<?php
use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');
$result = $ukrpochta->getClient('TOKEN_COUNTERPARTY', 'ID_CLIENT');
print_r($result);
```

```php
<?php
use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');
$result = $ukrpochta->getClient('TOKEN_COUNTERPARTY', '', 'externalId_CLIENT', false);
print_r($result);
```

### createGroup($data = array()) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->createGroup('TOKEN_COUNTERPARTY', array(
    'name'             => 'group1',
    'counterpartyUuid' => 'UUID_COUNTERPARTY',
));
print_r($result);
```

### editGroup($token, $id, data = array()) ###
```php
use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');
$result = $ukrpochta->editGroup('TOKEN_COUNTERPARTY', 'UUID_GROUP', array(
    'name'             => 'group2',
    'counterpartyUuid' => 'UUID_COUNTERPARTY',
));
print_r($result);
```

### groupList($token) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');
$result = $ukrpochta->groupList('TOKEN_COUNTERPARTY');
print_r($result);
```

### getGroup($id) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');
$result = $ukrpochta->getGroup('UUID_GROUP', 'UUID_COUNTERPARTY');
print_r($result);
```

### createParcel($token, $data = array()) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->createParcel('ba5378df-985e-49c5-9cf3-d222fa60aa68', array(
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
print_r($result);
```

### editParcel($id, $token, $data = array()) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->editParcel('ID_PARCEL', 'TOKEN_COUNTERPARTY', array(
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
print_r($result);
```

### parcelList($token) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');
$result = $ukrpochta->parcelList('TOKEN_COUNTERPARTY');
print_r($result);
```

### getParcel($id, $token, $type = true) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');
$result = $ukrpochta->getParcel('ID_PARCEL', 'TOKEN_COUNTERPARTY');
print_r($result);
```

```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');
$result = $ukrpochta->getParcel('ID_SENDER', 'TOKEN_COUNTERPARTY');
print_r($result);
```
### delParcelGroup($id, $token) ###
```php
<?php
use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');
$result = $ukrpochta->delParcelGroup('ID_PARCEL', 'ID_GROUP');
print_r($result);
```

### createForm($id, $token, $path, $type = true) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');

$ukrpochta->createForm('ID_PARCEL', 'TOKEN_COUNTERPARTY', __DIR__ . '/file.pdf');
```

```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');

$ukrpochta->createForm('ID_GROUP', 'TOKEN_COUNTERPARTY', __DIR__ . '/file.pdf', false);
```

![Example PDF 1](https://i.imgur.com/7G9PaIs.png)

### createForm103($id, $token, $path) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');
$ukrpochta->createForm103('ID_GROUP', 'TOKEN_COUNTERPARTY', __DIR__ . '/file.pdf');
```

![Example PDF 2](https://i.imgur.com/O5MRATj.png)

## Стоимость доставки

```php
<?php
use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';
$ukrpochta = new Pochta('API_KEY');

// Payload
// See docs at https://dev.ukrposhta.ua/uploads/API-documentation-28102019.pdf
$data = [
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
];

$result = $ukrpochta->deliveryPrice($data);

print_r($result);
//"{"deliveryPrice":35.00,"rawDeliveryPrice":35.00,"calculationDescription":"price for the weight=0.00; tariff (EXPRESS, COUNTRY, 1000 g, 55 cm)=35.00; countryside=0.00; declared price surcharge=0.00","parcels":null,"validate":true,"addressFrom":{"postcode":"03134","conglomerationPostcode":null},"addressTo":{"postcode":"62404","conglomerationPostcode":null},"type":"EXPRESS","deliveryType":"W2W","weight":1000,"length":55,"width":0,"height":0,"declaredPrice":300,"declaredPriceSurcharge":0.00,"discounts":null,"tariffToken":null,"surchargeTariffToken":null,"lengthOverpayRatio":null,"measurablesTotalWeight":0,"measurablesMaxLength":0,"measurablesMaxWidth":0,"measurablesMaxHeight":0,"sms":false,"recommended":false,"documentBack":false}"
```
