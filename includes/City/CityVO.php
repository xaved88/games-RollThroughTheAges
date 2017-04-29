<?php

namespace RTTA\City;

use BaseVO;
use RTTA\Bonus\BonusVO;

class CityVO extends BaseVO
{
    /**
     * @var int
     */
    public $cost;

    /**
     * @var int
     */
    public $progress;

    /**
     * @var BonusVO[]
     */
    public $bonuses = [];

    /**
     * @var bool
     */
    public $built = false;
}