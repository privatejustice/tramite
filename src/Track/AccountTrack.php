<?php
namespace Tramite\Track;

use Tramite\Contracts\Spider\Track;

/**
 * Run all script analysers and outputs their result.
 */
class AccountTrack extends Track
{

    public function run()
    {
        // Caso Seja Instagram
        if ($this->model->integration_id == \Tramite\Spider\Integrations\Instagram\Instagram::getPrimary()) {
            $this->addInformateArray(\Tramite\Spider\Integrations\Instagram\Profile::getProfile($this->model->username));
        }
        return true;
    }


}