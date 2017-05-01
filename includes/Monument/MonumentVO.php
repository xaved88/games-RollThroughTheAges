<?php

namespace RTTA\Monument;

use Jane\Base\BaseVO;
use RTTA\Bonus\BonusVO;

class MonumentVO extends BaseVO
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
    public $progress;

    /**
     * @var bool
     */
    public $completed;

    /**
     * @var bool
     */
    public $firstCompleted;

    /**
     * @var int
     */
    public $points;

    /**
     * @var BonusVO[]
     */
    public $bonuses;
}