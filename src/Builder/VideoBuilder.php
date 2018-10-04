<?php

namespace Dixmod\Builder;

use Dixmod\DTO\VideoDTO;
use Dixmod\Services\{RemoteSourceInterface, VideoStatistics, Youtube, Video};

class VideoBuilder
{
    /** @var RemoteSourceInterface */
    private $remoteSource;

    public function __construct()
    {
        $this->remoteSource = new Youtube();
    }


    /**
     * @param array $data
     * @return Video
     */
    public function build(array $data): Video
    {
        $dto = new VideoDTO();
        if (isset($data['id']['videoId'])) {

            $dto->id = $data['id']['videoId'];
            $dto->title = $data['snippet']['title'] ?? '';
            $dto->channel = $data['channel'];

            $statistics = new VideoStatistics($dto->id);
            $dto->views = $statistics->getViews();
            $dto->dislikes = $statistics->getDislikes();
            $dto->likes = $statistics->getLikes();
        }

        $video = new Video($dto);

        return $video;
    }

}