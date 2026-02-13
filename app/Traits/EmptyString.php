<?php

namespace App\Traits;

trait EmptyString
{
    public function isEmptyString($string): bool
    {
        return empty(trim($string));
    }
}