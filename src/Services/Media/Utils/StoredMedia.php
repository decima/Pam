<?php

namespace App\Services\Media\Utils;

class StoredMedia
{

    public function __construct(
        readonly public string $filepath,
        readonly public string $signature)
    {
    }

}