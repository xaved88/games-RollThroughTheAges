<?php
namespace RTTA\Dice;

use BaseVO;
use RTTA\Player\PlayerVO;

class DiceVO extends BaseVO
{
    /**
     * @var DiceSidesVO[]
     */
    public $sides = [];
}