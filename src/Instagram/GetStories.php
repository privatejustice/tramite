<?php

namespace Tramite\Instagram;

use Illuminate\Support\Facades\Facade;
use Population\Models\Identity\Digital\Account;

class GetStories extends Instagram
{
    public function execute()
    {
        collect($this->executor->getStories())->each(
            function ($story) {
                dd($story);
            }
        );
    }
}
