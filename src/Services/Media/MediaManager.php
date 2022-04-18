<?php

namespace App\Services\Media;

use Symfony\Contracts\Service\Attribute\Required;

class MediaManager
{
    #[Required]
    public Importer $importer;

    public function import(string $path): bool
    {
        return $this->importer->import($path);
    }
}