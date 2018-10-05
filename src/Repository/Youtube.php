<?php

namespace App\Repository;

use App\{Client\Client, Service\Config};

class Youtube implements RemoteSourceInterface
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $id
     * @param string $nextPageToken
     * @return array
     */
    public function getChannel(string $id, string $nextPageToken = ''): array
    {
        $options = [
            'part' => 'snippet',
            'channelId' => $id,
            'order' => 'date',    // упорядочивать по дате добавления
            'maxResults' => 5,   // за раз получать не более 5 результатов
            'key' => Config::getOptions('youtube')['api']['access_key']
        ];

        if ($nextPageToken) {
            $options['pageToken'] = $nextPageToken;
        }

        $response = $this->client->get(
            'search',
            $options
        );

        if (!$response->isOkStatus()) {

        }

        return $response->getBody();
    }

    /**
     * @param string $id
     * @return array
     */
    public function getVideoStatistics(string $id): array
    {
        $options = [
            'part' => 'statistics',
            'id' => $id,
            'key' => Config::getOptions('youtube')['api']['access_key']
        ];

        $response = $this->client->get(
            'videos',
            $options
        );

        if (!$response->isOkStatus()) {

        }

        return $response->getBody()['items'][0]['statistics'] ?? [];
    }
}