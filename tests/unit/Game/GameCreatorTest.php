<?php
use PHPUnit\Framework\TestCase;
use RTTA\Game\GameCreator;
use RTTA\Game\GameVO;
use RTTA\Game\NewGameOptionsVO;

class GameCreatorTest extends TestCase
{
    const PLAYER_ID = 1337;
    /**
     * @var GameCreator
     */
    private $subject;

    protected function setUp()
    {
        $this->subject = new GameCreator();
    }

    public function testGameCreation()
    {
        $newGameOptions = new NewGameOptionsVO();
        $game           = $this->subject->startNewGame($newGameOptions);

        $this->assertTrue($game instanceof GameVO);
    }
}