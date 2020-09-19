<?php

namespace Tramite\Events;

use App\Tramite;
use Illuminate\Queue\SerializesModels;

class TramiteShipped
{
    use SerializesModels;

    public $tramite;

    /**
     * Create a new event instance.
     *
     * @param  \App\Tramite $tramite
     * @return void
     */
    public function __construct(Tramite $tramite)
    {
        $this->tramite = $tramite;
    }
}