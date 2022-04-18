<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\AssetRepository;
use App\Services\Media\Utils\StoredMedia;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AssetRepository::class)]
#[ApiResource(
    denormalizationContext: ['groups' => ['writeAsset']],
    normalizationContext: ['groups' => ['readAsset', "nested",'commons']],
)]
#[ApiFilter(SearchFilter::class, properties: ['category'=>'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['name'], arguments: ['orderParameterName' => 'order'])]
class Asset extends BaseEntity
{


    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['writeAsset', 'readAsset'])]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 1024)]
    #[Groups(['readAsset'])]
    private string $path;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'assets')]
    #[Groups(['writeAsset', 'readAsset'])]
    private ?Category $category;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'assets')]
    #[Groups(['writeAsset', 'readAsset'])]
    private Collection $tags;


    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups(['readAsset'])]
    private string $signature;

    #[ORM\Column(type: 'integer')]
    #[Groups(['readAsset'])]
    private ?int $size;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['writeAsset', 'readAsset'])]
    private ?string $importOrigin;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['readAsset'])]
    private $mimetype;


    public function __construct(?StoredMedia $storedMedia = null)
    {
        $this->tags = new ArrayCollection();
        parent::__construct();
        if ($storedMedia !== null) {
            $this->signature = $storedMedia->signature;
            $this->path = $storedMedia->filepath;
        }
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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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


    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getImportOrigin(): ?string
    {
        return $this->importOrigin;
    }

    public function setImportOrigin(?string $importOrigin): self
    {
        $this->importOrigin = $importOrigin;

        return $this;
    }

    public function getMimetype(): ?string
    {
        return $this->mimetype;
    }

    public function setMimetype(string $mimetype): self
    {
        $this->mimetype = $mimetype;

        return $this;
    }


}
