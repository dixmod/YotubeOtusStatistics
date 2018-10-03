<?php

namespace Dixmod\Builder;

use Dixmod\DTO\ChannelDTO;
use Dixmod\Services\Channel;
use Dixmod\Services\Youtube;

class ChannelBuilder
{
    /** @var Youtube */
    private $remoteSource;

    /** @var VideoBuilder */
    private $videoBuilder;

    public function __construct()
    {
        $this->remoteSource = new Youtube();
        $this->videoBuilder = new VideoBuilder();
    }

    /**
     * @param string $id
     * @return Channel
     */
    public function buildById(string $id): Channel
    {
        $channel = $this->build(['id' => $id]);
        $nextPageToken = '';
        do {
            $data = $this->remoteSource->loadChannelById($channel->getId(), $nextPageToken);

            foreach ($data['items'] as $item) {
                if (empty($item)) {
                    continue;
                }
                $item['channel'] = $channel;
                $channel->items[] = $this->videoBuilder->build($item);
            }

            $nextPageToken = $data['nextPageToken'] ?? '';
        } while (!empty($nextPageToken));

        return $channel;
    }

    /**
     * @param $data
     * @return Channel
     */
    public function build(array $data): Channel
    {
        $channel = new Channel($this->createDTO($data));

        return $channel;
    }

    /**
     * @param array $data
     * @return ChannelDTO
     */
    private function createDTO(array $data): ChannelDTO
    {
        $dto = new ChannelDTO();
        $dto->id = $data['id'];
        $dto->items = [];

        return $dto;
    }
}