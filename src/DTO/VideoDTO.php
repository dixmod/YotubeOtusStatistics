<?php

namespace Dixmod\DTO;


class VideoDTO
{
    /** @var string */
    public $id;


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