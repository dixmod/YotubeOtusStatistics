<?php

namespace Dixmod\Services;

use Dixmod\DTO\VideoDTO;
use Dixmod\Repository\{RepositoryInterface, VideoRepository};
use MongoCursorException;
use MongoCursorTimeoutException;
use MongoException;

class Video extends VideoDTO
{
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

        if(!self::$repository)
            self::$repository = new VideoRepository();
    }

    /**
     * @return array|bool
     * @throws MongoCursorException
     * @throws MongoCursorTimeoutException
     * @throws MongoException
     */
    public function Save(){
        return self::$repository->save( $this );
    }

    public function __sleep()
    {
        return array_keys(get_object_vars($this));
    }
}