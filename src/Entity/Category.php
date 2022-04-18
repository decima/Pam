<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    attributes: ['filters' => ['parent']],
    denormalizationContext: ['groups' => ['write']],
    normalizationContext: ['groups' => ['read-group','commons']],
)]
#[ApiFilter(NumericFilter::class, properties: ['parent'])]
#[ApiFilter(ExistsFilter::class, properties: ['parent'])]
class Category extends BaseEntity
{


    public function __construct(
        #[ORM\Column(type: 'string', length: 255)]
        #[Groups(['write', 'read-group','nested'])]
        private string $name
    )
    {
        parent::__construct();

        $this->children = new ArrayCollection();
        $this->assets = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }


    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[Groups(["nested"])]
    private ?Category $parent;


    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    #[Groups(["read-group"])]
    private Collection $children;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Asset::class)]
    private Collection $assets;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'categories')]
    private Collection $tags;


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

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
            $asset->setCategory($this);
        }

        return $this;
    }

    public function removeAsset(Asset $asset): self
    {
        if ($this->assets->removeElement($asset)) {
            // set the owning side to null (unless already changed)
            if ($asset->getCategory() === $this) {
                $asset->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

}
