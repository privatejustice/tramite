<?php

namespace Tramite\Readables;

use Tramite\Conectors\Pipeline as PipelineComponent;

use Tramite\Contracts\Registrator;
use Tramite\Contracts\Notificator;
use Support\Contracts\Runners\Stage as StageBase;

class ArticleImporterStage extends StageBase
{
    public function __invoke(/*PipelineComponent */$payload)
    {
        $payload->executeForEachComponent(
            function ($component) {
                Article::create(
                    [
                    'title' => $component->getTitle(),
                    'content' => $component->getContent(),
                    'fonte' => $component->getFonte(),
                    ]
                );
            }
        );
        return $payload;
    }
}
