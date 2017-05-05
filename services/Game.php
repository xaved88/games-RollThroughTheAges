<?php

namespace RTTA\Service;

use Jane\Base\BaseService;
use RTTA\Game\GameCreator;
use RTTA\Game\GameVO;
use RTTA\Game\NewGameOptionsVO;

class Game extends BaseService
{
    const SERVICE_NAME = 'Game';
    const METHOD_CREATE = 'create';

    /**
     * @var GameCreator
     */
    private $gameCreator;

    /**
     * @param GameCreator $gameCreator
     */
    public function __construct(GameCreator $gameCreator)
    {
        $this->gameCreator = $gameCreator;
    }

    /**
     * @param NewGameOptionsVO $newGameOptionsVO
     *
     * @return GameVO
     */
    public function create(NewGameOptionsVO $newGameOptionsVO)
    {
        return $this->gameCreator->startNewGame($newGameOptionsVO);
    }
}