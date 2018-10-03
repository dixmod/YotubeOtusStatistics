<?php

namespace Dixmod\Services;

class Youtube implements RemoteSourceInterface
{
    /**
     * @param string $id
     * @return array
     */
    public function loadVideoStatisticsById(string $id): array
    {
        $buf = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=" . $id . "&key=" . Config::getOptions('google')['access_key']);

        $data = json_decode($buf, 1);

        return $data['items'][0];

    }

    /**
     * @param string $id
     * @param string $nextPageToken
     * @return array
     */
    public function loadChannelById(string $id, $nextPageToken = ''): array
    {
        $url = 'https://www.googleapis.com/youtube/v3/search?part=snippet'
            . '&channelId=' . $id
            . '&order=date'    // упорядочивать по дате добавления
            . '&maxResults=5'  // за раз получать не более 5 результатов
            . ($nextPageToken ? '&pageToken=' . $nextPageToken : '')
            //. '&fields=items/id/videoId'  // нам нужны только идентификаторы видео
            . '&key=' . Config::getOptions('google')['access_key'];

        // TODO: переделать на guzzle
        $buf = file_get_contents($url);

        return json_decode($buf, 1);
    }
}