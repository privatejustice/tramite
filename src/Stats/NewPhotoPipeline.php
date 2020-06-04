<?php

namespace Tramite\Stats;

use Log;
use App\Models\User;
use Tramite\Spider\Integrations\Instagram\Instagram;
use Tramite\Spider\Integrations\Instagram\Facebook;


use Tramite\PublishPost;
use Tramite\SearchFollows;



use Tramite\Routines\ForceNewRelations;
use Tramite\Routines\GetNewData;
use Tramite\Routines\SendNewData;

use SiObjects\Components\Comment;
use SiObjects\Components\Post;
use SiObjects\Components\Profile;
use SiObjects\Components\Relation;

class NewPhotoPipeline
{
    
    public function executeRoutines()
    {
        return [
            new ForceNewRelations($this),
            new GetNewData($this),
            new SendNewData($this)
        ];
    }
    
    /**
     * CLasses Modulos
     */
    public function getIntegrations()
    {
        return [
            new Instagram(),
            new Facebook()
        ];
    }
    
    public function getActions()
    {
        return [
            SearchFollows::class,
            PublishPost::class,
        ];
    }

    public function getComponents()
    {
        return [
            Profile::class,
            [
                Relation::class,
                Post::class,
                [
                    Comment::class,
                ]
            ],
        ];
    }

    /**
     * 
     */
    
    public function getComponentsForFather()
    {
        return [
            SearchFollows::class,
            PublishPost::class,
        ];
    }

    
    /**
     * CLasses Operações
     */
    public function executeForEachIntegration($functionToExecute)
    {
        $integrations = $this->getIntegrations();
        foreach ( $integrations as $integration ) {
            $functionToExecute($integration);
        }
        return true;
    }

    public function executeForEachComponent($functionToExecute, $parent = false)
    {
        $self = $this;
        $components = $this->getComponentsForFather($parent);
        foreach ( $components as $component ) {
            $functionToExecute(
                $component,
                function ($result) use ($self, $functionToExecute) {
                    $self->executeForEachComponent($functionToExecute, $result);
                }
            );
        }
        return true;
    }

}
