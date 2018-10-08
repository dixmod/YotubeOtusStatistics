<?php

namespace App\Entity;

use App\Domain\DTO\ChannelDto;
use App\Domain\DTO\VideoDto;
use App\Repository\ChannelRepository;
use App\Repository\RepositoryInterface;
use App\Service\Collection\ChannelVideoCollection;
use App\Service\Serialize\ModelSerialize;

class Channel extends ModelSerialize
{
    /** @var RepositoryInterface */
    private static $repository;

    /** @var string */
    public $id;

    /** @var VideoDto[] */
    public $videos;

    /** @var string */
    public $title = '';

    /**
     * Channel constructor.
     * @param ChannelDto $dto
     */
    public function __construct(ChannelDto $dto)
    {
        $this->update($dto);
    }

    /**
     * @param ChannelDto $dto
     */
    public function update(ChannelDto $dto){
        $this->id = $dto->id;
        $this->title = $dto->title;
        $this->videos = new ChannelVideoCollection($dto->videos);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return bool|mixed
     */
    public function save()
    {
        if (!self::$repository) {
            self::$repository = new ChannelRepository();
        }

         self::$repository->save($this->toArray());
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
            'title' => $this->title,
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }

    /**
     * @return ChannelVideoCollection
     */
    public function getVideos(): ChannelVideoCollection
    {
        return $this->videos;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}