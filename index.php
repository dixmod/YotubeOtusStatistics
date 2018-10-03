<?php

require __DIR__ . '/vendor/autoload.php';

use Dixmod\Services\Config;
use Dixmod\Builder\ChannelBuilder;

$channels = Config::getOptions('youtube');

$channelBuilder = new ChannelBuilder();
foreach ($channels as $channelId) {
    $channel = $channelBuilder->buildById($channelId);
    $channel->Save();
}