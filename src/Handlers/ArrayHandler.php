<?php
use League\Pipeline\Pipeline;
class NumberHandler
{
    public function __invoke($value)
    {
        if (gettype($value) == 'float') {
            return round($value);
        }
        return $value;
    }
}