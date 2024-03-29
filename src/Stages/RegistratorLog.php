<?php
namespace Tramite\Tramites;

use Log;
use App\Models\User;
use Tramite\Spider\Integrations\Instagram\Instagram;
use Tramite\Spider\Integrations\Instagram\Facebook;


use Tramite\PublishPost;
use Tramite\SearchFollows;



use Tramite\Routines\ForceNewRelations;
use Tramite\Routines\GetNewData;
use Tramite\Routines\SendNewData;

use Tramite\Components\Comment;
use Tramite\Components\Post;
use Tramite\Components\Profile;
use Tramite\Components\Relation;


class RegistratorLog
{
    public function register(Registrator $something): Registrator
    {
        echo 'registration log ' . $something . '<br>';
        return $something;
    }
}