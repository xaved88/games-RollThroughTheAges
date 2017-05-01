<?php

namespace RTTA\Resources;

use Jane\Base\BaseVO;

class ResourcesVO extends BaseVO
{
    /**
     * @var string[] => resourceType => amount
     */
    public $amount = [];
}