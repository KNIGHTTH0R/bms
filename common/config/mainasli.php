<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
          'class' => 'yii\i18n\Formatter',
          'locale' => 'id-ID',
          'dateFormat' => 'php: d-m-Y',
          'datetimeFormat' => 'php: d-m-Y H:i:s',
          'timeFormat' => 'php:H:i',
          'timeZone' => 'Asia/Jakarta',
          'thousandSeparator' => '.',
          'decimalSeparator' => ',',
          'currencyCode' => 'IDR',
          'numberFormatterOptions' => [
              NumberFormatter::MIN_FRACTION_DIGITS => 0,
              NumberFormatter::MAX_FRACTION_DIGITS => 2,
          ]
        ],
    ],
];
