<?php

namespace App\Service;


use App\Repository\Youtube;

class VideoStatistics
{
    /** @var integer */
    public $views = 0;

    /** @var integer */
    public $likes = 0;

    /** @var integer */
    public $dislikes = 0;

    /** @var integer */
    private $favorites = 0;

    /** @var integer */
    private $comments = 0;

    /**
     * VideoStatistics constructor.
     * @param string $id
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct(string $id)
    {
        global $container;
        $api = $container->get(Youtube::class);

        $statistics = $api->getVideoStatistics($id);
        $this->views = $statistics['viewCount'] ?? 0;
        $this->likes = $statistics['likeCount'] ?? 0;
        $this->dislikes = $statistics['dislikeCount'] ?? 0;
        $this->comments = $statistics['commentCount'] ?? 0;
        $this->favorites = $statistics['favoriteCount'] ?? 0;
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

    /**
     * @return int
     */
    public function getFavorites(): int
    {
        return $this->favorites;
    }

    /**
     * @return int
     */
    public function getComments(): int
    {
        return $this->comments;
    }

}