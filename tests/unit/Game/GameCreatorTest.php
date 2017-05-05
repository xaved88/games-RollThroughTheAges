<?php
use PHPUnit\Framework\TestCase;
use RTTA\AI\AIPlayerVO;
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

    public function testGameCreationReturnsGameVO()
    {
        $newGameOptions = new NewGameOptionsVO();
        $game           = $this->subject->startNewGame($newGameOptions);

        $this->assertTrue($game instanceof GameVO);
    }


    public function testGameCreatesVOWithPlayers()
    {
        $newGameOptions                    = new NewGameOptionsVO();
        $newGameOptions->humanParticipants = [static::PLAYER_ID];
        $newGameOptions->aiParticipants    = [
            AIPlayerVO::MIND_EASY,
            AIPlayerVO::MIND_EASY,
        ];

        $gameVO = $this->subject->startNewGame($newGameOptions);


    }
}