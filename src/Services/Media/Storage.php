<?php

namespace App\Services\Media;

use App\Services\Media\Utils\StoredMedia;
use Aws\S3\S3Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\Service\Attribute\Required;

class Storage
{

    #[Required]
    public LoggerInterface $logger;

    private Filesystem $filesystem;


    public function __construct(readonly public string $storageDir, public S3Client $s3Client)
    {
        $this->s3Client->registerStreamWrapper();
        $this->filesystem = new Filesystem();
        if ($this->filesystem->exists($storageDir) === false) {
            @$this->filesystem->mkdir($storageDir);
        }
    }

    private function createDestinationFromSignature(string $signature): string
    {
        $folderPrefix = substr($signature, 0, 2);
        $subFolderPrefix = substr($signature, 2, 2);
        return sprintf("%s/%s/%s/%s", $this->storageDir, $folderPrefix, $subFolderPrefix, $signature);
    }

    private function sign(string $content): string
    {
        return hash('sha256', $content);
    }

    public function store(string $content): StoredMedia
    {

        $signature = $this->sign($content);
        $destination = $this->createDestinationFromSignature($signature);

        if ($this->filesystem->exists($destination)) {
            $this->logger->notice("Media already exists: $destination");
            return new StoredMedia($destination, $signature);
        }

        @mkdir(dirname($destination), 0777, true);
        @file_put_contents($destination, $content);
        return new StoredMedia($destination, $signature);
    }

    public function read($path): string
    {
        return file_get_contents($path);
    }


}