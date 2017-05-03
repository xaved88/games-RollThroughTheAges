<?php
namespace RTTA\Game;

use Jane\Base\BaseVO;
use RTTA\Dice\DiceVO;
use RTTA\Player\PlayerVO;

class NewGameOptionsVO extends BaseVO
{

    /**
     * @var int[]
     */
    public $humanParticipants;

    /**
     * @var string[]
     */
    public $aiParticipants;
}