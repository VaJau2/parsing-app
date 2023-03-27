<?php

use App\Services\ParserService\Parsers\KartotekaParser;

return [

    /*
    |--------------------------------------------------------------------------
    | Сервисы парсинга данных
    |--------------------------------------------------------------------------
    |
    | Класс парсера должен реализовывать ParserInterface
    |
    |--------------------------------------------------------------------------
    */

    'default' => 'kartoteka',

    'parsers' => [
        'kartoteka' => [
            'class' => KartotekaParser::class,
            'url' => 'https://etp.kartoteka.ru/index.html',
        ],


    ],
];
