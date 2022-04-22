<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ApiResource]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'word_start'])]
class Tag extends BaseEntity
{


    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['nested'])]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['nested'])]
    private $color = "#000000";

    #[ORM\ManyToMany(targetEntity: Asset::class, mappedBy: 'tags')]
    private $assets;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'tags')]
    private $categories;

    public function __construct()
    {
        parent::__construct();
        $this->assets = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Asset>
     */
    public function getAssets(): Collection
    {
        return $this->assets;
    }

    public function addAsset(Asset $asset): self
    {
        if (!$this->assets->contains($asset)) {
            $this->assets[] = $asset;
            $asset->addTag($this);
        }

        return $this;
    }

    public function removeAsset(Asset $asset): self
    {
        if ($this->assets->removeElement($asset)) {
            $asset->removeTag($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addTag($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeTag($this);
        }

        return $this;
    }

}
