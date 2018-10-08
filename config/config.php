<?php

return [
    'youtube' => [
        'api' => [
            'base_uri' => 'https://www.googleapis.com/youtube/v3/',
            'access_key' => 'AIzaSyCr1FGNkS1Chm87nk2voH30WlYO43bBC2E',
        ],
        'channels' => [
            'UCq2T45noTHldpZxTZpD0uyg',
            'UCd_sTwKqVrweTt4oAKY5y4w',
            'UCGp4UBwpTNegd_4nCpuBcow',
            'UCmqEpAsQMcsYaeef4qgECvQ',
            'UC4axiS76D784-ofoTdo5zOA'
        ]
    ],
    'logger'=>[
        'dir' => getcwd() . DIRECTORY_SEPARATOR . 'logs'
    ],
    'tmp' => [
        'dir' => getcwd() . DIRECTORY_SEPARATOR . 'tmp'
    ],
    'db' => [
        'host' => 'localhost',
        'user' => 'box',
        'pass' => 'box',
        'db' => 'otus',
    ]
];