<?php

namespace Dixmod\Services;


class VideoStatistics
{
    /** @var RemoteSourceInterface  */
    private $remoteSource;

    /** @var integer */
    public $views;

    /** @var integer */
    public $likes;

    /** @var integer */
    public $dislikes;

    /**
     * VideoStatistics constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->remoteSource = new Youtube();

        $statistics = $this->remoteSource->loadVideoStatisticsById($id);
        $this->likes = $statistics['statistics']['likeCount'];
        $this->dislikes = $statistics['statistics']['dislikeCount'];
        $this->views = $statistics['statistics']['viewCount'];
    }

    /**
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @return int
     */
    public function getDislikes(): int
    {
        return $this->dislikes;
    }

}