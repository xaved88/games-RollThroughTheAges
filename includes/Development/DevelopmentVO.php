<?php

namespace RTTA\Development;

use BaseVO;
use RTTA\Bonus\BonusVO;

class DevelopmentVO extends BaseVO
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $cost;

    /**
     * @var int
     */
    public $points;

    /**
     * @var BonusVO[]
     */
    public $bonuses = [];

    /***
     * @var bool;
     */
    public $purchased = false;
}