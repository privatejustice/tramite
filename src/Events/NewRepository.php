<?php

namespace Tramite\Finder;

use Support\Contracts\Runners\Stage as StageBase;

class NewRepository extends StageBase
{
    public function __invoke($payload)
    {
        $this->info('Analisando Repository: '.$payload->getTargetPath());
        
        return $payload;
    }
}