<?php

namespace RTTA\Resources;

use BaseVO;

class ResourcesVO extends BaseVO
{
    /**
     * @var string[] => resourceType => amount
     */
    public $amount = [];
}