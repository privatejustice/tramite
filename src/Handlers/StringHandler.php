<?php
use League\Pipeline\Pipeline;
class StringHandler
{
    public function __invoke($value)
    {
        if (gettype($value) == 'string') {
            return strtoupper($value);
        }
        return $value;
    }
}
