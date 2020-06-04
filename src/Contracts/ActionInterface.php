<?php

namespace Tramite\Contracts;

interface ActionInterface
{
    public function prepare();
    public function execute();
    public function done();
    public function run();
}