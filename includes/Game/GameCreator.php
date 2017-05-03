<?php

namespace RTTA\Game;

use Jane\Base\BaseModel;

class GameCreator extends BaseModel
{
    /**
     * @param NewGameOptionsVO $optionsVO
     *
     * @return GameVO
     */
    public function startNewGame(NewGameOptionsVO $optionsVO)
    {


        return new GameVO();
    }
}