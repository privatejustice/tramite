<?php
/**
 * 
 */

namespace Tramite\Tramites;

use Operador\Contracts\PipelineBuilder as PipelineBuilderBase;
use League\Pipeline\StageInterface;
use League\Pipeline\PipelineBuilder;

use Log;

class ArticlePipeline extends PipelineBuilderBase
{
    public function getPipeline()
    {
        $pipeline = (new self())
            ->pipe(new Readables\ArticleCreateStage)
            ->pipe(new Readables\ArticleImporterStage)
            ->pipe([new RegistratorLog, 'register'])
            ->pipe([new NotificationSms, 'notification'])
            ->pipe([new NotificationEmail, 'notification']);

        return $pipeline->build();
    }

}
