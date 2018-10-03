<?php

namespace Dixmod\Services;

use Dixmod\DTO\ChannelDTO;

class Channel extends ChannelDTO
{
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
     * @return bool
     * @throws \MongoCursorException
     * @throws \MongoCursorTimeoutException
     * @throws \MongoException
     */
    public function Save(): bool
    {
        /** @var Video $video */
        foreach ($this->items as $video){
            $video->Save();
        }

        return true;
    }
}