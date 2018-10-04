<?php

namespace Dixmod\DTO;

use Dixmod\Services\Channel;

class VideoDTO
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
}