<?php

namespace RTTA\City;

use Jane\Base\BaseVO;
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