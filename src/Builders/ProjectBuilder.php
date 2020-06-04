<?php

namespace Tramite\Builders;

use League\Pipeline\Pipeline;
use League\Pipeline\StageInterface;

use Support\Contracts\Runners\PipelineBuilder;

use Tramite\Finder\Project;

class ProjectBuilder extends PipelineBuilder
{
    public static function getPipelineWithOutput($output)
    {
        $builder = self::makeWithOutput($output);
        $builder
            ->add(Project::makeWithOutput($builder->getOutput()));

        return $builder->build();
    }
}