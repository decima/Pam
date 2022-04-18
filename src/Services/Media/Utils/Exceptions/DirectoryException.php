<?php

namespace App\Services\Media\Utils\Exceptions;

use Symfony\Component\Finder\SplFileInfo;

class DirectoryException extends \Exception
{

    public function __construct(public readonly SplFileInfo $splFileInfo)
    {
        parent::__construct("Cannot create asset from directory " . $splFileInfo->getRelativePathname());
    }

}