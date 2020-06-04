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

use SiObjects\Components\Comment;
use SiObjects\Components\Post;
use SiObjects\Components\Profile;
use SiObjects\Components\Relation;


class RegistratorLog
{
    public function register(Registrator $something)
    {
        echo 'registration log ' . $something . '<br>';
        return $something;
    }
}