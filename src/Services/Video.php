<?php

namespace Dixmod\Services;

use Dixmod\DTO\VideoDTO;
use Dixmod\Repository\{RepositoryInterface, VideoRepository};
use Dixmod\Services\Serialize\ModelSerialize;
use MongoCursorException;
use MongoCursorTimeoutException;
use MongoException;

class Video extends ModelSerialize
{
    /** @var string */
    public $id;

    /** @var Channel */
    public $channel;

    /** @var string */
    public $title;

    /** @var integer */
    public $views;

    /** @var integer */
    public $likes;

    /** @var integer */
    public $dislikes;

    /** @var RepositoryInterface */
    private static $repository;

    /**
     * Video constructor.
     * @param VideoDTO $DTO
     */
    public function __construct(VideoDTO $DTO)
    {
        $this->id = $DTO->id;
        $this->channel = $DTO->channel;
        $this->title = $DTO->title;
        $this->dislikes = $DTO->dislikes;
        $this->likes = $DTO->likes;
        $this->views = $DTO->views;
    }

    /**
     * @return array|bool
     * @throws MongoCursorException
     * @throws MongoCursorTimeoutException
     * @throws MongoException
     */
    public function Save()
    {
        if (!self::$repository) {
            self::$repository = new VideoRepository();
        }

        return self::$repository->save($this->toArray());
    }

    /**
     * @return array
     */
    public function getSkipProperty(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'channel' => $this->channel instanceof Channel ? $this->channel->getId() : null,
            'title' => $this->title,
            'views' => $this->views,
            'likes' => $this->likes,
            'dislikes' => $this->dislikes
        ];
    }
}