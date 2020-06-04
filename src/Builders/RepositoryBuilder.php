<?php

namespace Tramite\Builders;

use League\Pipeline\Pipeline;
use League\Pipeline\StageInterface;

use Support\Contracts\Runners\PipelineBuilder;

use Tramite\Finder\Repository;

class RepositoryBuilder extends PipelineBuilder
{
    public static function getPipelineWithOutput($output)
    {
        $builder = self::makeWithOutput($output);
        $builder
            ->add(Repository::makeWithOutput($builder->getOutput()));

        return $builder->build();
    }
}