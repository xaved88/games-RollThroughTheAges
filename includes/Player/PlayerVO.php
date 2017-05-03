<?php
namespace RTTA\Player;

use Jane\Base\BaseVO;
use RTTA\Bonus\BonusVO;
use RTTA\City\CityVO;
use RTTA\Development\DevelopmentVO;
use RTTA\Monument\MonumentVO;
use RTTA\Resources\ResourcesVO;

class PlayerVO extends BaseVO
{
    /**
     * @var int - null for AI
     */
    public $playerId;

    /**
     * @var int - seatId is the relative turn / id in the game, starting at 0.
     */
    public $seatId;

    /**
     * @var CityVO[]
     */
    public $cities;

    /**
     * @var DevelopmentVO[]
     */
    public $developments;

    /**
     * @var MonumentVO[]
     */
    public $monuments;

    /**
     * @var BonusVO[]
     */
    public $bonuses;

    /**
     * @var int
     */
    public $disasterCount;

    /**
     * @var ResourcesVO
     */
    public $resources;
}