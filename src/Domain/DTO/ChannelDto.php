<?php

namespace App\Domain\DTO;


class ChannelDto
{
    /** @var string */
    public $id;

    /** @var string */
    public $title;

    /** @var VideoDto[] */
    public $videos;
}