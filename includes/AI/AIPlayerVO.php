<?php
namespace RTTA\AI;

use RTTA\Player\PlayerVO;

class AIPlayerVO extends PlayerVO
{
    // TODO:
    // dear future self,
    // this isn't working because your autoloader isn't working properly. It has no AI, and this is the first
    // time you are requiring a file (not just using a namespace), which is referring to something LATER in the auto
    // load queue. I'm sure you can find ways to deal with this, just stay calm, sleep, focus, etc.
    // And of course, consult google.
    const MIND_EASY = 'easy';

    public $mind;
}