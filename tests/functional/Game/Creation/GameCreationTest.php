<?php
namespace RTTA\TestsFunctional\Game\Creation;

use RTTA\Game\NewGameOptionsVO;
use RTTA\Service\Game;
use RTTA\TestsFunctional\Game\BaseGameTest;

class GameCreationTest extends BaseGameTest
{
    public function testThis()
    {
        $options = new NewGameOptionsVO();

        $params = [$options];
        $result = $this->makeServiceCall(Game::SERVICE_NAME, Game::METHOD_CREATE, $params);

        $this->assertTrue(true);
    }
}