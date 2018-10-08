<?php

namespace App\Entity;

use App\Domain\DTO\VideoDto;
use App\Repository\RepositoryInterface;
use App\Repository\VideoRepository;
use App\Service\Serialize\ModelSerialize;

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
     * @param VideoDto $DTO
     */
    public function __construct(VideoDto $DTO)
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
     */
    public function save()
    {
        if (!self::$repository) {
            self::$repository = new VideoRepository();
        }

        self::$repository->save($this->toArray());
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
            'channel' => $this->channel,
            'title' => $this->title,
            'views' => $this->views,
            'likes' => $this->likes,
            'dislikes' => $this->dislikes
        ];
    }
}