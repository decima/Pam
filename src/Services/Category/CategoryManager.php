<?php

namespace App\Services\Category;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class CategoryManager
{
    #[Required]
    public CategoryRepository $categoryRepository;
    #[Required]
    public EntityManagerInterface $entityManager;

    public function retrieveOrCreateCategoryFromPath(string $path, ?Category $baseCategory = null): Category
    {
        $exploded = explode("/", $path);
        foreach ($exploded as $categoryName) {
            $category = $this->findOrCreateCategory($categoryName);
            if ($baseCategory !== null) {
                $baseCategory->addChild($category);
                $baseCategory = $category;
            }
        }
        return $baseCategory;


    }

    public function findOrCreateCategory($name): Category
    {
        $category = $this->categoryRepository->findOneBy(['name' => $name]);
        if ($category === null) {
            $category = new Category($name);
            $this->entityManager->persist($category);
            $this->entityManager->flush($category);
        }
        return $category;
    }


}