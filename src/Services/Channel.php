<?php

namespace Dixmod\Services;

use Dixmod\DTO\{ChannelDTO, VideoDTO};
use Dixmod\Repository\ChannelRepository;
use Dixmod\Repository\RepositoryInterface;
use Dixmod\Services\Serialize\ModelSerialize;

class Channel extends ModelSerialize
{
    /** @var RepositoryInterface */
    private static $repository;

    /** @var string */
    public $id;

    /** @var VideoDTO[] */
    public $items;

    /**
     * Channel constructor.
     * @param ChannelDTO $DTO
     */
    public function __construct(ChannelDTO $DTO)
    {
        $this->id = $DTO->id;
        $this->items = $DTO->items;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @throws \MongoCursorException
     * @throws \MongoCursorTimeoutException
     * @throws \MongoException
     */
    public function Save()
    {
        if (!self::$repository) {
            self::$repository = new ChannelRepository();
        }

        self::$repository->save($this->toArray());

        /** @var Video $video */
        foreach ($this->items as $video) {
            //try {
            $video->Save();
            /*} catch (\Exception $exception) {
                echo $exception->getMessage();
            }*/
        }
    }

    /**
     * @return array
     */
    public function getSkipProperty(): array
    {
        return ['items'];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }

    public function __toString()
    {
        return $this->id;
    }
}