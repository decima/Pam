<?php

namespace App\Services\Utils;

use Symfony\Component\Mime\MimeTypes;

class MimeTypeUtility
{

    private MimeTypes $mimeTypes;

    public function __construct()
    {
        $this->mimeTypes = new MimeTypes();
    }

    public function guessFromFile(\SplFileInfo $splFileInfo): string
    {
        $mime = $this->mimeTypes->guessMimeType($splFileInfo);
        if ($mime !== null) {
            return $mime;
        }

        $potentialMimes = $this->mimeTypes->getMimeTypes($splFileInfo->getExtension());
        if (empty($potentialMimes)) {
            return "application/octet-stream";
        }
        return $potentialMimes[0];

    }
}