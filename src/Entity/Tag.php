<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\ApiPlatform\Filters\AssetsCountFilter;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [],
        'post'
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'word_start'])]
#[ApiFilter(AssetsCountFilter::class, properties: ['tags' => 'count'])]
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


    public function getForegroundColor()
    {
        $color = $this->getColor();
        [$red, $green, $blue] = sscanf($color, "#%02x%02x%02x");
        $luminance = ($red * 0.2126) + ($green * 0.7152) + ($blue * 0.0722);
        $newColor = ($luminance>179) ? "#000000" : "#ffffff";
        dump(sprintf('color %s, luminance %s, new color %s', $color, $luminance, $newColor));
        return $newColor;
    }
}
