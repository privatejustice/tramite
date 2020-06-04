<?php

namespace Tramite\Instagram;

use Illuminate\Support\Facades\Facade;
use Population\Models\Identity\Digital\Account;

class GetFollowers extends Instagram
{

    public function executeForEach($target)
    {
        sleep(2); // Delay to mimic user
        $followers = [];
        $account = $this->executor->getAccount($target);
        sleep(1);
        $followers = $this->executor->getFollowers($account->getId(), 1000, 100, true); // Get 1000 followers of 'kevin', 100 a time with random delay between requests
        dd($followers);
        echo '<pre>' . json_encode($followers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</pre>';



        /**
         * Associa cada seguidor a conta
         */
        $account = Account::create(
            [
            'username' => 'ricardosierra',
            'integration_id' => \Tramite\Spider\Integrations\Instagram\Instagram::$ID,
            // 'likes' => '43 pessoas curtiram'
            ]
        );
        $account->relations()->attach($account, ['relation_type' => 'followers']);
    }
}
