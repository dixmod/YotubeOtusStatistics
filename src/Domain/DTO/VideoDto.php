<?php

namespace App\Domain\DTO;

class VideoDto
{
    /** @var string */
    public $id;

    /** @var string */
    public $channel;

    /** @var string */
    public $title;

    /** @var integer */
    public $views;

    /** @var integer */
    public $likes;

    /** @var integer */
    public $dislikes;
}