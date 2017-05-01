<?php
namespace RTTA\Game;

use Jane\Base\BaseVO;
use RTTA\Dice\DiceVO;
use RTTA\Player\PlayerVO;

class GameVO extends BaseVO
{

    /**
     * @var PlayerVO[]
     */
    public $players;

    /**
     * @var DiceVO[]
     */
    public $dice;

    /**
     * @var int
     */
    public $activePlayerId;

    /**
     * @var string
     */
    public $turnStatus;

    /**
     * @var string[]
     */
    public $remainingMonuments;
}