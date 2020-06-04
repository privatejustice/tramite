<?php

namespace Tramite\Tramites;

use Support\Contracts\Runners\Stage as StageBase;

class TimesTwoStage extends StageBase
{
    public function __invoke($payload)
    {
        return $payload * 2;
    }
}
