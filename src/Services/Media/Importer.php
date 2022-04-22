<?php

namespace App\Services\Media;

use App\Entity\Asset;
use App\Repository\AssetRepository;
use App\Services\Category\CategoryManager;
use App\Services\Media\Utils\Exceptions\DirectoryException;
use App\Services\Media\Utils\Exceptions\UnsupportedFileFormatException;
use App\Services\Utils\MimeTypeUtility;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Contracts\Service\Attribute\Required;

class Importer
{
    #[Required]
    public Storage $storage;
    #[Required]
    public EntityManagerInterface $entityManager;
    #[Required]
    public CategoryManager $categoryManager;
    #[Required]
    public AssetRepository $assetRepository;

    #[Required]
    public MimeTypeUtility $mimeTypeUtility;

    public function import(string $path): bool
    {
        $files = $this->scanFolder($path);
        $batchFlush = 0;
        foreach ($files as $file) {
            try {
                $asset = $this->createAsset($file);
            } catch (DirectoryException $directoryException) {
                continue;
            }catch (UnsupportedFileFormatException $unsupportedFileFormatException) {
                continue;
            }
            $this->entityManager->persist($asset);
            $batchFlush++;
            @unlink($file->getPathname());
            if ($batchFlush % 50 === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
                $batchFlush = 0;
            }
        }
        $this->entityManager->flush();

        return true;
    }

    /**
     * @param $directory
     * @return \Iterator<string, SplFileInfo>
     */
    public function scanFolder($directory): \Traversable
    {
        $finder = new Finder();
        $finder->files()->in($directory);
        return $finder;
    }

    const ALLOWED_EXTENSIONS = [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'bmp',
        'svg',
        'webp',
    ];

    /**
     * @throws DirectoryException
     */
    public function createAsset(SplFileInfo $file): ?Asset
    {
        if ($file->isDir()) {
            throw new DirectoryException($file);
        }
        if (!in_array(strtolower($file->getExtension()),self::ALLOWED_EXTENSIONS)) {
            throw new UnsupportedFileFormatException($file->getPathname());
        }

        $storedMedia = $this->storage->store($file->getContents());

        if (($asset = $this->assetRepository->findBySignature($storedMedia->signature)) !== null) {
            return $asset;
        }

        $category = $this->categoryManager->retrieveOrCreateCategoryFromPath(
            $file->getRelativePath(),
            $this->categoryManager->findOrCreateCategory("import")
        );

        return (new Asset($storedMedia))
            ->setName($file->getFilenameWithoutExtension())
            ->setSize($file->getSize())
            ->setImportOrigin($file->getRelativePath())
            ->setMimetype($this->mimeTypeUtility->guessFromFile($file))
            ->setCategory($category);
    }


}