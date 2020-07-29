<?php

namespace Tramite\Tramites;

use Operador\Contracts\Stage as StageBase;

class TimesTwoStage extends StageBase
{
    public function __invoke($payload)
    {
        return $payload * 2;
    }
}
