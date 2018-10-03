<?php

namespace Dixmod\Builder;

use Dixmod\DTO\VideoDTO;
use Dixmod\Services\Channel;
use Dixmod\Services\RemoteSourceInterface;
use Dixmod\Services\VideoStatistics;
use Dixmod\Services\Youtube;
use Dixmod\Services\Video;

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
            echo $data['id']['videoId']."\n";
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