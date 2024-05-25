<?php

namespace App\Http\Trait;

trait UserTrait
{
    private $individualFee = 0.015;
    private $businessFee = 0.025;
    private $businessFeeAfterFiftyThousand = 0.015;
}
