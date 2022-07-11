<?php
namespace Tramite\Stages\Topics;

use Tramite\Conectors\Pipeline as PipelineComponent;

use Tramite\Contracts\Registrator;
use Tramite\Contracts\Notificator;
use Operador\Contracts\Stage as StageBase;

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
