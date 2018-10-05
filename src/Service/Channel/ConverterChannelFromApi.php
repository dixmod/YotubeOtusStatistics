<?php

namespace App\Service\Channel;

use App\Domain\DTO\ChannelDto;
use App\Domain\DTO\VideoDto;
use App\Service\VideoStatistics;

class ConverterChannelFromApi
{
    public function createChannel(array $channel): ChannelDto
    {
        $dto = new ChannelDto();
        $dto->id = $channel['items'][0]['snippet']['channelId'] ?? '';
        $dto->title = $channel['items'][0]['snippet']['channelTitle'] ?? '';
        $dto->videos = $this->createItems($channel['items']);
        return $dto;
    }

    private function createItems(array $items): array
    {
        return array_map(
            function ($item) {
                return $this->createItem($item);
            },
            $items
        );
    }

    private function createItem(array $video): VideoDto
    {
        $dto = new VideoDto();

        $dto->id = $video['id']['videoId'] ?? '';
        $dto->title = $video['snippet']['title'] ?? '';
        $dto->channel = $video['snippet']['channelId'] ?? '';

        $statistics = new VideoStatistics($dto->id);
        $dto->views = $statistics->getViews();
        $dto->dislikes = $statistics->getDislikes();
        $dto->likes = $statistics->getLikes();

        return $dto;
    }
}
