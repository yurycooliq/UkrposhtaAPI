<?php

use Ukrposhta\Ukrposhta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Ukrposhta('API_KEY');

$payload = [
    'postcode'        => '02099',
    'region'          => 'Полтавська',
    'district'        => 'Полтавський',
    'city'            => 'Полтава',
    'street'          => 'Шевченка',
    'houseNumber'     => '51',
    'apartmentNumber' => '20',
];

$json_string = $ukrpochta->createAddress($payload);

$result = json_decode($json_string);
