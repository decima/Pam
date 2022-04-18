<?php

namespace App\Controller;

use App\Entity\Asset;
use App\Entity\Tag;
use App\Repository\TagRepository;
use App\Services\Media\Storage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route("/api/assets")]
class AssetController extends AbstractController
{

    #[Route("/{asset}/show")]
    public function show(Asset $asset, Storage $storage)
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $response = new Response(
            $storage->read($asset->getPath()),
            headers: [
                "Content-Type" => $asset->getMimetype(),
            ]
        );
        $response->setPublic();
        $response->setMaxAge(3600);

        // (optional) set a custom Cache-Control directive
        $response->headers->addCacheControlDirective('must-revalidate', true);


        return $response;
    }

    #[Route("/{asset}/tag/{tag}", methods: ["DELETE"])]
    public function detachTag(Asset $asset, Tag $tag, EntityManagerInterface $entityManager)
    {
        $asset->removeTag($tag);
        $entityManager->flush();

        if ($tag->getAssets()->count() === 0) {
            $entityManager->remove($tag);
        }

        $entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route("/{asset}/tag", methods: ["POST"])]
    public function addTag(Asset                  $asset,
                           Request                $request,
                           TagRepository          $tagRepository,
                           EntityManagerInterface $entityManager)
    {
        $tagName = $request->getContent();
        $tag = $tagRepository->findOneBy(["name" => $tagName]);
        if ($tag === null) {
            $tag = new Tag();
            $tag->setName($tagName);
            $entityManager->persist($tag);
        }
        $asset->addTag($tag);
        $entityManager->flush();

        return $this->json($tag);
    }


}